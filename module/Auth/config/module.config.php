<?php

namespace Auth;

use Auth\Controller\AuthController;
use Auth\Factory\AuthControllerFactory;
use Auth\Factory\UserFactory;
use Auth\Factory\UserRepositoryFactory;
use Auth\Model\User;
use Auth\Repository\UserRepository;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            User::class => UserFactory::class,
            UserRepository::class => UserRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            AuthController::class => AuthControllerFactory::class,
        ],
    ],
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
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];