<?php

namespace Tests\Unit;

use App\Contracts\ConversationRepositoryInterface;
use App\Contracts\ConversationParticipantRepositoryInterface;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class ConversationServiceTest extends TestCase
{
    protected $conversationRepositoryMock;
    protected $participantRepositoryMock;
    protected $conversationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->conversationRepositoryMock = Mockery::mock(ConversationRepositoryInterface::class);
        $this->participantRepositoryMock = Mockery::mock(ConversationParticipantRepositoryInterface::class);

        $this->conversationService = new ConversationService(
            $this->conversationRepositoryMock,
            $this->participantRepositoryMock
        );
    }

    public function test_get_conversations()
    {
        $userId = 1;
        $conversations = ['conversation1', 'conversation2'];

        Auth::shouldReceive('id')->once()->andReturn($userId);
        $this->conversationRepositoryMock
            ->shouldReceive('getConversationsByUserId')
            ->once()
            ->with($userId)
            ->andReturn($conversations);

        $result = $this->conversationService->getConversations();

        $this->assertEquals($conversations, $result);
    }

    public function test_create_conversation()
    {
        $userId = 1;
        $data = ['field1' => 'value1', 'field2' => 'value2'];
        $conversation = (object)['id' => 1];

        Auth::shouldReceive('id')->once()->andReturn($userId);
        $this->conversationRepositoryMock
            ->shouldReceive('createConversation')
            ->once()
            ->with($data)
            ->andReturn($conversation);

        $this->participantRepositoryMock
            ->shouldReceive('addParticipant')
            ->once()
            ->with([
                'conversation_id' => $conversation->id,
                'user_id' => $userId,
            ]);

        $result = $this->conversationService->createConversation($data);

        $this->assertEquals($conversation, $result);
    }

    public function test_add_participant()
    {
        $conversationId = 1;
        $userId = 2;

        $this->participantRepositoryMock
            ->shouldReceive('addParticipant')
            ->once()
            ->with([
                'conversation_id' => $conversationId,
                'user_id' => $userId,
            ]);

        $result = $this->conversationService->addParticipant($conversationId, $userId);

        $this->assertNull($result);
    }

    public function test_get_participants()
    {
        $conversationId = 1;
        $participants = ['user1', 'user2'];

        $this->participantRepositoryMock
            ->shouldReceive('getParticipants')
            ->once()
            ->with($conversationId)
            ->andReturn($participants);

        $result = $this->conversationService->getParticipants($conversationId);

        $this->assertEquals($participants, $result);
    }

    public function test_remove_participant()
    {
        $conversationId = 1;
        $userId = 2;

        $this->participantRepositoryMock
            ->shouldReceive('removeParticipant')
            ->once()
            ->with($conversationId, $userId);

        $result = $this->conversationService->removeParticipant($conversationId, $userId);

        $this->assertNull($result);
    }
}
