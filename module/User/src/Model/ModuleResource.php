<?php
namespace User\Model;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Sql\Select;
use User\Entity\ModuleResourceRow;

class ModuleResource extends AbstractTableGateway
{
    protected $table = 'module_resource';

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
            ->where([
                'deleted' => 0
            ])
            ->order('id ASC');
        });
        if (! $resultSet)
            return [];
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new ModuleResourceRow($this->adapter, $row));
        }
        return $return;
    }

    public function findVar($var)
    {
        $result = $this->select(function (Select $select) use ($var) {
            $select->columns([
                '*'
            ])
            ->where([
                'deleted' => 0,
                'module_var' => $var
            ]);
        })->current();
        if (! $result)
            return [];
        return new ModuleResourceRow($this->adapter, $result);
    }

    public function findById($id)
    {
        $result = $this->select(function (Select $select) use ($id) {
            $select->columns([
                '*'
            ])
            ->where([
                'deleted' => 0,
                'id' => $id
            ]);
        })->current();
        if (! $result)
            return [];
        return new ModuleResourceRow($this->adapter, $result);
    }
}