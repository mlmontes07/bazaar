<?php 
namespace Merchant\Model;

use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Select;
use Merchant\Entity\MerchantHeartRow;

class MerchantHeart extends AbstractTableGateway
{
    protected $table = 'merchant_heart';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->select(function (Select $select) {
            $select->columns([
                '*'
            ])
            ->order('id ASC');
        });
        if (! $resultSet)
            return [];
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new MerchantHeartRow($this->adapter, $row));
        }
        return $return;
    }
    
    public function findById($id)
    {
        $result = $this->select(function (Select $select) use ($id) {
            $select->columns([
                '*'
            ])
            ->where([
                'id' => $id
            ]);
        })->current();
        if (! $result)
            return [];
            return new MerchantHeartRow($this->adapter, $result);
    }
}