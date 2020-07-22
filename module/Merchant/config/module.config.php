<?php
use Merchant\Controller\MerchantController;
use Merchant\Controller\Factory\MerchantControllerFactory;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            MerchantController::class => MerchantControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'merchant' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'router' => [
        'routes' => [
            'merchant' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/merchant[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => MerchantController::class,
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ]
];