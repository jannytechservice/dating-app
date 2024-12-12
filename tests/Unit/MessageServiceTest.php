<?php

namespace Tests\Unit;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class MessageServiceTest extends TestCase
{
    protected $messageRepositoryMock;
    protected $messageService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageRepositoryMock = Mockery::mock(MessageRepositoryInterface::class);
        $this->messageService = new MessageService($this->messageRepositoryMock);
    }

    public function test_get_messages()
    {
        $conversationId = 1;
        $messages = new Collection([Message::factory()->make(), Message::factory()->make()]);

        $this->messageRepositoryMock
            ->shouldReceive('getMessagesByConversationId')
            ->once()
            ->with($conversationId)
            ->andReturn($messages);

        $result = $this->messageService->getMessages($conversationId);

        $this->assertEquals($messages, $result);
    }

    public function test_send_message()
    {
        $data = [
            'conversation_id' => 1,
            'sender_id' => 1,
            'message' => 'Test message',
        ];

        $createdMessage = (object) $data;

        $this->messageRepositoryMock
            ->shouldReceive('createMessage')
            ->once()
            ->with($data)
            ->andReturn($createdMessage);

        $result = $this->messageService->sendMessage($data);

        $this->assertEquals($createdMessage, $result);
    }
}
