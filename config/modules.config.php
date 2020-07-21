<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Paginator',
    'Laminas\ServiceManager\Di',
    'Laminas\Log',
    'Laminas\Db',
    'Laminas\Mvc\Plugin\FilePrg',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Mvc\Plugin\Identity',
    'Laminas\Mvc\Plugin\Prg',
    'Laminas\Session',
    'Laminas\Mvc\Console',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\InputFilter',
    'Laminas\Filter',
    'Laminas\I18n',
    'Laminas\Cache',
    'Laminas\Router',
    'Laminas\Validator',
    'Laminas\DeveloperTools',
    'Laminas\Diactoros',
    'Laminas\ApiTools\Versioning',
    'Laminas\ApiTools\ApiProblem',
    'Laminas\ApiTools\ContentNegotiation',
    'Laminas\ApiTools\Rpc',
    'Laminas\ApiTools\MvcAuth',
    'Laminas\ApiTools\Hal',
    'Laminas\ApiTools\Rest',
    'Laminas\ApiTools\ContentValidation',
    'Laminas\ApiTools',
    'Application',
    'AppLogger',
    'Cart',
    'Document',
    'Merchant',
    'Order',
    'Payment',
    'Product',
    'User'
];
