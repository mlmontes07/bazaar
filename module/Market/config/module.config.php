<?php
use Market\Controller\MarketController;
use Market\Controller\Factory\MarketControllerFactory;
use Laminas\Router\Http\Segment;
use Market\Controller\Factory\MarketReviewControllerFactory;
use Market\Controller\MarketReviewController;
use Market\Controller\MarketCategoryController;
use Market\Controller\Factory\MarketCategoryControllerFactory;

return [
    'controllers' => [
        'factories' => [
            MarketController::class => MarketControllerFactory::class,
            MarketReviewController::class => MarketReviewControllerFactory::class,
            MarketCategoryController::class => MarketCategoryControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'market' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'router' => [
        'routes' => [
            'market' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/market[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => MarketController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'market-review' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/market-review[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => MarketReviewController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'market-category' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/market-category[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => MarketCategoryController::class,
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ]
];