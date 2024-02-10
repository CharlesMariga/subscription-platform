<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/**
 * Test routes
 */
Route::apiResource('posts', PostController::class)->only('store');

// Subscribe
Route::post("websites/{id}/subscribe", ['uses' => "App\Http\Controllers\WebsiteController@subscribe"])
    ->where(['id' => '[0-9]+']);

// Publish task
Route::patch("posts/{id}/publish", ['uses' => 'App\Http\Controllers\PostController@publish' ]);