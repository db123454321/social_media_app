<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class PostCommented extends Notification
{
    use Queueable;

    protected $user;
    protected $post;
    protected $comment;

    public function __construct(User $user, Post $post, Comment $comment)
    {
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'post_commented',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'message' => "{$this->user->name} commented on your post"
        ];
    }
}

