<?php

namespace App\Contracts;

interface ConversationRepositoryInterface
{
    public function getConversationsByUserId(int $userId);
    public function createConversation(array $data);
}