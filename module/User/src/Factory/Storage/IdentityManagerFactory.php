<?php
namespace User\Factory\Storage;

use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Storage\IdentityManager;
use Interop\Container\ContainerInterface;

class IdentityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authService = $container->get('AuthService');
        return new IdentityManager($authService);
    }
}