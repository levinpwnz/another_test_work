<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Resources\Post\PostsByUserResource;
use App\Repo\PostRepository;
use Illuminate\Support\Facades\Auth;

class UsersController
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function index()
    {
        return PostsByUserResource::collection(
            $this->postRepository->fetchByUser(Auth::user())
        )->response();
    }
}
