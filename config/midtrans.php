<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitize' => env('MIDTRANS_IS_SANITIZE', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];