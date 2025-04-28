<?php
use Tornado\Controller\HomeController;

return [
    '/home' => [
        'handler' => [HomeController::class, 'index'],
        'httpMethod' => ['GET'],
        'security'   => null,  // e.g. 'jwt
    ],
    '/home/{user_id}' => [
        'handler' => [HomeController::class, 'showUser'],
        'httpMethod' => ['GET'],
        'security'   => null,
    ],
];
