<?php

namespace App\Http\Controllers\Api;

use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowerResource;

class FollowingController extends Controller
{
    /**
     * Display the list of specified following resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $following = Follower::where('follower_id', $id)->latest()->get();

        return FollowerResource::collection($following);
    }
}
