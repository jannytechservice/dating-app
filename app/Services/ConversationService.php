<?php

namespace App\Services;

use App\Contracts\ConversationRepositoryInterface;
use App\Contracts\ConversationParticipantRepositoryInterface;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    /**
     * @var ConversationRepositoryInterface
     */
    protected $conversationRepository;
    /**
     * @var ConversationParticipantRepositoryInterface
     */
    protected $participantRepository;

    /**
     * ConversationService constructor.
     *
     * @param ConversationRepositoryInterface $conversationRepository
     * @param ConversationParticipantRepositoryInterface $participantRepository
     */
    public function __construct(
        ConversationRepositoryInterface $conversationRepository,
        ConversationParticipantRepositoryInterface $participantRepository
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->participantRepository = $participantRepository;
    }

    /**
     * Retrieve all conversations for the authenticated user.
     *
     * @return mixed
     */
    public function getConversations()
    {
        $userId = (int) Auth::id();
        return $this->conversationRepository->getConversationsByUserId($userId);
    }

    /**
     * Create a new conversation and add the creator as a participant.
     *
     * @param array<string, int> $data
     * @return mixed
     */
    public function createConversation(array $data)
    {
        /** @var Conversation $conversation */
        $conversation = $this->conversationRepository->createConversation($data);

        $this->participantRepository->addParticipant([
            'conversation_id' => (int) $conversation->id,
            'user_id' => (int) Auth::id(),
        ]);

        return $conversation;
    }

    /**
     * Add a participant to a conversation.
     *
     * @param int $conversationId
     * @param int $userId
     * @return mixed
     */
    public function addParticipant(int $conversationId, int $userId)
    {
        return $this->participantRepository->addParticipant([
            'conversation_id' => $conversationId,
            'user_id' => $userId,
        ]);
    }

    /**
     * Retrieve all participants of a conversation.
     *
     * @param int $conversationId
     * @return Collection<int, User>
     */
    public function getParticipants(int $conversationId)
    {
        return $this->participantRepository->getParticipants($conversationId);
    }

    /**
     * Remove a participant from a conversation.
     *
     * @param int $conversationId
     * @param int $userId
     * @return mixed
     */
    public function removeParticipant(int $conversationId, int $userId)
    {
        return $this->participantRepository->removeParticipant($conversationId, $userId);
    }
}
