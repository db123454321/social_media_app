<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::resource('posts', PostController::class);
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('posts/{post}/comments', [PostController::class, 'addComment'])->name('comments.store');
    
    // Comments
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.updateProfilePicture');
    
    // Messages
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages');
        Route::get('/{user}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/{user}', [MessageController::class, 'store'])->name('messages.store');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
    
    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    });
    
    // New route for marking a single notification as read
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // User
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
