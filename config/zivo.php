<?php

return [
    // This installation serves one store. Never reuse its keys in another installation.
    'store_id' => env('ZIVO_STORE_ID', 'orbitlinksolutions'),
    'public_url' => env('ZIVO_PUBLIC_URL', env('APP_URL', 'http://localhost')),
    'allow_local_http' => (bool) env('ZIVO_ALLOW_LOCAL_HTTP', false),
    'rate_limit' => (int) env('ZIVO_RATE_LIMIT', 60),
    'max_products' => (int) env('ZIVO_MAX_PRODUCTS', 5000),
    'currency' => 'KES',
    'tax_included' => env('ZIVO_TAX_INCLUDED', null),
    'webhooks' => [
        'enabled' => (bool) env('ZIVO_WEBHOOKS_ENABLED', false),
        'url' => env('ZIVO_WEBHOOK_URL'),
        'secret' => env('ZIVO_WEBHOOK_SECRET'),
        'max_attempts' => 8,
        'backoff' => [60, 300, 900, 3600, 10800, 21600, 43200],
    ],
];
