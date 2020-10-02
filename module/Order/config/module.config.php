<?php
use Laminas\Router\Http\Segment;
use Order\Controller\OrderController;
use Order\Controller\Factory\OrderControllerFactory;
use Order\Controller\OrderOptionController;
use Order\Controller\Factory\OrderOptionControllerFactory;
use Order\Controller\OrderPaymentController;
use Order\Controller\Factory\OrderPaymentControllerFactory;
use Order\Controller\OrderStatusController;
use Order\Controller\Factory\OrderStatusControllerFactory;
use Order\Controller\DeliveryController;
use Order\Controller\Factory\DeliveryControllerFactory;

return [
    'controllers' => [
        'factories' => [
            DeliveryController::class => DeliveryControllerFactory::class,
            OrderController::class => OrderControllerFactory::class,
            OrderOptionController::class => OrderOptionControllerFactory::class,
            OrderPaymentController::class => OrderPaymentControllerFactory::class,
            OrderStatusController::class => OrderStatusControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'order' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'router' => [
        'routes' => [
            'order' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/order[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => OrderController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'order-option' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/order-option[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => OrderOptionController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'order-payment' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/order-payment[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => OrderPaymentController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'order-status' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/order-status[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => OrderStatusController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'delivery' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/delivery[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => DeliveryController::class,
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ]
];