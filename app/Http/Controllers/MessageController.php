<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Services\MessageService;
use App\Http\Requests\Message\SendMessageRequest;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    protected $messageService;

    /**
     * MessageController constructor.
     *
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Get all messages for a conversation.
     *
     * @param int $conversationId
     * @return JsonResponse
     */
    public function index($conversationId)
    {
        $messages = $this->messageService->getMessages($conversationId);

        if ($messages->isEmpty()) {
            return JsonResponse::error('No messages found for this conversation.', null, Response::HTTP_NOT_FOUND);
        }

        return JsonResponse::success('Messages retrieved successfully.', $messages, Response::HTTP_OK);
    }

    /**
     * Send a new message within a conversation.
     *
     * @param SendMessageRequest $request
     * @return JsonResponse
     */
    public function store(SendMessageRequest $request)
    {
        $message = $this->messageService->sendMessage($request->validated());
        return JsonResponse::success('Message sent successfully.', $message, Response::HTTP_CREATED);
    }
}
