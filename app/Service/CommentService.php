<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;

class CommentService
{
    public function store(array $data, User $user): Comment
    {
        /** @var Post $post */
        $post = Post::query()
            ->firstWhere('id', Arr::get($data, 'post_id'));

        /** @var Comment $comment */
        $comment = (new Comment())
            ->setAttribute('body', Arr::get($data, 'body'));

        $comment->user()
            ->associate($user);

        $comment->post()
            ->associate($post);

        return tap($comment)->save();
    }

    public function update(string $body, Comment $comment): Comment
    {
        return tap($comment)->update([
            'body' => $body
        ]);
    }
}
