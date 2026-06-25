<?php

use App\Models\Setting;

if (! function_exists('setting')) {

    function setting(
        string $key,
        mixed $default = null
    ) {
        return Setting::query()
            ->where('key', $key)
            ->value('value')
            ?? $default;
    }
}