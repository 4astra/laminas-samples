<?php

namespace Authen;

use Laminas\Router\Http\Segment;

return [
    'router' => [

        'routes' => [
            'authen' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/authen[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthenController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'authen' => __DIR__ . '/../view',
        ],
    ],
    'translator' => [
        'locale' => 'vi_VI',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php'
            ],
        ],
    ],
];
