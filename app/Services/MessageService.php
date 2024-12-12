<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageService
{
    /**
     * @var MessageRepositoryInterface
     */
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
     * @return Collection<int, Message>
     */
    public function getMessages(int $conversationId)
    {
        return $this->messageRepository->getMessagesByConversationId($conversationId);
    }

    /**
     * Send a new message within a conversation.
     *
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function sendMessage(array $data)
    {
        return $this->messageRepository->createMessage($data);
    }
}
