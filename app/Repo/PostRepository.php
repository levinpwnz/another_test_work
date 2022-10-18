<?php

declare(strict_types=1);

namespace App\Repo;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;

class PostRepository
{
    public function fetchAll(): Collection
    {
        return Post::with([
            'comments',
            'user'
        ])->get();
    }

    public function fetchByUser(User $user): Collection
    {
        return $user->posts()
            ->with(['comments' => static fn($query) => $query->commentForUser($user->id)])
            ->get();
    }
}
