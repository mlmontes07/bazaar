<?php
use Laminas\Router\Http\Segment;
use Product\Controller\Factory\ProductControllerFactory;
use Product\Controller\ProductController;
use Product\Controller\ProductCategoryController;
use Product\Controller\Factory\ProductCategoryControllerFactory;
use Product\Controller\ProductOptionController;
use Product\Controller\Factory\ProductOptionControllerFactory;
use Product\Controller\ProductOptionGroupController;
use Product\Controller\Factory\ProductOptionGroupControllerFactory;
use Product\Controller\ProductReviewController;
use Product\Controller\Factory\ProductReviewControllerFactory;

return [
    'controllers' => [
        'factories' => [
            ProductController::class => ProductControllerFactory::class,
            ProductCategoryController::class => ProductCategoryControllerFactory::class,
            ProductOptionController::class => ProductOptionControllerFactory::class,
            ProductOptionGroupController::class => ProductOptionGroupControllerFactory::class,
            ProductReviewController::class => ProductReviewControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'product' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'router' => [
        'routes' => [
            'product' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => ProductController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'product-category' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product-category[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => ProductCategoryController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'product-option' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product-option[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => ProductOptionController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'product-option-group' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product-option-group[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => ProductOptionGroupController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'product-review' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product-review[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => ProductReviewController::class,
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ]
];