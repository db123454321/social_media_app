<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('likes', 'comments')->latest()->paginate(10);
        return view('home', compact('posts'));
    }
}
