<x-app-layout metaTitle="Edit profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit profile') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl mb-4">
                        {{ __('Edit Profile') }}
                    </h3>

                    @if (session('profile_success_message'))
                        <div class="bg-green-400 text-white text-lg mx-auto lg:w-1/3 px-4 py-2 mb-5 shadow rounded">
                            {{ session('profile_success_message') }}
                        </div>
                    @endif

                    <form action="{{ route('edit-profile') }}" method="post" enctype="multipart/form-data" class="sm:flex sm:justify-evenly sm:items-start">
                        @csrf

                        <div class="py-12">
                            <div class="flex justify-center items-center">
                                <label for="avatar-upload" class="rounded-full shadow overflow-hidden h-40 w-40 bg-gray-700 text-white hover:opacity-90 cursor-pointer">
                                    <img src="{{ Storage::url($user->profile_image) }}" class="h-40 w-40" alt="{{ $user->name }}'s avatar">
                                </label>
                            </div>
                            <input type="file" name="avatar" id="avatar-upload" class="hidden">
                        </div>

                        <div class="md:w-1/3 sm:w-full">
                            <div class="">
                                <x-label for="name" class="text-lg block w-1/3" :value="__('Name')" />
                                
                                <x-input id="name" class="block w-full mt-1" type="text" name="name" value="{{ old('name') ??  $user->name }}" spellcheck="false" autocomplete="off" required />
                                
                                @error('name')
                                    <div class="text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <div class="mt-5">
                                <x-label for="username" class="text-lg block w-1/3" :value="__('Username')" />
                                
                                <x-input id="username" class="block w-full mt-1" type="text" name="username" value="{{ old('username') ??  $user->username }}" spellcheck="false" autocomplete="off" required />

                                @error('username')
                                    <div class="text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <div class="mt-5">
                                <x-label for="email" class="text-lg block w-1/3" :value="__('Email')" />
                                
                                <x-input id="email" class="block w-full mt-1" type="email" name="email" value="{{ old('email') ??  $user->email }}" autocomplete="off" required />

                                @error('email')
                                    <div class="text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <div class="mt-7">
                                <div class="flex items-center justify-start mt-4">
                                    <x-button>
                                        {{ __('Update profile') }}
                                    </x-button>
    
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 ml-4" href="{{ route('verification.notice') }}">
                                        {{ __('Verify email?') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
