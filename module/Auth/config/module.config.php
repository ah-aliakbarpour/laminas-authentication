<?php

namespace Auth;

use Auth\Controller\AuthController;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [

            'register' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/register',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'register',
                    ],
                ],
            ],
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'profile' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/profile',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'profile',
                    ],
                ],
            ],

        ],
    ],
    'controllers' => [
        'factories' => [
            AuthController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];