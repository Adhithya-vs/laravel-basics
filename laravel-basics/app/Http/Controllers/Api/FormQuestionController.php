<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormQuestion;

class FormQuestionController extends Controller
{
    public function index()
    {
        $questions = FormQuestion::orderBy('sort_order')->get([
            'id',
            'question',
            'type',
            'options',
            'is_required',
            'sort_order',
        ]);

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }
}