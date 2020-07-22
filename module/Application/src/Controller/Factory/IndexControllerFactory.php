<?php

namespace Application\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Application\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $adapter = $logger = $session = null;
    try {
      $adapter = $container->get('Laminas\Db\Adapter\Adapter');
      $logger = $container->get('AppLogger');
      $session = $container->get('SessionService');
    } catch (ServiceNotCreatedException $e) {}
    
    return new IndexController($adapter, $logger, $session);
  }
}