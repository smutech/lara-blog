<x-app-layout metaTitle="Edit profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl mb-4">
                        {{ __('Edit Profile') }}
                    </h3>

                    @if (session('profile_success_message'))
                        <div class="bg-green-400 text-white text-lg mx-auto lg:w-1/3 px-4 py-2 mb-5 shadow rounded">
                            {{ session('profile_success_message') }}
                        </div>
                    @endif

                    <form action="{{ route('edit-profile') }}" method="post">
                        @csrf

                        <div class="flex justify-between items-center">
                            <x-label for="name" class="text-lg block w-1/3" :value="__('Name')" />
                            
                            <x-input id="name" class="block mt-1 w-1/2" type="text" name="name" value="{{ old('name') ??  $user->name }}" autocomplete="off" required />
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <x-label for="username" class="text-lg block w-1/3" :value="__('Username')" />
                            
                            <x-input id="username" class="block mt-1 w-1/2" type="text" name="username" value="{{ old('name') ??  $user->username }}" autocomplete="off" required />
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <x-label for="email" class="text-lg block w-1/3" :value="__('Email')" />
                            
                            <x-input id="email" class="block mt-1 w-1/2" type="email" name="email" value="{{ old('name') ??  $user->email }}" autocomplete="off" required />
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <div></div>

                            <div class="flex items-center justify-start mt-4 w-1/2">
                                <x-button>
                                    {{ __('Update profile') }}
                                </x-button>

                                <a class="underline text-sm text-gray-600 hover:text-gray-900 ml-4" href="{{ route('verification.notice') }}">
                                    {{ __('Verify email?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
