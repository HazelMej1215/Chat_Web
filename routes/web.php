<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('chat.index');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/fetch/messages', [ChatController::class, 'fetch'])->name('chat.fetch');
    Route::get('/chat/fetch/unread', [ChatController::class, 'unread'])->name('chat.unread');
    Route::post('/chat/ai', [ChatController::class, 'aiChat'])->name('chat.ai');
    Route::get('/chat/ai', [ChatController::class, 'showAi'])->name('chat.ai.show');

    Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';