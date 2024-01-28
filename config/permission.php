<?php
use App\Models\User;
use App\Models\Post;
use App\Models\Application;

return [
    User::TYPE_EMPLOYER => [
        'post' => [
            'create' => true,
            'view' => true,
            'update' => true,
            'deactivate' => true,
            'activate' => true
        ],
        'application' => [
            'create' => false,
            'view' => true,
        ]
    ],
    User::TYPE_CANDIDATE => [
        'post' => [
            'create' => false,
            'view' => true,
            'update' => false,
            'deactivate' => false,
            'activate' => false
        ],
        'application' => [
            'create' => true,
            'view' => true,
        ]
    ]
];
