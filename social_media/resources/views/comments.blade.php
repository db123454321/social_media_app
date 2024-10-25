<!-- Assuming you are in a Blade template -->
@foreach ($comments as $comment)
    <div class="comment" id="comment-{{ $comment->id }}">
        <p>{{ $comment->content }}</p>
        <button onclick="editComment({{ $comment->id }})">Edit</button>
    </div>
@endforeach

<!-- Edit form (hidden by default) -->
<div id="edit-form" style="display:none;">
    <input type="text" id="edit-content" />
    <button onclick="saveComment()">Save</button>
</div>

<script>
    let currentCommentId;

    function editComment(commentId) {
        currentCommentId = commentId;
        const commentContent = document.querySelector(`#comment-${commentId} p`).innerText;
        document.getElementById('edit-content').value = commentContent;
        document.getElementById('edit-form').style.display = 'block';
    }

    function saveComment() {
        const content = document.getElementById('edit-content').value;

        fetch(`/comments/${currentCommentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#comment-${currentCommentId} p`).innerText = content;
                document.getElementById('edit-form').style.display = 'none';
            }
        });
    }
</script>

