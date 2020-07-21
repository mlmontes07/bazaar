<?php
namespace User\Storage;

use Laminas\Authentication\Storage;

class AuthenticationStorage extends Storage\Session
{
    protected $serviceLocator;
    protected $namespace;

    public function __construct($namespace = null, $member = null)
    {
        parent::__construct($namespace);

        $this->namespace = $namespace;
        $this->member = $member ? $member : session_id();
    }

    /*
     * public function setDbHandler()
     * {
     * $tableGateway = new TableGateway('session', $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
     * $saveHandler = new DbTableGateway($tableGateway, new DbTableGatewayOptions());
     *
     * //open session
     * $sessionConfig = new SessionConfig();
     * $saveHandler->open($sessionConfig->getOption('save_path'), $this->namespace);
     * $this->session->getManager()->setSaveHandler($saveHandler);
     * }
     *
     * public function write($contents)
     * {
     * parent::write($contents);
     * //check if $contents is array
     * if (is_array($contents) && !empty($contents)) {
     * $this->getSessionManager()
     * ->getSaveHandler()->write($this->getSessionId(), \Zend\Json\Json::encode($contents));
     * }
     * }
     */
    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }

    public function clear()
    {
        if ($this->getSessionManager()->getSaveHandler())
            $this->getSessionManager()
                 ->getSaveHandler()
                 ->destroy($this->getSessionId());
        
        parent::clear();
    }

    public function getSessionManager()
    {
        return $this->session->getManager();
    }

    public function getSessionId()
    {
        return $this->session->getManager()->getId();
    }
}