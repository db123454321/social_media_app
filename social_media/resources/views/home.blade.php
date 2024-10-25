<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-3xl font-light italic font-playfair text-pink-600 tracking-wide mb-6">
                        Welcome to Your Feed!
                    </div>

                    <div class="mb-6">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 active:from-pink-600 active:to-purple-700 disabled:opacity-25 transition">
                            Create New Post
                        </a>
                    </div>

                    <!-- Instagram-like Feed -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($posts as $post)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-md" id="post-{{ $post->id }}">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2">{{ $post->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($post->description, 50) }}</p>
                                    <div class="text-gray-500 text-xs mb-2">
                                        Posted by {{ $post->user->name }} {{ $post->created_at->diffForHumans() }}
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">View Post</a>
                                        <div class="flex space-x-2">
                                            <button type="button" class="text-red-500 hover:text-red-700" id="like-button-{{ $post->id }}" onclick="toggleLike({{ $post->id }})">
                                                <i class="fas fa-heart"></i> <span id="likes-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                                            </button>
                                            <a href="{{ route('posts.show', $post) }}#comments" class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-comment"></i> {{ $post->comments_count }}
                                            </a>
                                            @if(Auth::id() === $post->user_id)
                                                <a href="{{ route('posts.edit', $post) }}" class="text-gray-500 hover:text-gray-700">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function toggleLike(postId) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        // Update the likes count
        const likesCountElements = document.querySelectorAll(`[id$="likes-count-${postId}"]`);
        likesCountElements.forEach(element => {
            element.innerText = data.likes_count;
        });
    })
    .catch(error => console.error('Error:', error));
}
</script>
