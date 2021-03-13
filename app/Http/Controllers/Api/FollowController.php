<?php

namespace App\Http\Controllers\Api;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowerResource;

class FollowController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $follower_is_following = Follower::where(['follower_id' => $request->follower_id, 'user_id' => $user_id])->first();

        $user_is_following = Follower::where(['follower_id' => $user_id, 'user_id' => $request->follower_id])->first();

        if (empty($follower_is_following)) {
            Follower::create([
                'follower_id' => $request->follower_id,
                'user_id' => $user_id
            ]);

            $follow_text = 'Unfollow';
        }
        else {
            Follower::where(['follower_id' => $request->follower_id, 'user_id' => $user_id])->delete();

            if ($user_is_following) { $follow_text = 'Follow back'; }
            else { $follow_text = 'Follow'; }
        }

        return response(['error' => false, 'text' => $follow_text]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $follower_id)
    {
        $follower_follows = Follower::where(['follower_id' => $follower_id, 'user_id' => $user_id])->first();

        $user_follows = Follower::where(['follower_id' => $user_id, 'user_id' => $follower_id])->first();
        
        if ($follower_follows) { $follow_text = 'Unfollow'; }
        elseif ($user_follows) { $follow_text = 'Follow back'; }
        else { $follow_text = 'Follow'; }

        return response(['error' => false, 'text' => $follow_text]);
    }
}
