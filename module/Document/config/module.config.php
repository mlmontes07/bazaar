<?php
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => []
    ],
    'view_manager' => [
        'template_path_stack' => [
            'document' => __DIR__ . '/../view'
        ],
        'template_map' => []
    ],
    'router' => [
        'routes' => [
            'document' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/document[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]+'
                    ],
                    'defaults' => [
                        'controller' => '',
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ]
];