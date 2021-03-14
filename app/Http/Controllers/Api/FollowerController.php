<?php

namespace App\Http\Controllers\Api;

use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowingResource;

class FollowerController extends Controller
{
    /**
     * Display the list of specified follower resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $followers = Follower::where('user_id', $id)->latest()->get();

        return FollowingResource::collection($followers);
    }
}
