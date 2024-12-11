<?php

namespace App\Repositories;

use App\Contracts\ConversationRepositoryInterface;
use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function getConversationsByUserId(int $userId)
    {
        return Conversation::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['participants', 'messages'])->get();
    }

    public function createConversation(array $data)
    {
        return Conversation::create($data);
    }

    public function addParticipant(int $conversationId, int $userId)
    {
        return ConversationParticipant::create([
            'conversation_id' => $conversationId,
            'user_id' => $userId,
        ]);
    }

    public function getParticipants(int $conversationId)
    {
        return ConversationParticipant::where('conversation_id', $conversationId)->pluck('user_id');
    }
}

