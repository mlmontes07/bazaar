<?php
declare(strict_types = 1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Session\SessionManager;
use Laminas\Session\Container;
use Application\Library\Session;
use Application\View\Helper\ControllerName;
use User\Controller\SigninController;
use User\Controller\SignoutController;
use Laminas\Filter\FilterChain;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        date_default_timezone_set('Asia/Manila');
        
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $sharedManager->attach('Laminas\Mvc\Application', 'dispatch.error', function ($e) use ($sm) {
            if ($e->getParam('exception')) {
                $sm->get('AppLogger')->crit($e->getParam('exception'));
            }
        });
            
        $this->bootstrapSession($e);
        
        $view = $sm->get('ViewRenderer');
        $pluginManager = $view->getHelperPluginManager();
        $pluginManager->setAlias('controllerName', ControllerName::class);
        
        # Register a factory
        $pluginManager->setFactory(ControllerName::class, function () use ($e) {
            $controllerNameHelper = new ControllerName($e->getRouteMatch());
            return $controllerNameHelper;
        });
        
        $auth = $sm->get('AuthService');
        $session = $sm->get('SessionService');
                
        $sharedManager->attach('Laminas\Mvc\Controller\AbstractActionController', 'dispatch', function ($e) use ($sm, $auth) {
            $controller = $e->getTarget();
            $thisRequest = $e->getApplication()->getRequest();
            
            if (! 
                ($controller instanceof SigninController ||
                 $controller instanceof SignoutController)
                ) {
                if (! $auth->hasIdentity()) {
                    $url = $e->getRouter()->assemble([
                        'action' => 'index'
                    ], [
                        'name' => 'signin'
                    ]);
                    if ($thisRequest->isXmlHttpRequest()) {
                        die('<p style="padding:10px 20px;margin:0;">Please <a href="/" class="btn btn-xs btn-primary">re-login</a>. Your session has expired.</p>');
                    } else {
                        $response = $e->getResponse();
                        $response->getHeaders()->addHeaderLine('Location', $url);
                        $response->getHeaders()->addHeaderLine('MarketPlace', 'login');
                        $response->setStatusCode(301);
                        $response->sendHeaders();
                        exit();
                    }
                } else {
                    $userData = $auth->getIdentity();
                    if ($userData) {
                        if (isset($userData['subscription']['status']) && ($userData['subscription']['status'] != 'active')) {
                            # redirect to account upgrade or renewal
                            $url = $e->getRouter()->assemble([
                                'action' => 'profile'
                            ], [
                                'name' => 'account'
                            ]);
                            $response = $e->getResponse();
                            $response->getHeaders()->addHeaderLine('Location', $url);
                            $response->getHeaders()->addHeaderLine('MarketPlace', 'account');
                            $response->setStatusCode(301);
                            $response->sendHeaders();
                            exit();
                        }
                    }
                }
            }
        }, 110);
        
        $eventManager->attach(MvcEvent::EVENT_RENDER, function ($e) use ($sm, $auth, $session) {
            $renderer = $sm->get('ViewRenderer');            
            # uncomment this to minify HTML and JS,CSS on returning views
            # $renderer->setFilterChain((new FilterChain())->attach(new MinifyHelper()));
            $viewModel = $e->getViewModel();
            $userData = ($auth->hasIdentity() ? $auth->getIdentity() : null);
            $viewModel->setVariables([
                'user_data' => $userData,
                'access_list' => $session->getAclList(),
                'ip_address' => $session->findIP(),
                'module_access' => $session->getSessionItem('module_access', []),
                'logged_in' => $auth->hasIdentity()
            ]);
        });
    }
    
    public function bootstrapSession(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $session = $serviceManager->get(SessionManager::class);
        $session->setName('ddphmarketplace');
        
        try {
            $container = new Container('MarketPlace', $session);
            if (! isset($container->init)) {
                $session->regenerateId(true);
                $container->init = 1;
            }
        } catch (\Exception $e) {
            $serviceManager->get('AppLogger')->crit($e->getMessage());
        }
    }
    
    public function getAutoloaderConfig()
    {
        return [
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }
    
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'minify' => 'Application\View\Helper\MinifyHelper'
            ]
        ];
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'SessionService' => function ($sm) {
                    $adapter = $sm->get('Laminas\Db\Adapter\Adapter');
                    $logger = $sm->get('AppLogger');
                    $config = $sm->get('config');
                    $userSession = $sm->get('MarketPlace');
                    return new Session($adapter, $logger, $config, $userSession);
                }
            ]
        ];
    }
}