<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_messages_successfully()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();
        $messages = Message::factory()->count(3)->create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->getJson("/api/messages/{$conversation->id}")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Messages retrieved successfully.',
                'data' => $messages->toArray(),
            ]);
    }

    public function test_get_messages_no_messages()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();

        $this->actingAs($user)
            ->getJson("/api/messages/{$conversation->id}")
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'No messages found for this conversation.',
            ]);
    }

    public function test_send_message_successfully()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();

        $payload = [
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => 'Test message',
        ];

        $this->actingAs($user)
            ->postJson('/api/messages', $payload)
            ->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Message sent successfully.',
                'data' => [
                    'conversation_id' => $conversation->id,
                    'sender_id' => $user->id,
                    'message' => 'Test message',
                ],
            ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => 'Test message',
        ]);
    }
}
