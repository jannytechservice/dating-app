<?php

namespace App\Repositories;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Retrieve all messages for a specific conversation.
     *
     * @param int $conversationId
     * @return Collection<int, Message>
     */
    public function getMessagesByConversationId(int $conversationId): Collection
    {
        return Message::where('conversation_id', $conversationId)->orderBy('created_at')->get();
    }

    /**
     * Create a new message within a conversation.
     *
     * @param array<string, mixed> $data
     * @return Message
     */
    public function createMessage(array $data): Message
    {
        return Message::create($data);
    }
}
