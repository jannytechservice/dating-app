<?php

namespace App\Services;

use App\Contracts\ConversationRepositoryInterface;
use App\Contracts\ConversationParticipantRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    protected $conversationRepository;
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
        return $this->conversationRepository->getConversationsByUserId(Auth::id());
    }

    /**
     * Create a new conversation and add the creator as a participant.
     *
     * @param array $data
     * @return mixed
     */
    public function createConversation(array $data)
    {
        $conversation = $this->conversationRepository->createConversation($data);

        $this->participantRepository->addParticipant([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
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
     * @return mixed
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
