<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['conversation_id', 'sender_id', 'message'];

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'messages';
    }

    /**
     * Conversation this message belongs to.
     *
     * @return BelongsTo<Conversation, Message>
     */
    public function conversation(): BelongsTo
    {
        /** @var BelongsTo<Conversation, Message> $relation */
        $relation = $this->belongsTo(Conversation::class);

        return $relation;
    }

    /**
     * User who sent the message.
     *
     * @return BelongsTo<User, Message>
     */
    public function sender(): BelongsTo
    {
        /** @var BelongsTo<User, Message> $relation */
        $relation = $this->belongsTo(User::class, 'sender_id');

        return $relation;
    }
}
