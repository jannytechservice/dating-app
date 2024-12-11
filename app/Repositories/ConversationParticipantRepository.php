<?php

namespace App\Repositories;

use App\Contracts\ConversationParticipantRepositoryInterface;
use App\Models\ConversationParticipant;

class ConversationParticipantRepository implements ConversationParticipantRepositoryInterface
{
    public function addParticipant(array $data)
    {
        return ConversationParticipant::create($data);
    }

    public function getParticipants(int $conversationId)
    {
        return ConversationParticipant::where('conversation_id', $conversationId)
        ->with('user')
        ->get()
        ->map(function ($participant) {
            return $participant->user;
        });
    }

    public function removeParticipant(int $conversationId, int $userId)
    {
        return ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $userId)
            ->delete();
    }
}
