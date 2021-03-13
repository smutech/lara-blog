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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col justify-center">
                        <div class="flex justify-center items-center py-5">
                            <label for="avatar-upload" class="rounded-full shadow overflow-hidden h-40 w-40 bg-gray-700 text-white hover:opacity-90 cursor-pointer">
                                <img src="" class="h-40 w-40" alt="{{ $profile->name }}'s avatar">
                            </label>
                        </div>
                        <input type="file" name="avatar" id="avatar-upload" class="hidden">

                        @auth
                            @if (auth()->user()->username == $profile->username)
                                <div class="flex justify-center items-center text-lg py-1 pb-2">
                                    <a href="{{ route('edit-profile') }}" class="text-blue-500 hover:text-blue-800 focus:text-blue-800 focus:outline-none">Edit profile</a>
                                </div>
                            @endif
                        @endauth

                        <div class="flex justify-center items-center text-3xl font-light mt-1">
                            {{ $profile->name }}

                            @auth
                                @if (auth()->user()->username == $profile->username)
                                    <span class="text-bold ml-2">(Me)</span>
                                @endif
                            @endauth
                        </div>

                        <div class="flex justify-center items-center text-xl py-2">
                            {{ $profile->username }}
                        </div>

                        <div class="flex justify-center items-center text-gray-600 text-lg py-2">
                            Joined {{ $profile->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
