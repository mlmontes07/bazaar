<?php
declare(strict_types=1);

namespace Order\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\Adapter;
use Laminas\Log\Logger;
use Application\Library\Session;
use Laminas\Db\Sql\Sql;
use Laminas\View\Model\JsonModel;

class OrderPaymentController extends AbstractActionController
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
        
        return new ViewModel([
            
        ]);
    }
    
    public function getMarketsAction()
    {
        $reqData = $this->params()->fromQuery();
        
        $limit = (ctype_digit($reqData['length'])) ? (int) $reqData['length'] : 10;
        $limit_offset = (ctype_digit($reqData['start'])) ? (int) $reqData['start'] : 0;
        
        return new JsonModel([
            'draw' => $reqData['draw'],
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
            'message' => 'Fetch successful.',
            'success' => true
        ]);
    }
}
