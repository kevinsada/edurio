<?php

namespace Tests\Unit;

use App\Http\Controllers\QuestionController;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Question::create([
                'question' => substr(fake()->realText, 0, -1) . ' ?',
                'question_type' => $i < 9 ? 'graph' : 'free_text'
            ]);
        }

        $questionController = new QuestionController();
        $data = $questionController->index();

        $this->assertCount(100, $data);

        $questions = collect($data);
        $this->assertCount(9, $questions->where('question_type', 'graph'));
        $this->assertCount(91, $questions->where('question_type', 'free_text'));

        $this->assertNotCount(101, $questions);
    }

    public function test_store()
    {
        //graph
        $question = $this->storeQuestion('graph');
        $data = [
            'scalar_value' => 4
        ];
        $response = $this->post('/api/questions/' . $question->id . '/answer', $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Answer created successfully!']);

        //free_text
        $question = $this->storeQuestion('free_text');

        $data = [
            'answer' => 4
        ];
        $response = $this->post('/api/questions/' . $question->id . '/answer', $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Answer created successfully!']);

        //validation error
        $question = $this->storeQuestion('free_text');

        $response = $this->post('/api/questions/' . $question->id . '/answer');
        $response->assertSessionHasErrors([
            'answer' => 'The answer field is required.'
        ]);
    }

    public function storeQuestion($type)
    {
        return Question::create([
            'question' => substr(fake()->realText, 0, -1) . ' ?',
            'question_type' => $type
        ]);
    }

    public function test_statistics()
    {
        //create fake question & answers to test its behaviour
        $graphQuestion1 = Question::create([
            'question' => 'First graph question',
            'question_type' => 'graph'
        ]);

        $freeTextQuestion = Question::create([
            'question' => 'First free text question',
            'question_type' => 'free_text'
        ]);

        Answer::create([
            'question_id' => $graphQuestion1->id,
            'scalar_value' => 2
        ]);

        Answer::create([
            'question_id' => $graphQuestion1->id,
            'scalar_value' => 5
        ]);

        Answer::create([
            'question_id' => $freeTextQuestion->id,
            'answer' => 'I am am repeating repeating repeating repeating the the the the the the words in purpose for the word cloud'
        ]);

        $response = $this->get('/api/questions/statistics');
        $response->assertStatus(200);
        $data = $response->getData();

        //GRAPH QUESTION ANSWERS
        //assert question_average_results is 3.5; (2 + 5)/2 = 3.5
        $this->assertEquals(3.5, $data->data->graph_questions->question_average_results[0]->avg);
        //assert question_answers_count = 2
        $this->assertEquals(2, $data->data->graph_questions->question_answers_count[0]->answers_count);
        //assert answers_per_question_option = 1
        $this->assertEquals(1, $data->data->graph_questions->answers_per_question_option[0]->answers[0]->count);

        //FREE TEXT QUESTION ANSWERS
        //assert question_answers_count = 1
        $this->assertEquals(1, $data->data->free_answer_question->question_answers_count);
        //assert top 3 words are 7 for word "the", 4 for word "repeating", 2 for word "am"
        $this->assertEquals(7, $data->data->free_answer_question->word_cloud->the);
        $this->assertEquals(4, $data->data->free_answer_question->word_cloud->repeating);
        $this->assertEquals(2, $data->data->free_answer_question->word_cloud->am);
    }
}
