<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function store(array $data, User $user): Post
    {
        return $user
            ->posts()
            ->create($data);
    }

    public function update(Post $post, array $data): Post
    {
        return tap($post)->update($data);
    }
}
