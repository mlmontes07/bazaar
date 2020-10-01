<?php
namespace User\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Controller\SignoutController;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;

class SignoutControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $logger = $auth = null;
        try {
            $auth = $container->get('AuthService');
            $logger = $container->get('AppLogger');
        } catch (ServiceNotCreatedException $e) {}

        return new SignoutController($logger, $auth);
    }
}