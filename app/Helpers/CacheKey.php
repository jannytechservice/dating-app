<?php

namespace App\Helpers;

/**
 * Helper class for generating cache keys.
 */
class CacheKey
{
    /**
     * Generate a cache key for conversation messages.
     *
     * @param int $conversationId
     * @return string
     */
    public static function conversationMessages(int $conversationId): string
    {
        return "conversation_messages_{$conversationId}";
    }

    /**
     * Generate a cache key for user conversations.
     *
     * @param int $userId
     * @return string
     */
    public static function userConversations(int $userId): string
    {
        return "user_{$userId}_conversations";
    }

    /**
     * Generate a cache key for conversation participants.
     *
     * @param int $conversationId
     * @return string
     */
    public static function participants(int $conversationId): string
    {
        return "conversation_{$conversationId}_participants";
    }
}
