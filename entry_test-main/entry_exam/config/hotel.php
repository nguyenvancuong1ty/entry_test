<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Hotel Image Upload Configuration
    |--------------------------------------------------------------------------
    |
    | base_dir: Target directory under public/assets/img for stored hotel images.
    | temp_dir: Temporary directory under public/assets/img for multi-step confirmation.
    | max_size_kb: Maximum allowed image size in kilobytes (default 2048 KB = 2MB).
    | allowed_mimes: Allowed image mime extensions.
    |
    */
    'image' => [
        'base_dir' => env('HOTEL_IMAGE_BASE_DIR', 'hotel'),
        'temp_dir' => env('HOTEL_IMAGE_TEMP_DIR', 'hotel/tmp'),
        'max_size_kb' => (int) env('HOTEL_IMAGE_MAX_SIZE_KB', 2048),
        'allowed_mimes' => ['jpeg', 'png', 'jpg', 'gif', 'webp'],
    ],
];
