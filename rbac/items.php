<?php
return [
    'permAdminPanel' => [
        'type' => 2,
        'description' => 'Admin panel',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'children' => [
            'user',
            'permAdminPanel',
        ],
    ],
];
