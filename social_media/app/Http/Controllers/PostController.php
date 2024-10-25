<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostLiked;
use App\Notifications\PostCommented;

class PostController extends Controller
{
    public function index()
    {
        // Use paginate instead of get to enable pagination
        $posts = Post::paginate(10); // Adjust the number as needed
        return view('home', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Find the post by ID and update it
        $post = Post::findOrFail($id);
        $post->update($request->all());

        // Redirect back to the home page with a success message
        return redirect('/posts')->with('success', 'Post updated successfully!');
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        
        // Check if user hasn't already liked the post
        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->attach($user->id);
            
            // Send notification to post owner if it's not their own post
            if ($post->user_id !== $user->id) {
                $post->user->notify(new PostLiked($user, $post));
            }
        }
        
        return response()->json(['likes_count' => $post->likes()->count()]);
    }

    // public function toggleLike($id)
    // {
    //     $post = Post::findOrFail($id);
    //     $post->likes()->toggle(auth()->id());
    //     return response()->json(['likes_count' => $post->likes()->count()]);
    // }

    public function addComment(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);
        $post = Post::findOrFail($id);
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Send notification to post owner if it's not their own comment
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new PostCommented(auth()->user(), $post, $comment));
        }

        return response()->json($comment);
    }

    public function editComment(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);
        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        $comment->save();

        return response()->json($comment);
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function storeComment(Request $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
        
        // Send notification to post owner if it's not their own comment
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new PostCommented(auth()->user(), $post, $comment));
        }
        
        return back();
    }
}
