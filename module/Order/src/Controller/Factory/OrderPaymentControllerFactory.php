<?php

namespace Order\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Order\Controller\OrderPaymentController;

class OrderPaymentControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $adapter = $logger = $session = null;
    try {
      $adapter = $container->get('Laminas\Db\Adapter\Adapter');
      $logger = $container->get('AppLogger');
      $session = $container->get('SessionService');
    } catch (ServiceNotCreatedException $e) {}
    
    return new OrderPaymentController($adapter, $logger, $session);
  }
}