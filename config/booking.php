<?php

return [
    'timezone' => 'Europe/London',
    'slot_minutes' => 30,
    'advance_days' => 28,
    'start_hour' => 9,
    'end_hour' => 17,
    'working_days' => [1, 2, 3, 4, 5], // Mon–Fri
    'notification_email' => env('BOOKING_NOTIFICATION_EMAIL', 'jamesontom57@gmail.com'),
];
