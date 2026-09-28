<?php

// Replace nulls only with approved business policies. null means unknown, not free.
return [
    'delivery_areas' => ['Kenya'],
    'delivery_pricing_rules' => [
        [
            'service' => 'delivery',
            'amount' => null,
            'currency' => 'KES',
            'requires_quotation' => true,
            'description' => 'Contact support for a delivery quotation for your destination and items.',
        ],
    ],
    'payment_methods' => null,
    'warranty' => null,
    'returns' => null,
    'opening_hours' => null,
    'timezone' => 'Africa/Nairobi',
];
