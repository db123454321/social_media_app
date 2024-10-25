<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()->latest()->get();
        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $messages = Message::between(auth()->user(), $user)->latest()->get();
        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = auth()->user()->sentMessages()->create([
            'recipient_id' => $user->id,
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return back()->with('success', 'Message deleted successfully.');
    }
}
