<?php

return [
    #HYPERPAY
    'HYPERPAY_BASE_URL' => env('HYPERPAY_BASE_URL', "https://eu-prod.oppwa.com"),
    'HYPERPAY_URL' => env('HYPERPAY_URL', env('HYPERPAY_BASE_URL') . "/v1/checkouts"),
    'HYPERPAY_TOKEN' => env('HYPERPAY_TOKEN', 'OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='),
    'HYPERPAY_CREDIT_ID' => env('HYPERPAY_CREDIT_ID', '8acda4ca83ceb2a10183ef0f0fbd566f'),
    'HYPERPAY_MADA_ID' => env('HYPERPAY_MADA_ID', '8acda4ca83ceb2a10183ef0fb9325679'),
    'HYPERPAY_APPLE_ID' => env('HYPERPAY_APPLE_ID', '8acda4ca83ceb2a10183ef37ffd858d8'),
    'HYPERPAY_CURRENCY' => env('HYPERPAY_CURRENCY', "SAR"),
];
