<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $question = Question::findOrFail(request()->questionId);
        if ($question->question_type == 'graph') {
            return [
                'scalar_value' => 'required|numeric|min:0|max:5',
            ];
        }
        return [
            'answer' => 'required'
        ];
    }

}
