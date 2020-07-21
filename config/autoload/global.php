<?php
use Laminas\Session\Validator\RemoteAddr;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Storage\SessionArrayStorage;

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'driver' => 'Pdo_Mysql',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ]
    ],
    'service_manager' => [
        'factories' => [
            'Laminas\Db\Adapter\Adapter' => 'Laminas\Db\Adapter\AdapterServiceFactory',
            'Laminas\Session\ManagerInterface' => 'Laminas\Session\Service\SessionManagerFactory',
            'Laminas\Session\Config\ConfigInterface' => 'Laminas\Session\Service\SessionConfigFactory'
        ],
        'aliases' => [
            'AppLogger' => 'AppLogger\AppLogger'
        ]
    ],
    'session_config' => [
        'cache_expire' => 60 * 60 * 24,
        'cookie_lifetime' => 60 * 60 * 24, // 1-day cookie lifetime,
        'gc_maxlifetime' => 60 * 60 * 24 * 30 // 30-day session garbage cleanup
    ],
    'session_manager' => [
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class
        ]
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    'session_containers' => [
        'MarketPlace'
    ]
];