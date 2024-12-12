<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    /** @use HasFactory<\Database\Factories\ConversationFactory> */
    use HasFactory;

    /**
     * @var list<string> 
     */
    protected $fillable = ['type', 'name'];

    /**
     * Participants in the conversation.
     *
     * @return HasMany<ConversationParticipant, Conversation>
     */
    public function participants(): HasMany
    {
        /** @var HasMany<ConversationParticipant, Conversation> $relation */
        $relation = $this->hasMany(ConversationParticipant::class);

        return $relation;
    }

    /**
     * Messages in the conversation.
     *
     * @return HasMany<Message, Conversation>
     */
    public function messages(): HasMany
    {
        /** @var HasMany<Message, Conversation> $relation */
        $relation = $this->hasMany(Message::class);

        return $relation;
    }
}
