<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'user_id'];

    // Conversation this participant belongs to
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // User participating in the conversation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
