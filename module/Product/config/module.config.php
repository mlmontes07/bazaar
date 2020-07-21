<?php
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
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
                        'controller' => '',
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ]
];