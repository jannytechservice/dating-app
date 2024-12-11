<?php

namespace App\Contracts;

interface MessageRepositoryInterface
{
    public function getMessagesByConversationId(int $conversationId);
    public function createMessage(array $data);
}