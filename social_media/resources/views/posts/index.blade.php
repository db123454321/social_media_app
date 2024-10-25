@foreach($posts as $post)
    <div class="post" id="post-{{ $post->id }}">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        <div class="flex justify-between items-center mb-4">
            <span class="text-gray-500">Posted {{ $post->created_at->diffForHumans() }}</span>
            <div class="flex space-x-2">
                <button id="home-like-button-{{ $post->id }}" onclick="toggleLike({{ $post->id }})" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-heart"></i> <span id="home-likes-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                </button>
                <span class="text-gray-500">
                    <i class="fas fa-comment"></i> <span id="comments-count">{{ $post->comments()->count() }}</span>
                </span>
            </div>
        </div>
    </div>
@endforeach

