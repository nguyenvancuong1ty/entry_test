<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Booking Configuration
    |--------------------------------------------------------------------------
    |
    | datetime_format: Display format for booking timestamps (check-in, check-out)
    | when cast to string in views and serialized output.
    |
    */
    'datetime_format' => env('BOOKING_DATETIME_FORMAT', 'Y-m-d H:i'),
];
