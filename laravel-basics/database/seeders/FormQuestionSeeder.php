<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question' => 'What is your name?',
                'type' => 'text',
                'options' => null,
                'is_required' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'What is your email address?',
                'type' => 'email',
                'options' => null,
                'is_required' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'Which topic are you interested in?',
                'type' => 'select',
                'options' => json_encode(['Laravel', 'PHP', 'Databases'], JSON_THROW_ON_ERROR),
                'is_required' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($questions as $question) {
            DB::table('form_questions')->updateOrInsert(
                ['question' => $question['question']],
                [...$question, 'updated_at' => now(), 'created_at' => now()],
            );
        }

        $submissionId = '11111111-1111-4111-8111-111111111111';
        $answers = [
            'What is your name?' => 'Alex Example',
            'What is your email address?' => 'alex@example.com',
            'Which topic are you interested in?' => 'Laravel',
        ];

        foreach ($answers as $questionText => $answer) {
            $questionId = DB::table('form_questions')
                ->where('question', $questionText)
                ->value('id');

            DB::table('form_responses')->updateOrInsert(
                [
                    'submission_id' => $submissionId,
                    'form_question_id' => $questionId,
                ],
                ['answer' => $answer, 'updated_at' => now(), 'created_at' => now()],
            );
        }
    }
}
