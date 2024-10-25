<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    /**
     * Update the user's profile picture.
     */
    public function updateProfilePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'picture' => ['required', 'image', 'max:1024'], // 1MB Max
        ]);

        $user = $request->user();

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }

            $path = $request->file('picture')->store('public/profile_pictures');
            $user->profile_picture = basename($path);
            $user->save();
        }

        return redirect()->route('profile.show')->with('status', 'Profile picture updated successfully!');
    }

    public function show(): View
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
