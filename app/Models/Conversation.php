<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends BaseModel
{
    /** @use HasFactory<\Database\Factories\ConversationFactory> */
    use HasFactory;

    /**
     * @var list<string> 
     */
    protected $fillable = ['type', 'name'];

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'conversations';
    }

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
