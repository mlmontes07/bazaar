<?php
declare(strict_types=1);

namespace Market\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\Adapter;
use Laminas\Log\Logger;
use Application\Library\Session;
use Laminas\Db\Sql\Sql;
use Laminas\View\Model\JsonModel;

class MarketCategoryController extends AbstractActionController
{
    protected $adapter;
    protected $logger;
    protected $session;
    
    public function __construct(
        Adapter $adapter,
        Logger $logger,
        Session $session
    )
    {
        $this->adapter = $adapter;
        $this->logger = $logger;
        $this->session = $session;
        $this->sqlObj = new Sql($adapter);
    }
    
    public function indexAction()
    {
        
        return new ViewModel([]);
    }
}
