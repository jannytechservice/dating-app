<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_conversations()
    {
        $user = User::factory()->create();
        Conversation::factory()->count(3)->create();

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/conversations')
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Conversations retrieved successfully.',
            ]);
    }

    public function test_store_conversation()
    {
        $user = User::factory()->create();

        $payload = [
            "type" => "private",
            "name" => "password"
        ];

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/conversations', $payload)
            ->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Conversation created successfully.',
            ]);
    }

    public function test_add_participant_to_conversation()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();
        $participant = User::factory()->create();

        $payload = [
            'user_id' => $participant->id,
        ];

        $this->actingAs($user, 'sanctum')
            ->postJson("/api/conversations/{$conversation->id}/participants", $payload)
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Participant added successfully.',
            ]);

        $this->assertDatabaseHas('conversation_participants', [
            'conversation_id' => $conversation->id,
            'user_id' => $participant->id,
        ]);
    }

    public function test_remove_participant_from_conversation()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();
        $participant = User::factory()->create();

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $participant->id,
        ]);

        $payload = [
            'user_id' => $participant->id,
        ];

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/conversations/{$conversation->id}/participants", $payload)
            ->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Participant removed successfully.',
            ]);

        $this->assertDatabaseMissing('conversation_participants', [
            'conversation_id' => $conversation->id,
            'user_id' => $participant->id,
        ]);
    }

    public function test_get_participants_of_conversation()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();
        $participants = User::factory()->count(3)->create();

        foreach ($participants as $participant) {
            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $participant->id,
            ]);
        }

        $this->actingAs($user, 'sanctum')
            ->getJson("/api/conversations/{$conversation->id}/participants")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Participants retrieved successfully.',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => ['id', 'name', 'email'],
                ],
            ]);
    }
}
