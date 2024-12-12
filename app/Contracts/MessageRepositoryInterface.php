<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Message;

/**
 * Interface MessageRepositoryInterface
 *
 * This interface defines methods for managing messages in conversations.
 */
interface MessageRepositoryInterface
{
    /**
     * Retrieve all messages for a specific conversation.
     *
     * @param int $conversationId
     * @return Collection<int, Message>
     */
    public function getMessagesByConversationId(int $conversationId): Collection;

    /**
     * Create a new message within a conversation.
     *
     * @param array<string, mixed> $data
     * @return Message
     */
    public function createMessage(array $data);
}
