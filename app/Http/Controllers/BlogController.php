<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::latest()->with('user')->paginate(15);

        return view('blogs.index', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = auth()->user()->post()->create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image'
            ]);

            $image = $request->file('image')->store('public/blog_images');

            $post->update(['image' => $image]);
        }

        return redirect()->route('blogs')
                        ->with('blog_success_message', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blogs.show', [
            'blog' => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', [
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $blog->update([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image'
            ]);

            $image = $request->file('image')->store('public/blog_images');

            $blog->update(['image' => $image]);
        }

        return redirect()
                ->route('edit-blog', Str::slug($request->title))
                ->with('blog_success_message', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs')
                        ->with('blog_success_message', 'Blog deleted successfully');
    }
}
