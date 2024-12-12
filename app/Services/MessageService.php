<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use App\Helpers\CacheHelper;
use App\Helpers\CacheKey;
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
    public function getMessages(int $conversationId): Collection
    {
        $key = CacheKey::conversationMessages($conversationId);

        /** @var Collection<int, Message> $messages */
        $messages = CacheHelper::cache($key, function () use ($conversationId) {
            return $this->messageRepository->getMessagesByConversationId($conversationId);
        });

        return $messages;
    }

    /**
     * Send a new message within a conversation.
     *
     * @param array<string, mixed> $data
     * @return Message
     */
    public function sendMessage(array $data): Message
    {
        if (!isset($data['conversation_id']) || !is_int($data['conversation_id'])) {
            throw new \InvalidArgumentException("'conversation_id' must be an integer.");
        }

        $conversationId = $data['conversation_id'];
        /** @var Message $message */
        $message = $this->messageRepository->createMessage($data);

        CacheHelper::forget(CacheKey::conversationMessages($conversationId));

        return $message;
    }
}
