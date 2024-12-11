<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $users = User::factory(20)->create();
        // Create Group Conversations
        $groupConversations = Conversation::factory(5)->create(['type' => 'group']);
        foreach ($groupConversations as $conversation) {
            // Add random participants to group conversation
            $participants = $users->random(rand(3, 10));
            foreach ($participants as $user) {
                ConversationParticipant::factory()->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id,
                ]);
            }
            // Add messages to the group conversation
            foreach (range(1, 20) as $i) {
                Message::factory()->create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $participants->random()->id,
                ]);
            }
        }
        // Create Private Conversations
        foreach ($users->chunk(2) as $pair) {
            if ($pair->count() == 2) {
                $conversation = Conversation::factory()->create(['type' => 'private']);

                foreach ($pair as $user) {
                    ConversationParticipant::factory()->create([
                        'conversation_id' => $conversation->id,
                        'user_id' => $user->id,
                    ]);
                }
                // Add messages to the private conversation
                foreach (range(1, 10) as $i) {
                    Message::factory()->create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $pair->random()->id,
                    ]);
                }
            }
        }
    }
}
