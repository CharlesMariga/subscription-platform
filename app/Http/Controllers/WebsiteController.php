<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function subscribe($websiteId) {
        // 1. Check whether the user is subscribed to that website
        $userId = request()['user_id'];
        $subscription = Subscription::where(['user_id' => $userId, 'website_id' => $websiteId])->get();
        
        if (!$subscription->isEmpty()) return response()->json([
            'statu' => 'failed',
            'message' => 'User already subscribed'
        ], 403);

        // 2. Check whether the website exists
        $website = Website::where('id', $websiteId)->get();

        if ($website->isEmpty()) {
            return response()->json([ 
                'status' => 'failed',
                'message' => "Website not found"
            ], 404);
        }
        
        // 3. Check whether the user exists
        $user = User::where('id', $userId)->get();

        if ($user->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => "User not found"
            ], 404);
        }

        // 4. If both user and website exist, subscribe
        $newSubscription = [
            'user_id' => $userId,
            'website_id' => $websiteId
        ];
        Subscription::create($newSubscription);

        return response()->json([
            "status" => 'success',
            'message' => "User has been subscribed"
        ], 200);
    }
}
