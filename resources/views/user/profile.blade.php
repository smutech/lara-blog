<x-app-layout metaTitle="{{$profile->name}} | profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @auth
                @if (auth()->user()->username == $profile->username)
                    My profile
                @else
                    Profile
                @endif
            @endauth

            @guest
                Profile
            @endguest
        </h2>
    </x-slot>

    <!-- Followers -->
    <div id="follower-box" class="hidden fixed top-36 mt-1.5 right-0 bottom-0 left-0 mx-auto my-auto bg-white h-2/3 w-80 min-w-63 max-w-full overflow-hidden border border-gray-200 shadow-lg rounded">
        <div class="flex justify-between items-center bg-gray-50 px-4 py-2 border-b">
            <h1 class="text-gray-600 text-xl font-bold pt-1">
                Followers
            </h1>
            <button id="hide-follower-box-btn" class="text-gray-700 hover:opacity-60 text-2xl font-bold -mr-3 px-2.5">
                &times;
            </button>
        </div>

        <div id="follower-list" class="overflow-auto" style="height: calc(100% - 3rem);"></div>
    </div>

    <!-- Following -->
    <div id="following-box" class="hidden fixed top-36 mt-1.5 right-0 bottom-0 left-0 mx-auto my-auto bg-white h-2/3 w-80 min-w-63 max-w-full overflow-hidden border border-gray-200 shadow-lg rounded">
        <div class="flex justify-between items-center bg-gray-50 px-4 py-2 border-b">
            <h1 class="text-gray-600 text-xl font-bold pt-1">
                Following
            </h1>
            <button id="hide-following-box-btn" class="text-gray-700 hover:opacity-60 text-2xl font-bold -mr-3 px-2.5">
                &times;
            </button>
        </div>

        <div id="following-list" class="overflow-auto" style="height: calc(100% - 3rem);"></div>
    </div>


    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col justify-center">
                        <div class="flex justify-center items-center py-5">
                            <div for="avatar-upload" class="rounded-full shadow overflow-hidden h-40 w-40 bg-gray-700 text-white cursor-pointer">
                                <img src="{{ $profile->profile_image == null ? '/assets/images/user placeholder.png' : Storage::url($profile->profile_image) }}" class="h-40 w-40" style="object-fit: cover;" alt="{{ $profile->name }}'s avatar">
                            </div>
                        </div>

                        @auth
                            @if (auth()->user()->username == $profile->username)
                                <div class="text-center text-lg py-1 pb-2">
                                    <a href="{{ route('edit-profile') }}" class="text-blue-500 hover:text-blue-800 focus:text-blue-800 focus:outline-none">Edit profile</a>
                                </div>
                            @endif
                        @endauth

                        <div class="text-center text-3xl font-light mt-1">
                            {{ $profile->name }}

                            @auth
                                @if (auth()->user()->username == $profile->username)
                                    <span class="text-bold ml-2">(Me)</span>
                                @endif
                            @endauth
                        </div>

                        <div class="text-center text-xl py-2">
                            {{ $profile->username }}
                        </div>

                        <div class="text-center">
                            @if (auth()->check() && ($profile->id != auth()->id()))
                                <button id="follow-btn" class="bg-blue-500 text-white text-lg max-w-full outline-none my-3 px-5 pt-1.5 pb-1 rounded hidden">Follow</button>
                            @endif
                        </div>
                        
                        <ul class="flex justify-center items-center text-xl py-2">
                            <li class="mx-2">
                                {{ $post_count }}
                                {{ $post_count > 1 ? 'posts' : 'post' }}
                            </li>
                            <li id="follower_count" class="hover:text-gray-600 mx-2 cursor-pointer">
                                {{ $follower_count }}
                                {{ $follower_count > 1 ? 'followers' : 'follower' }}
                            </li>
                            <li id="following_count" class="hover:text-gray-600 mx-2 cursor-pointer">{{ $following_count }} following</li>
                        </ul>

                        <div class="flex justify-center items-center text-gray-600 text-lg py-2">
                            Joined {{ $profile->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let follow_btn = document.getElementById('follow-btn');

        @if (auth()->check() && $profile->id != auth()->id())

            // Check if authenticated user follows current blog post user or not
            let show_follow_status_api_url = '{{ route('show-follow-status', [ $profile->id, auth()->id() ]) }}';

            fetch(show_follow_status_api_url)
                .then(res => res.json())
                .then(follow => {
                    follow_btn.classList.remove('hidden')
                    follow_btn.innerText = follow.text;
                })
                .catch(err => console.error(err));

            
            // Follow user
            follow_btn.addEventListener('click', () => {
                const data = {
                    follower_id: {{ auth()->id() ?? 'null' }}
                };

                let options = {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: new Headers({
                        'Content-Type': 'application/json'
                    })
                };

                let follow_user_api_url = '{{ route('follow-user', $profile->id) }}';

                fetch(follow_user_api_url, options)
                    .then(res => res.json())
                    .then(follow => {
                        if (follow.error) { console.error('Error following.'); }
                        else {
                            follow_btn.innerText = follow.text;
                            follow_btn.blur();
                        }
                    })
                    .catch(err => console.error(err));
            });
        @endif

        // Show follower box and load the list of followers
        let follower_box = document.getElementById('follower-box');
        let hide_follower_box_btn = document.getElementById('hide-follower-box-btn');
        let follower_list = document.getElementById('follower-list');
        let followers_loaded = false;

        document.getElementById('follower_count')
            .addEventListener('click', () => {
                follower_box.classList.remove('hidden');
                hide_follower_box_btn.focus();

                if (! followers_loaded)
                {
                    follower_list.innerHTML = `<div class="text-gray-700 text-xl text-center py-5">Loading...</div>`;

                    let followers_list_api_url = '{{ route('followers', $profile->id) }}';

                    fetch(followers_list_api_url)
                        .then(res => res.json())
                        .then(followers => {
                            follower_list.innerHTML = '';

                            if (followers.data.length > 0)
                            {
                                followers.data.forEach(follower => {
                                    follower_item = `
                                        <a href="/profile/${follower.user.username}" class="flex justify-between items-center hover:bg-gray-100 border-b border-gray-100 px-3 py-2">
                                            <div class="flex justify-start items-start">
                                                <img src="${follower.user.profile_image}" class="block bg-gray-200 h-14 w-14 border border-gray-200 overflow-hidden" style="border-radius: 50%;">
                                                <div class="pl-2.5 pr-1">
                                                    <div class="text-gray-800 hover:text-gray-900 font-semibold text-lg overflow-hidden whitespace-nowrap w-32">${follower.user.name}</div>
                                                    <span class="text-gray-600 hover:text-gray-700">${follower.user.username}</span>
                                                </div>
                                            </div>
                                            <button id="profile-btn" class="bg-blue-500 text-white px-3 py-1 rounded">
                                                Profile
                                            </button>
                                        </a>
                                    `;
    
                                    follower_list.innerHTML += follower_item;
                                });
                            }
                            else {
                                follower_list.innerHTML = `<div class="text-gray-700 text-xl text-center py-5">No followers.</div>`;
                            }

                            followers_loaded = true;
                        })
                        .catch(err => console.error(err));
                }
            });

        // Close follower box
        hide_follower_box_btn.addEventListener('click', () => follower_box.classList.add('hidden'));

        
        // Show following box and load the list of following
        let following_box = document.getElementById('following-box');
        let hide_following_box_btn = document.getElementById('hide-following-box-btn');
        let following_list = document.getElementById('following-list');
        let following_loaded = false;

        document.getElementById('following_count')
            .addEventListener('click', () => {
                following_box.classList.remove('hidden');
                hide_following_box_btn.focus();

                if (! following_loaded)
                {
                    following_list.innerHTML = `<div class="text-gray-700 text-xl text-center py-5">Loading...</div>`;

                    let following_list_api_url = '{{ route('following', $profile->id) }}';

                    fetch(following_list_api_url)
                        .then(res => res.json())
                        .then(following => {
                            following_list.innerHTML = '';

                            if (following.data.length > 0)
                            {
                                following.data.forEach(following => {
                                    following_item = `
                                        <a href="/profile/${following.user.username}" class="flex justify-between items-center hover:bg-gray-100 border-b border-gray-100 px-3 py-2">
                                            <div class="flex justify-start items-start">
                                                <img src="${following.user.profile_image}" class="block bg-gray-200 h-14 w-14 border border-gray-200 overflow-hidden" style="border-radius: 50%;">
                                                <div class="pl-2.5 pr-1">
                                                    <div class="text-gray-800 hover:text-gray-900 font-semibold text-lg overflow-hidden whitespace-nowrap w-32">${following.user.name}</div>
                                                    <span class="text-gray-600 hover:text-gray-700">${following.user.username}</span>
                                                </div>
                                            </div>
                                            <button id="profile-btn" class="bg-blue-500 text-white px-3 py-1 rounded">
                                                Profile
                                            </button>
                                        </a>
                                    `;
    
                                    following_list.innerHTML += following_item;
                                });
                            }
                            else {
                                following_list.innerHTML = `<div class="text-gray-700 text-xl text-center py-5">You're not following anyone.</div>`;
                            }

                            following_loaded = true;
                        })
                        .catch(err => console.error(err));
                }
            });

        // Close following box
        hide_following_box_btn.addEventListener('click', () => following_box.classList.add('hidden'));
    </script>
</x-app-layout>
