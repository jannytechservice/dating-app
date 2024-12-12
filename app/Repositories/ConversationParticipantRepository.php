<?php

namespace App\Repositories;

use App\Contracts\ConversationParticipantRepositoryInterface;
use App\Models\ConversationParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ConversationParticipantRepository
 *
 * This class provides methods to manage conversation participants.
 */
class ConversationParticipantRepository implements ConversationParticipantRepositoryInterface
{
    /**
     * Add a participant to a conversation.
     *
     * @param array<string, int> $data
     * @return ConversationParticipant
     */
    public function addParticipant(array $data): ConversationParticipant
    {
        return ConversationParticipant::create($data);
    }

    /**
     * Retrieve all participants of a specific conversation.
     *
     * @param int $conversationId
     * @return Collection<int, User>
     */
    public function getParticipants(int $conversationId): Collection
    {
        return ConversationParticipant::where('conversation_id', $conversationId)
            ->with('user')
            ->get()
            ->map(function (ConversationParticipant $participant): User {
                if ($participant->user instanceof User) {
                    return $participant->user;
                }
                throw new \RuntimeException('Expected user relationship to return a User model but got null.');
            });
    }

    /**
     * Remove a participant from a conversation.
     *
     * @param int $conversationId
     * @param int $userId
     * @return mixed
     */
    public function removeParticipant(int $conversationId, int $userId): mixed
    {
        return ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $userId)
            ->delete();
    }
}
