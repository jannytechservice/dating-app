<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Services\ConversationService;
use App\Http\Requests\Conversation\CreateConversationRequest;
use App\Http\Requests\Conversation\AddParticipantRequest;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{
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
     * @return JsonResponse
     */
    public function index()
    {
        $conversations = $this->conversationService->getConversations();
        return JsonResponse::success('Conversations retrieved successfully.', $conversations, Response::HTTP_OK);
    }

    /**
     * Create a new conversation.
     *
     * @param CreateConversationRequest $request
     * @return JsonResponse
     */
    public function store(CreateConversationRequest $request)
    {
        $conversation = $this->conversationService->createConversation($request->validated());
        return JsonResponse::success('Conversation created successfully.', $conversation, Response::HTTP_CREATED);
    }

    /**
     * Add a participant to a conversation.
     *
     * @param AddParticipantRequest $request
     * @param int $conversationId
     * @return JsonResponse
     */
    public function addParticipant(AddParticipantRequest $request, $conversationId)
    {
        $this->conversationService->addParticipant($conversationId, $request->validated()['user_id']);
        return JsonResponse::success('Participant added successfully.', null, Response::HTTP_OK);
    }

    /**
     * Remove a participant from a conversation.
     *
     * @param AddParticipantRequest $request
     * @param int $conversationId
     * @return JsonResponse
     */
    public function removeParticipant(AddParticipantRequest $request, $conversationId)
    {
        $this->conversationService->removeParticipant($conversationId, $request->validated()['user_id']);
        return JsonResponse::success('Participant removed successfully.', null, Response::HTTP_CREATED);
    }

    /**
     * Retrieve all participants of a conversation.
     *
     * @param int $conversationId
     * @return JsonResponse
     */
    public function getParticipants(int $conversationId)
    {
        $participants = $this->conversationService->getParticipants($conversationId);

        if ($participants->isEmpty()) {
            return JsonResponse::error('No participants found for this conversation.', null, 404);
        }

        return JsonResponse::success('Participants retrieved successfully.', $participants);
    }
}
