<?php

return [
    'type' => [
        'main' => 0,
        'retest' => 1,
    ],
    'status' => [
        'new' => 0,
        'progress' => 1,
        'finish' => 2,
        'marking' => 3,
        'done' => 4,
    ],
    'detail' => [
        'status' => [
            'register' => [
                'pending' => 0,
                'success' => 1
            ],
            'result' => [
                'relearn' => 0,
                'retest' => 1,
                'pass' => 2,
            ],
        ],
    ]
];
