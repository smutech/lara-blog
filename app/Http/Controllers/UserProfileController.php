<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username = null)
    {
        if ($username == null)
        {
            $profile = auth()->user();
            if ($profile == null) { abort(404); }

            $post_count = Blog::where('user_id', $profile->id)->count();
            $follower_count = Follower::where('user_id', $profile->id)->count();
            $following_count = Follower::where('follower_id', $profile->id)->count();
        }
        else {
            $profile = User::where('username', $username)->first();
            if ($profile == null) { abort(404); }

            $post_count = Blog::where('user_id', $profile->id)->count();
            $follower_count = Follower::where('user_id', $profile->id)->count();
            $following_count = Follower::where('follower_id', $profile->id)->count();
        }

        return view('user.profile', [
            'profile' => $profile,
            'post_count' => $post_count,
            'follower_count' => $follower_count,
            'following_count' => $following_count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($username = null)
    {
        $user = auth()->user();

        return view('user.edit-profile', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image',
            ]);

            $profile_image = $request->file('avatar')->store('public/profile_images');

            auth()->user()->update(['profile_image' => $profile_image]);
        }


        $username = auth()->user()->username;
        $email = auth()->user()->email;

        $request->validate([
            'name' => 'required|min:3',
            'username' => [
                'required',
                'min:3',
                Rule::unique('App\Models\User')->ignore($username, 'username')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('App\Models\User')->ignore($email, 'email')
            ]
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email
        ]);
        
        return redirect()->route('edit-profile')
                        ->with('profile_success_message', 'Your profile has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
