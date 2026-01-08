<?php

use Illuminate\Support\Str;

if (!function_exists('guestToken')) {
    function guestToken()
    {
        if (request()->hasHeader('X-GUEST-TOKEN')) {
            return request()->header('X-GUEST-TOKEN');
        }

        if (request()->cookie('guest_token')) {
            return request()->cookie('guest_token');
        }

        $token = (string) Str::uuid();
        cookie()->queue('guest_token', $token, 60 * 24 * 30);

        return $token;
    }
}