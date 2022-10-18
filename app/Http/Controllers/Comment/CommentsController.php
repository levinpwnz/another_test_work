<?php

declare(strict_types=1);

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Service\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct(private readonly CommentService $commentService)
    {
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $this->commentService->store($request->validated(), Auth::user());

        return response()->json(status: 204);
    }

    public function update(Comment $comment, UpdateCommentRequest $request): JsonResponse
    {
        if (!$comment->user()->is(Auth::user())) {
            return response()->json(status: 403);
        }

        $this->commentService->update($request->get('comment'), $comment);

        return response()->json(status: 201);
    }
}
