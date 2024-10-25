<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full">
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 active:from-pink-600 active:to-purple-700 disabled:opacity-25 transition">
                                Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
