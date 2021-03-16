<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit');

        $blogs = Blog::orderBy('view_count', 'DESC')->with('user')->paginate($limit)->appends(['limit' => $limit]);

        return BlogResource::collection($blogs);
    }

    /**
     * Display the specified blog resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BlogResource(Blog::findOrFail($id));
    }

    /**
     * Display the specified blog resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_view_count($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->update([
            'view_count' => $blog->view_count + 1
        ]);

        return ['view_count' => $blog->view_count];
    }
}
