<?php

namespace App\Repositories;

use App\Contracts\ConversationRepositoryInterface;
use App\Models\Conversation;

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
}

