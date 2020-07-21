<?php
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'payment' => __DIR__ . '/../view'
        ],
        'template_map' => [
        ]
    ],
    'router' => [
        'routes' => [
            'payment' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/payment[/:action][/:id]',
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