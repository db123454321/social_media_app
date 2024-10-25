<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full object-cover">
                        @endif
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            @if($user->bio)
                                <p class="mt-2 text-gray-700">{{ $user->bio }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-xl font-semibold mb-4">Posts</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($posts as $post)
                                <div class="bg-white border rounded-lg overflow-hidden">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                             alt="{{ $post->title }}" 
                                             class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h5 class="font-semibold">{{ $post->title }}</h5>
                                        <p class="text-gray-600 text-sm mt-2">
                                            {{ Str::limit($post->description, 100) }}
                                        </p>
                                        <div class="mt-4">
                                            <a href="{{ route('posts.show', $post) }}" 
                                               class="text-blue-500 hover:underline">
                                                View Post
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
