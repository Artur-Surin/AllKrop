<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Place;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Place $place): JsonResponse
    {
        $place->allReviews()->create([
            'name' => $request->validated('name'),
            'rating' => $request->validated('rating'),
            'comment' => $request->validated('comment'),
            'is_approved' => false,
        ]);

        return response()->json(['success' => true]);
    }
}
