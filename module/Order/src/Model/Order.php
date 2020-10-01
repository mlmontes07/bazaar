<?php 
namespace Order\Model;

use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Select;
use Order\Entity\OrderRow;

class Order extends AbstractTableGateway
{
    protected $table = 'order';
    
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
            array_push($return, new OrderRow($this->adapter, $row));
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
        return new OrderRow($this->adapter, $result);
    }
    
    public function findByName($name)
    {
        $result = $this->select(function (Select $select) use ($name) {
            $select->columns([
                '*'
            ])
            ->where([
                'name' => $name
            ]);
        })->current();
        if (! $result)
            return [];
        return new OrderRow($this->adapter, $result);
    }
}