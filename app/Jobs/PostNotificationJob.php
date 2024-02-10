<?php

namespace App\Jobs;

use App\Mail\PostNotification;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $websiteId;
    public $post;
    /**
     * Create a new job instance.
     */
    public function __construct($websiteId, $post)
    {
        $this->websiteId = $websiteId;
        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscriptions = Subscription::where('website_id', $this->websiteId)->get();
        foreach($subscriptions->toArray() as $subscription) {
            $user = User::where(['id' => $subscription['user_id']])->get();
            Mail::to($user[0]->email)->send(new PostNotification($this->post->title, $this->post->description));
        }
    }
}
