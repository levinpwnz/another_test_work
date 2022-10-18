<?php

declare(strict_types=1);

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostsByUserResource;
use App\Http\Resources\Post\PostsResource;
use App\Models\Post;
use App\Repo\PostRepository;
use App\Service\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly PostRepository $postRepository
    ) {
    }

    public function index(): JsonResponse
    {
        return PostsResource::collection(
            $this->postRepository->fetchAll()
        )->response();
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        return PostResource::make(
            $this->postService
                ->store($request->validated(), Auth::user())
        )->response();
    }

    public function update(Post $post, UpdatePostRequest $request): JsonResponse
    {
        if (!$post->user()->is(Auth::user())) {
            return response()->json(status: 403);
        }

        $this->postService
            ->update($post, $request->validated());

        return response()->json(status: 201);
    }
}
