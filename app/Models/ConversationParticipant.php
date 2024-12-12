<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversationParticipant extends Model
{
    /** @use HasFactory<\Database\Factories\ConversationParticipantFactory> */
    use HasFactory;

    /**
     * @var list<string> 
     */
    protected $fillable = ['conversation_id', 'user_id'];

    /**
     * Conversation this participant belongs to.
     *
     * @return BelongsTo<Conversation, ConversationParticipant>
     */
    public function conversation(): BelongsTo
    {
        /** @var BelongsTo<Conversation, ConversationParticipant> $relation */
        $relation = $this->belongsTo(Conversation::class);

        return $relation;
    }

    /**
     * User participating in the conversation.
     *
     * @return BelongsTo<User, ConversationParticipant>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, ConversationParticipant> $relation */
        $relation = $this->belongsTo(User::class);

        return $relation;
    }
}
