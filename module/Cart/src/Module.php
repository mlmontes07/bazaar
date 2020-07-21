<?php
namespace Cart;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/../src'
                ]
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => []
        ];
    }
}