<?php

namespace App\Repositories;

use App\Contracts\ConversationRepositoryInterface;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ConversationRepository
 *
 * This class implements methods to manage conversations, including retrieval
 * and creation of conversation records.
 */
class ConversationRepository implements ConversationRepositoryInterface
{
    /**
     * Retrieve conversations associated with a specific user.
     *
     * @param int $userId
     * @return Collection<int, Conversation>
     */
    public function getConversationsByUserId(int $userId): Collection
    {
        return Conversation::whereHas('participants', function (\Illuminate\Database\Eloquent\Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['participants', 'messages'])->get();
    }

    /**
     * Create a new conversation.
     *
     * @param array<string, mixed> $data
     * @return Conversation
     */
    public function createConversation(array $data): Conversation
    {
        return Conversation::create($data);
    }
}
