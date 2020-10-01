<?php 
namespace User\Model;

use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Select;
use User\Entity\UserDetailRow;

class UserDetail extends AbstractTableGateway
{
    protected $table = 'user_detail';
    
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
            array_push($return, new UserDetailRow($this->adapter, $row));
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
        return new UserDetailRow($this->adapter, $result);
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
        return new UserDetailRow($this->adapter, $result);
    }
}