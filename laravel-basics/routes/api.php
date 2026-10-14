

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormQuestionController;
use App\Http\Controllers\Api\FormResponseController;

Route::get('/form-questions', [
    FormQuestionController::class,
    'index',
]);

Route::post('/form-responses', [
    FormResponseController::class,
    'store',
]);

Route::get('/form-responses', [
    FormResponseController::class,
    'index',
]);