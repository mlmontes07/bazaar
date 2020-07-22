<?php
namespace User\Factory\Storage;

use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Storage\AuthenticationStorage;
use Interop\Container\ContainerInterface;

class AuthenticationStorageFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthenticationStorage('MarketPlace');
    }
}