<?php

namespace App\Contracts;

interface ConversationRepositoryInterface
{
    public function getConversationsByUserId(int $userId);
    public function createConversation(array $data);
    public function addParticipant(int $conversationId, int $userId);
    public function getParticipants(int $conversationId);
}