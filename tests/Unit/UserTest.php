<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testIndexAction(): void
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

        $authRequest = $this->actingAs($user);

        $response = $authRequest->json('POST', 'api/v1/posts', [
            'title' => $title = $this->faker->text(),
            'body' => $this->faker->text()
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => $title
        ]);

        $postId = $response->json('data.id');

        $authRequest->postJson('api/v1/comments', [
            'post_id' => $postId,
            'body' => $this->faker->text()
        ]);

        $authRequest = $this->actingAs($userTwo);

        $authRequest->postJson('api/v1/comments', [
            'post_id' => $postId,
            'body' => $this->faker->text()
        ]);

        $authRequest = $this->actingAs($user);

        $response = $authRequest->get('api/v1/posts');

        $response->assertOk();
    }
}
