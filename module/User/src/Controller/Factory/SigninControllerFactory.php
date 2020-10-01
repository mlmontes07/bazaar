<?php

namespace User\Controller\Factory;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Controller\SigninController;
use Interop\Container\ContainerInterface;

class SigninControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $logger = $auth = $session = null;
        try {
            $auth = $container->get('AuthService');
            $adapter = $container->get('Laminas\Db\Adapter\Adapter');
            $logger = $container->get('AppLogger');
            $session = $container->get('SessionService');
        } catch (ServiceNotCreatedException $e) {}

        return new SigninController($adapter, $logger, $auth, $session);
    }
}