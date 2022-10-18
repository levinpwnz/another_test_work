<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function testIndexAction(): void
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

        $authRequest = $this->actingAs($user);

        $response = $authRequest->postJson('api/v1/posts', [
            'title' => $title = $this->faker->text(),
            'body' => $this->faker->text()
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => $title
        ]);

        $authRequest->postJson('api/v1/comments', [
            'post_id' => $response->json('data.id'),
            'body' => $this->faker->text()
        ]);

        $authRequestUserTwo = $this->actingAs($userTwo);

        $authRequestUserTwo->postJson('api/v1/comments', [
            'post_id' => $response->json('data.id'),
            'body' => $this->faker->text()
        ]);

        $authRequest = $this->actingAs($user);

        $response = $authRequest->getJson('api/v1/posts');

        $response->assertStatus(200);
    }

    public function testStoreAction(): void
    {
        $user = User::factory()->create();

        $authRequest = $this->actingAs($user);

        $response = $authRequest->postJson('api/v1/posts', [
            'title' => $title = $this->faker->text(),
            'body' => $this->faker->text()
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => $title
        ]);

        $response->assertStatus(201);
    }

    public function testUpdateAction(): void
    {
        $user = User::factory()->create();

        $authRequest = $this->actingAs($user);

        $response = $authRequest->postJson('api/v1/posts', [
            'title' => $title = $this->faker->text(),
            'body' => $this->faker->text()
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'title' => $title
        ]);

        $newTitle = 'Test title';

        $postId = $response->json('data.id');

        $response = $authRequest->post("api/v1/posts/$postId", [
            'title' => $newTitle,
            'body' => $this->faker->text(),
            '_method' => 'put'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'title' => $newTitle
        ]);
    }
}
