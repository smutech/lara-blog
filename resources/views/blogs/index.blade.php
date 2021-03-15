<x-app-layout metaTitle="Blogs">
    <div class="py-4">
        <div class="md:flex justify-center items-start max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white md:w-3/4 overflow-hidden shadow-md rounded">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('blog_success_message'))
                        <div class="bg-green-500 text-white text-lg px-5 py-3 rounded shadow mb-5">
                            {{ session('blog_success_message') }}
                        </div>
                    @endif

                    @foreach ($blogs as $blog)
                        <div class="mb-5 pb-3 border-b border-gray-200">
                            <div class="mb-3">
                                <div class="font-medium text-gray-800 text-2xl">
                                    {{ $blog->title }}
                                </div>

                                <div class="flex items-center text-gray-500 mt-0.5">
                                    <div>
                                        By
                                        <a href="{{ route('profile', $blog->user->username) }}" class="text-blue-700 hover:opacity-80">
                                            {{ $blog->user->name }}
                                        </a>
                                    </div>
                                    <div class="font-bold mx-1.5">&middot;</div>
                                    <div>
                                        {{ $blog->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="@if (! empty($blog->image)) flex flex-col md:flex-row items-start @endif text-base text-gray-800 post-body">
                                @if (! empty($blog->image))
                                    <img src="{{ Storage::url($blog->image) }}" class="block w-full md:w-1/2 lg:w-1/3 mr-4 pb-5 md:pb-0" alt="{{ $blog->title }}">
                                @endif
                                <div>
                                    {!! Str::words($blog->body, 50) !!}
                                </div>
                            </div>
                            
                            <div class="mt-5">
                                <a href="{{ route('show-blog', $blog) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Read more</a>
                            </div>
                        </div>
                    @endforeach

                    {{ $blogs->links() }}
                </div>
            </div>

            <div class="bg-white w-full md:w-1/4 md:ml-5 my-5 md:my-0 shadow-md rounded">
                <div class="bg-gray-200 text-gray-700 text-lg font-semibold px-4 py-3">Popular posts</div>

                <div id="popular-posts"></div>
            </div>
        </div>
    </div>

    <script>
        fetch('{{ route('blogs-api', ['limit' => 5]) }}')
            .then(res => res.json())
            .then(posts => {
                posts.data.forEach(post => {
                    let post_item = `
                        <a href="${post.uri}" class="block bg-white hover:bg-gray-100 px-4 py-2 border-b border-gray-100">
                            <div class="leading-6 text-gray-700 text-lg text-justify max-h-12 overflow-hidden">
                                {{ Str::words('${post.title}', 7) }}
                            </div>
                            <div class="flex justify-between items-center text-gray-500 pt-1.5">
                                <span class="italic">${post.user.name}</span>
                                <span>${post.created_at}</span>
                            </div>
                        </a>
                    `;

                    document.getElementById('popular-posts').innerHTML += post_item;
                });
            });
    </script>
</x-app-layout>
