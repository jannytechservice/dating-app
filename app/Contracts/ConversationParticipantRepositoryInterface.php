<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

/**
 * Interface ConversationParticipantRepositoryInterface
 *
 */
interface ConversationParticipantRepositoryInterface
{
    /**
     * Add a participant to a conversation.
     *
     * @param array<string, int> $data
     * @return mixed
     */
    public function addParticipant(array $data);

    /**
     * Retrieve all participants of a specific conversation.
     *
     * @param int $conversationId
     * @return Collection<int, User>
     */
    public function getParticipants(int $conversationId): Collection;

    /**
     * Remove a participant from a conversation.
     *
     * @param int $conversationId
     * @param int $userId
     * @return mixed
     */
    public function removeParticipant(int $conversationId, int $userId): mixed;
}
