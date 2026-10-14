<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => ['required', 'array', 'min:1'],

            'answers.*.form_question_id' => [
                'required',
                'integer',
                'distinct',
                'exists:form_questions,id',
            ],

            'answers.*.answer' => ['nullable'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $answers = $this->input('answers', []);

            foreach ($answers as $index => $item) {
                $questionId = $item['form_question_id'] ?? null;
                $answer = $item['answer'] ?? null;

                $question = \App\Models\FormQuestion::find($questionId);

                if (!$question) {
                    continue;
                }

                if (
                    $question->is_required &&
                    (!is_string($answer) || trim($answer) === '')
                ) {
                    $validator->errors()->add(
                        "answers.$index.answer",
                        "The {$question->question} field is required."
                    );

                    continue;
                }

                if ($answer === null || $answer === '') {
                    continue;
                }

                if (!is_string($answer)) {
                    $validator->errors()->add(
                        "answers.$index.answer",
                        'The answer must be text.'
                    );

                    continue;
                }

                if ($question->type === 'text' &&
                    !preg_match("/^[\p{L}]+(?:[ '-][\p{L}]+)*$/u", $answer)) {
                    $validator->errors()->add(
                        "answers.$index.answer",
                        'The name must contain only letters and spaces.'
                    );
                }
                 if ($question->type === 'email' &&
                    !filter_var($answer, FILTER_VALIDATE_EMAIL)) {
                    $validator->errors()->add(
                        "answers.$index.answer",
                        'Please enter a valid email address.'
                    );
                }

                if ($question->type === 'select' &&
                    !in_array($answer, $question->options ?? [], true)) {
                    $validator->errors()->add(
                        "answers.$index.answer",
                        'Please select a valid option.'
                    );
                }
            }
        });
    }
}
