<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('profile/search', [ProfileController::class, 'search']);
    Route::get('profile/{id}', [ProfileController::class, 'show']);
    Route::get('profile/{id}', [ProfileController::class, 'show']);
    Route::get('/profiles/popular/{count}', [ProfileController::class, 'getPopularProfiles']);
    // Conversations
    Route::get('conversations', [ConversationController::class, 'index']);
    Route::post('conversations', [ConversationController::class, 'store']);
    Route::post('conversations/{conversationId}/participants', [ConversationController::class, 'addParticipant']);
    Route::delete('conversations/{conversationId}/participants', [ConversationController::class, 'removeParticipant']);
    Route::get('conversations/{conversationId}/participants', [ConversationController::class, 'getParticipants']);
    // Messages
    Route::get('messages/{conversationId}', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
});