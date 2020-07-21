<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;
use Laminas\Log\Logger;

class SignoutController extends AbstractActionController
{
    protected $logger;
    protected $auth;

    public function __construct(Logger $logger, AuthenticationService $auth)
    {
        $this->auth = $auth;
        $this->logger = $logger;
    }

    public function indexAction()
    {
        if (! $this->auth->hasIdentity()) {
            return $this->redirect()->toUrl('/');
        }

        $redirect = $this->params()->fromQuery('redirect', null);
        $this->auth->clearIdentity();
        @session_regenerate_id(true);

        return $redirect ? $this->redirect()->toUrl($redirect) : $this->redirect()->toUrl('/');
    }
}
