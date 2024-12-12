<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Services\ConversationService;
use App\Http\Requests\Conversation\CreateConversationRequest;
use App\Http\Requests\Conversation\AddParticipantRequest;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{
    /**
     * @var ConversationService
     */
    protected $conversationService;

    /**
     * ConversationController constructor.
     *
     * @param ConversationService $conversationService
     */
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    /**
     * List all conversations for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $conversations = $this->conversationService->getConversations();
        return JsonResponse::success('Conversations retrieved successfully.', $conversations, Response::HTTP_OK);
    }

    /**
     * Create a new conversation.
     *
     * @param CreateConversationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateConversationRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var array<string, int> $validatedData */
        $validatedData = $request->validated();
        $conversation = $this->conversationService->createConversation($validatedData);
        return JsonResponse::success('Conversation created successfully.', $conversation, Response::HTTP_CREATED);
    }

    /**
     * Add a participant to a conversation.
     *
     * @param AddParticipantRequest $request
     * @param int $conversationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addParticipant(AddParticipantRequest $request, $conversationId): \Illuminate\Http\JsonResponse
    {
        /** @var array<string, int> $validatedData */
        $validatedData = $request->validated();
        $this->conversationService->addParticipant($conversationId, $validatedData['user_id']);
        return JsonResponse::success('Participant added successfully.', null, Response::HTTP_OK);
    }

    /**
     * Remove a participant from a conversation.
     *
     * @param AddParticipantRequest $request
     * @param int $conversationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeParticipant(AddParticipantRequest $request, $conversationId): \Illuminate\Http\JsonResponse
    {
        /** @var array<string, int> $validatedData */
        $validatedData = $request->validated();
        $this->conversationService->removeParticipant($conversationId, $validatedData['user_id']);
        return JsonResponse::success('Participant removed successfully.', null, Response::HTTP_CREATED);
    }

    /**
     * Retrieve all participants of a conversation.
     *
     * @param int $conversationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParticipants(int $conversationId): \Illuminate\Http\JsonResponse
    {
        $participants = $this->conversationService->getParticipants($conversationId);

        if ($participants->isEmpty()) {
            return JsonResponse::error('No participants found for this conversation.', null, Response::HTTP_NOT_FOUND);
        }

        return JsonResponse::success('Participants retrieved successfully.', $participants, Response::HTTP_OK);
    }
}
