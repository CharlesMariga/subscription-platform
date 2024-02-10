<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Jobs\PostNotificationJob;
use App\Mail\PostNotification;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        return Post::create($request->toArray());
    }

    public function publish($postId) {
        $post = Post::where('id', $postId)->get();


        if ($post->isEmpty()) return response()->json([
            'status' => 'fail',
            'message' => 'Post not found'
        ],404);

        if ($post[0]->publish_date) return response()->json([
            'status' => 'fail',
            'message' => 'Post is already published'
        ],403);


        Post::where('id', $postId)->update(['publish_date' =>  Carbon::now()->toDateTimeString() ]);

        dispatch(new PostNotificationJob($post[0]->website_id, $post[0]));

        return response()->json(Post::where('id', $postId)->get(), 200);
    }
}
