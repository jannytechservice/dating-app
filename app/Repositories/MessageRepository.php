<?php

namespace App\Repositories;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;

class MessageRepository implements MessageRepositoryInterface
{
    public function getMessagesByConversationId(int $conversationId)
    {
        return Message::where('conversation_id', $conversationId)->orderBy('created_at')->get();
    }

    public function createMessage(array $data)
    {
        return Message::create($data);
    }
}
