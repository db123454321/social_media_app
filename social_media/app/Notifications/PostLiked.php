<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Post;

class PostLiked extends Notification
{
    use Queueable;

    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'post_liked',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'post_id' => $this->post->id,
            'message' => "{$this->user->name} liked your post"
        ];
    }
}

