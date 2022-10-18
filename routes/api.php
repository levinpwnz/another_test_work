<?php

declare(strict_types=1);

use App\Http\Controllers\Comment\CommentsController;
use App\Http\Controllers\Post\PostsController;
use App\Http\Controllers\User\UsersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UsersController::class)->only('index');
Route::apiResource('posts', PostsController::class)->only('index', 'store', 'update');
Route::apiResource('comments', CommentsController::class)->only('store', 'update');
