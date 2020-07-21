<?php
use Laminas\Router\Http\Segment;
use User\Factory\Storage\AuthenticationServiceFactory;
use User\Factory\Storage\IdentityManagerFactory;
use User\Controller\SigninController;
use User\Controller\Factory\SigninControllerFactory;
use User\Controller\SignoutController;
use User\Controller\Factory\SignoutControllerFactory;

return [
    'controllers' => [
        'factories' => [
            SigninController::class => SigninControllerFactory::class,
            SignoutController::class => SignoutControllerFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'user' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'service_manager' => [
        'factories' => [
            'AuthService' => AuthenticationServiceFactory::class,
            'IdentityManager' => IdentityManagerFactory::class
        ]
    ],
    'router' => [
        'routes' => [
            'user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => '',
                        'action' => 'index'
                    ]
                ]
            ],
            'signin' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/signin[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => SigninController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'signout' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/signout[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => SignoutController::class,
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ]
];