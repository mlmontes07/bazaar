<?php
namespace User\Factory\Storage;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as DbTableAuthAdapter;
use User\Storage\AuthenticationStorage;
use Interop\Container\ContainerInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $credentialCallback = function ($passwordInDatabase, $passwordProvided) {
            return password_verify($passwordProvided, $passwordInDatabase);
        };

        $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', $credentialCallback);

        $storage = new AuthenticationStorage('MarketPlace');
        $authService = new AuthenticationService($storage, $dbTableAuthAdapter);

        return $authService;
    }
}