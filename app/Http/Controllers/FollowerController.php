<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    /**
     * Return the number of followers gained by the given user in
     * the past 30 days
     */
    public function gained()
    {
        $user_id = Auth::id();

        return Follower::select('id')->where([
            ['user_id', '=', $user_id],
            ['event_time', '>', Carbon::now()->subDays(30)],
        ])->count();
    }
}
