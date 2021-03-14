<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class UserPostsController extends Controller
{
    /**
     * Display a listing of the user post resource.
     *
     * @return \Illuminate\Http\Request $request
     * @return \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $limit = $request->query('limit');

        $blogs = Blog::where('user_id', $user->id)->latest()->with('user')->paginate($limit)->appends(['limit' => $limit]);
        
        return BlogResource::collection($blogs);
    }
}
