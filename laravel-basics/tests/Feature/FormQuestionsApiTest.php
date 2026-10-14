<?php

namespace Tests\Feature;

use App\Models\FormQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormQuestionsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_questions_ordered_by_sort_order(): void
    {
        FormQuestion::query()->create([
            'question' => 'Second question?',
            'type' => 'text',
            'is_required' => false,
            'sort_order' => 2,
        ]);

        FormQuestion::query()->create([
            'question' => 'First question?',
            'type' => 'select',
            'options' => ['Yes', 'No'],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        $this->getJson('/api/form-questions')
            ->assertOk()
            ->assertJsonPath('0.question', 'First question?')
            ->assertJsonPath('0.options', ['Yes', 'No'])
            ->assertJsonPath('0.is_required', true)
            ->assertJsonPath('1.question', 'Second question?');
    }
}
