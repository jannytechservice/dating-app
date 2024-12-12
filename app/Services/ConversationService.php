<?php

namespace App\Services;

use App\Contracts\ConversationRepositoryInterface;
use App\Contracts\ConversationParticipantRepositoryInterface;
use App\Helpers\CacheHelper;
use App\Helpers\CacheKey;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        $userId = (int) Auth::id();
        $key = CacheKey::userConversations($userId);
        Log::channel('info')->info("Cache checking for key: {$key}");

        /** @var Collection<int, Conversation> $conversations */
        $conversations = CacheHelper::cache($key, function () use ($userId) {
            Log::channel('info')->info("Cache miss, fetching from DB...");
            return $this->conversationRepository->getConversationsByUserId($userId);
        });
        Log::channel('info')->info("Cache returned: ", [$conversations]);

        return $conversations;
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

        CacheHelper::forget(CacheKey::userConversations((int) Auth::id()));
        
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
        $key = CacheKey::participants($conversationId);

        /** @var Collection<int, User> $participants */
        $participants = CacheHelper::cache($key, function () use ($conversationId) {
            return $this->participantRepository->getParticipants($conversationId);
        });
        
        return $participants;
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
