<?php

namespace App\Helpers;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    private const TTL_MEDIUM = 600;
    
    /**
     * Cache data with a key, TTL, and callback.
     *
     * @param string $key
     * @param Closure $callback
     * @param int $ttl
     * @return mixed
     */
    public static function cache(string $key, Closure $callback, int $ttl = self::TTL_MEDIUM): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Invalidate a cache key.
     *
     * @param string $key
     * @return bool
     */
    public static function forget(string $key): bool
    {
        return Cache::forget($key);
    }
}