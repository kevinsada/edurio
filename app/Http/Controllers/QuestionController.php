<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return QuestionResource::collection(Question::all());
    }

    public function store(AnswerRequest $request, $questionId)
    {
        try {
            //merge the validated request and the param question ID.
            $validated = $request->validated();
            $validated['question_id'] = $questionId;
            Answer::create($validated);
            return response()->json('Answer created successfully!');
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return response()->json('Error! Please refresh the page and try again.');
        }
    }

    public function statistics(): JsonResponse
    {
        $graphQuestions = Question::withCount('answers as answers_count')->where('question_type', 'graph')->get();

        //this query will serve for answers per question option
        $groupedQuestions = Answer::select('question_id', 'scalar_value', DB::raw('count(*) as count'))
            ->whereIn('question_id', $graphQuestions->pluck('id'))
            ->groupBy('question_id', 'scalar_value')
            ->orderBy('question_id', 'asc')
            ->orderBy('scalar_value', 'asc')
            ->get();
        $questionAverageResults = [];
        $questionAnswersCount = [];
        $answersPerQuestionOption = [];
        foreach ($graphQuestions as $graphQuestion) {
            //Question average
            $questionAverageResults[] = [
                'question' => $graphQuestion->question,
                'avg' => $graphQuestion->answers()->avg('scalar_value')
            ];

            //Question answers count
            $questionAnswersCount[] = [
                'question' => $graphQuestion->question,
                'answers_count' => $graphQuestion->answers_count
            ];

            //Answers per question option
            $questionData = $groupedQuestions->where('question_id', $graphQuestion->id);

            $answers = [];
            //Iterate over each to add the scalar value and count
            $questionData->each(function ($row) use (&$answers) {
                $answers[] = [
                    'scalar_value' => $row->scalar_value,
                    'count' => $row->count
                ];
            });

            $answersPerQuestionOption[] = [
                'question' => $graphQuestion->question,
                'answers' => $answers
            ];
        }
        //format graph questions data
        $graphQuestionResults = [
            'question_average_results' => $questionAverageResults,
            'question_answers_count' => $questionAnswersCount,
            'answers_per_question_option' => $answersPerQuestionOption
        ];

        //free answers question
        $freeAnswerQuestion = Question::withCount('answers as answers_count')->where('question_type', 'free_text')->first();
        $freeAnswerQuestionResult['question_answers_count'] = $freeAnswerQuestion->answers_count;
        $freeAnswerQuestionResult['word_cloud'] = $this->wordCloud();

        $results = [
            'graph_questions' => $graphQuestionResults,
            'free_answer_question' => $freeAnswerQuestionResult
        ];

        return response()->json(['data' => $results]);
    }

    public function wordCloud()
    {
        //GROUP_CONCAT serves to merge all rows into one in this case, answer.
        $mergedAnswer = Answer::whereNotNull('answer')->selectRaw('GROUP_CONCAT(answer) as answer')->first()->answer;
        //we convert each word from the concatenated string into arrays
        $words = explode(" ", $mergedAnswer);

        $wordCount = [];
        foreach ($words as $word) {
            //if the word exists we add the counter
            if (array_key_exists($word, $wordCount)) {
                $wordCount[$word]++;
            } else {
                //if not we initialize it with 1
                $wordCount[$word] = 1;
            }
        }
        //sort the array from value descending while preserving the keys.
        arsort($wordCount);
        //return top 3
        return array_slice($wordCount, 0, 3, true);
    }


}
