<?php

namespace App\Contracts;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ConversationRepositoryInterface
 *
 * This interface defines methods for managing conversations.
 */
interface ConversationRepositoryInterface
{
    /**
     * Retrieve conversations associated with a specific user.
     *
     * @param int $userId
     * @return Collection<int, Conversation>
     */
    public function getConversationsByUserId(int $userId): Collection;

    /**
     * Create a new conversation.
     *
     * @param array<string, int> $data
     * @return Conversation
     */
    public function createConversation(array $data): Conversation;
}
