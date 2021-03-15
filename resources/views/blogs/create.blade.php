<x-app-layout metaTitle="Create blog">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create blog') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('store-blog') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <x-label for="image" class="text-lg block w-1/3" :value="__('Post image')" />
                            <x-input id="image" class="block mt-1 border w-full" type="file" name="image" value="{{ old('image')}}" autocomplete="off" tabindex="1" />

                            @error('title')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-5">
                            <x-label for="title" class="text-lg block w-1/3" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title')}}" autocomplete="off" tabindex="2" required />

                            @error('title')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-5">
                            <x-label for="body" class="text-lg block w-1/3" :value="__('Body')" />
                            <textarea id="body" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="body" rows="5" autocomplete="off" tabindex="2" required>{{ old('body')}}</textarea>

                            @error('body')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <div class="mt-5">
                            <x-button tabindex="4">
                                {{ __('Create blog') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/editor/ckeditor_4.14.1_basic/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('body');
    </script>
</x-app-layout>
