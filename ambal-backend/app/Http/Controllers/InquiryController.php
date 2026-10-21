<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): JsonResponse
    {
        $inquiry = Inquiry::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully.',
            'data' => $inquiry,
        ], 201);
    }
}