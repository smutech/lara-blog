<x-app-layout :metaTitle="$blog->title">
    <div class="py-4">
        <div class="flex justify-center items-start max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white w-3/4 overflow-hidden shadow-md sm:roundedlg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="pb-3 border-b border-bottom border-gray-300">
                        <h1 class="text-semibold text-3xl">
                            {{ $blog->title }}
                        </h1>

                        @if (! empty($blog->image))
                            <img src="{{ Storage::url($blog->image) }}" class="block w-full my-5" alt="{{ $blog->title }}">
                        @endif

                        <div class="flex items-center text-gray-600 mt-2">
                            <div>
                                By
                                <a href="{{ route('profile', $blog->user->username) }}" class="text-blue-700">
                                    {{ $blog->user->name }}
                                </a>
                            </div>
                            <div class="font-bold mx-2">&middot;</div>
                            <div>
                                {{ $blog->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 post-body">
                        {!! nl2br($blog->body) !!}
                    </div>

                    <hr class="my-5 border-t border-gray-300">

                    <div class="mt-5">
                        <a href="{{ route('edit-blog', $blog) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Edit</a>

                        <form action="{{ route('delete-blog', $blog) }}" method="post" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <x-button class="ml-1">
                                {{ __('Delete') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-1/4 md:ml-5">
                <div class="bg-white shadow-md rounded-sm overflow-hidden">
                    <div class="bg-gray-200 text-gray-700 text-lg font-semibold px-4 py-3">About author</div>
                    <div class="flex items-center px-4 py-4">
                        <div class="bg-gray-300 rounded-full overflow-hidden h-20 w-20">
                            <img src="{{ $blog->user->profile_image == null ? '/assets/images/user placeholder.png' : Storage::url($blog->user->profile_image) }}" class="block" alt="{{ $blog->user->name }}'s profile photo">
                        </div>
                        <div class="ml-3.5">
                            <a href="{{ route('profile', $blog->user->username) }}" class="block text-lg">
                                {{ $blog->user->name }}
                            </a>
                            <button id="follow-btn" class="bg-blue-500 text-white outline-none mt-2 px-3 py-1 rounded hidden">Follow</button>
                        </div>
                    </div>
                </div>


                <div class="bg-white shadow-md rounded-sm overflow-hidden mt-5">
                    <div class="bg-gray-200 text-gray-700 text-lg font-semibold px-4 py-3">More posts from this author</div>

                    <div id="author-posts"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch('{{ route('user-blogs-api', ['user' => $blog->user->username, 'limit' => 5]) }}')
            .then(res => res.json())
            .then(posts => {
                posts.data.forEach(post => {
                    let post_item = `
                        <a href="${post.uri}" class="block bg-white hover:bg-gray-100 focus:bg-gray-100 px-4 py-2 border-b border-gray-100">
                            <div class="leading-6 text-gray-700 text-lg text-justify max-h-12 overflow-hidden">
                                {{ Str::words('${post.title}', 7) }}
                            </div>
                            <div class="flex justify-between items-center text-gray-500 pt-1.5">
                                <!--<span class="italic">${post.user.name}</span>-->
                                <span>${post.created_at}</span>
                            </div>
                        </a>
                    `;

                    document.getElementById('author-posts').innerHTML += post_item;
                });
            });


            // Check if authenticated user follows current blog post user or not
            let follow_btn = document.getElementById('follow-btn');

            fetch('{{ route('show-follow-status', [ $blog->user->id, auth()->id() ]) }}')
                .then(res => res.json())
                .then(follow => {
                    follow_btn.classList.remove('hidden')
                    follow_btn.innerText = follow.text;
                })
                .catch(err => console.error(err));


            // Follow user
            follow_btn.addEventListener('click', () => {
                const data = {
                    follower_id: {{ auth()->id() }}
                };

                let options = {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: new Headers({
                        'Content-Type': 'application/json'
                    })
                };

                fetch('{{ route('follow-user', $blog->user->id) }}', options)
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
    </script>
</x-app-layout>
