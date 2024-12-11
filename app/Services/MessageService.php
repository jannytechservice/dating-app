<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;

class MessageService
{
    protected $messageRepository;

    /**
     * MessageService constructor.
     *
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Get all messages for a specific conversation.
     *
     * @param int $conversationId
     * @return mixed
     */
    public function getMessages(int $conversationId)
    {
        return $this->messageRepository->getMessagesByConversationId($conversationId);
    }

    /**
     * Send a new message within a conversation.
     *
     * @param array $data
     * @return mixed
     */
    public function sendMessage(array $data)
    {
        return $this->messageRepository->createMessage($data);
    }
}
