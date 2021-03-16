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
        $except_post_id = $request->query('except') ?? null;
        $limit = $request->query('limit');

        if ($except_post_id == null) {
            $blogs = Blog::where('user_id', $user->id)
                            ->latest()->with('user')->paginate($limit)
                            ->appends(['limit' => $limit]);
        }
        else {
            $blogs = Blog::where('user_id', $user->id)
                            ->where('id', '!=', $except_post_id)
                            ->latest()->with('user')->paginate($limit)
                            ->appends(['except' => $except_post_id, 'limit' => $limit]);
        }

        
        return BlogResource::collection($blogs);
    }
}
