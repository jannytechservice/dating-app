<?php

namespace App\Contracts;

interface ConversationParticipantRepositoryInterface
{
    public function addParticipant(array $data);
    public function getParticipants(int $conversationId);
    public function removeParticipant(int $conversationId, int $userId);
}
