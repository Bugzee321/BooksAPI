<?php
// app/Services/CacheService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function get($key)
    {
        return Cache::get($key);
    }

    public function put($key, $value, $ttl = null)
    {
        if ($ttl === null) {
            Cache::forever($key, $value);
        } else {
            Cache::put($key, $value, $ttl);
        }
    }

    public function forget($key)
    {
        Cache::forget($key);
    }

    public function has($key)
    {
        return Cache::has($key);
    }
}
