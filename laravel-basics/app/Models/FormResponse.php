<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\FormQuestion;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;




class FormResponseController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => FormResponse::with('question')->latest()->get(),
        ]);
    }

    // Save a form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.form_question_id' => [
                'required',
                'integer',
                'distinct',
                'exists:form_questions,id',
            ],
            'answers.*.answer' => ['nullable'],
        ]);

        $submissionId = (string) Str::uuid();

        $responses = DB::transaction(function () use (
            $validated,
            $submissionId
        ) {
            $saved = [];

            foreach ($validated['answers'] as $item) {
                $question = FormQuestion::findOrFail(
                    $item['form_question_id']
                );

                $answer = $item['answer'] ?? null;

                if (
                    $question->is_required &&
                    ($answer === null || $answer === '')
                ) {
                    abort(
                        422,
                        'Answer required for: ' . $question->question
                    );
                }

                $saved[] = FormResponse::create([
                    'submission_id' => $submissionId,
                    'form_question_id' => $question->id,
                    'answer' => is_array($answer)
                        ? json_encode($answer)
                        : $answer,
                ]);
            }

            return $saved;
        });

        return response()->json([
            'success' => true,
            'message' => 'Form response saved successfully',
            'submission_id' => $submissionId,
            'data' => $responses,
        ], 201);
    }
}