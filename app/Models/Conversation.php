<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name'];

    // Participants in the conversation
    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    // Messages in the conversation
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
