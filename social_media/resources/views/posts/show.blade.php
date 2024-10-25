<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-4">
                    @endif
                    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                    <p class="text-gray-700 mb-4">{{ $post->description }}</p>
                    <div class="post-author mb-4">
                        <a href="{{ route('users.show', $post->user) }}" class="text-blue-600 hover:text-blue-800">{{ $post->user->name }}</a>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500">Posted {{ $post->created_at->diffForHumans() }}</span>
                        <div class="flex space-x-2">
                            <button id="like-button-{{ $post->id }}" onclick="toggleLike({{ $post->id }})" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-heart"></i> <span id="likes-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                            </button>
                            <span class="text-gray-500">
                                <i class="fas fa-comment"></i> <span id="comments-count">{{ $post->comments()->count() }}</span>
                            </span>
                        </div>
                    </div>
                    @if(Auth::id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post) }}" class="text-purple-600 hover:text-pink-600">Edit Post</a>
                    @endif
                    <a href="{{ route('home') }}" class="text-purple-600 hover:text-pink-600 ml-4">Back to Feed</a>
                </div>

                <!-- Comments Section -->
                <div class="p-6 bg-gray-50" id="comments">
                    <h2 class="text-2xl font-bold mb-4">Comments</h2>
                    <div id="comments-list">
                        @foreach($post->comments as $comment)
                            <div class="mb-4 p-4 bg-white rounded-lg shadow" id="comment-{{ $comment->id }}">
                                <div class="comment-content">
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                    <span class="text-gray-500 text-sm">{{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if(Auth::id() === $comment->user_id)
                                    <div class="flex space-x-2 mt-2">
                                        <button onclick="editComment({{ $comment->id }})" class="text-blue-500 hover:underline">Edit</button>
                                        <button onclick="deleteComment({{ $comment->id }})" class="text-red-500 hover:underline">Delete</button>
                                    </div>
                                    <div class="edit-form hidden mt-2">
                                        <textarea id="edit-content-{{ $comment->id }}" rows="2" class="w-full p-2 border rounded-lg" placeholder="Edit your comment...">{{ $comment->content }}</textarea>
                                        <button onclick="updateComment({{ $comment->id }})" class="mt-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600">Update Comment</button>
                                        <button onclick="cancelEdit({{ $comment->id }})" class="mt-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Comment Form -->
                    <form id="comment-form-{{ $post->id }}" onsubmit="addComment(event, {{ $post->id }})" class="mt-4">
                        @csrf
                        <textarea name="content" rows="3" class="w-full p-2 border rounded-lg" placeholder="Add a comment..."></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600">Post Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleLike(postId) {
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            // Update the likes count in the view post
            document.getElementById(`likes-count-${postId}`).innerText = data.likes_count;

            // Update the likes count in the home page (if applicable)
            const homeLikesCountElement = document.getElementById(`home-likes-count-${postId}`);
            if (homeLikesCountElement) {
                homeLikesCountElement.innerText = data.likes_count;
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function addComment(event, postId) {
        event.preventDefault();
        const form = document.getElementById(`comment-form-${postId}`);
        const formData = new FormData(form);
        
        fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const commentElement = document.createElement('div');
            commentElement.classList.add('mb-4', 'p-4', 'bg-white', 'rounded-lg', 'shadow');
            commentElement.id = `comment-${data.id}`;
            commentElement.innerHTML = `<div class="comment-content"><p class="text-gray-700">${data.content}</p><span class="text-gray-500 text-sm">You - just now</span></div><div class="flex space-x-2 mt-2"><button onclick="editComment(${data.id})" class="text-blue-500 hover:underline">Edit</button><button onclick="deleteComment(${data.id})" class="text-red-500 hover:underline">Delete</button></div>`;
            document.getElementById('comments-list').appendChild(commentElement);
            form.reset(); // Clear the form
        })
        .catch(error => console.error('Error:', error));
    }

    function editComment(commentId) {
        const commentElement = document.getElementById(`comment-${commentId}`);
        const editForm = commentElement.querySelector('.edit-form');
        const contentElement = commentElement.querySelector('.comment-content p');
        const editContentInput = commentElement.querySelector(`#edit-content-${commentId}`);

        if (editForm && contentElement && editContentInput) {
            editContentInput.value = contentElement.innerText.trim();
            editForm.classList.remove('hidden');
        } else {
            console.error('Error: Could not find necessary elements for editing');
        }
    }

    function updateComment(commentId) {
        const content = document.getElementById(`edit-content-${commentId}`).value;

        fetch(`/comments/${commentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            const commentElement = document.getElementById(`comment-${commentId}`);
            commentElement.querySelector('.comment-content p').innerText = data.content; // Update the comment content
            cancelEdit(commentId); // Hide the edit form
        })
        .catch(error => console.error('Error:', error));
    }

    function cancelEdit(commentId) {
        const editForm = document.querySelector(`#comment-${commentId} .edit-form`);
        editForm.classList.add('hidden'); // Hide the edit form
    }

    function deleteComment(commentId) {
        if (confirm("Are you sure you want to delete this comment?")) {
            fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`comment-${commentId}`).remove();
                alert(data.message);
            })
            .catch(error => console.error('Error:', error));
        }
    }
    </script>
    <script>
function toggleLike(postId) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        // Update the likes count in the view post
        document.getElementById(`likes-count-${postId}`).innerText = data.likes_count;

        // Update the likes count in the home page (if applicable)
        const homeLikesCountElement = document.getElementById(`home-likes-count-${postId}`);
        if (homeLikesCountElement) {
            homeLikesCountElement.innerText = data.likes_count;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
</x-app-layout>
