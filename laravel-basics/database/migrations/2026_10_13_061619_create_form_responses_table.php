
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();

            // Groups answers from one form submission
            $table->uuid('submission_id')->index();

            // Links the answer to a question
            $table->foreignId('form_question_id')
                ->constrained('form_questions')
                ->cascadeOnDelete();

            // Stores the user's answer
            $table->text('answer')->nullable();

            $table->timestamps();

            // One answer per question in each submission
            $table->unique([
                'submission_id',
                'form_question_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_responses');
    }
};




