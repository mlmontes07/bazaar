<?php
namespace User\Model;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Predicate\Like;
use Laminas\Db\Sql\Predicate\PredicateSet;
use User\Entity\ApplicationResourceRow;

class ApplicationResource extends AbstractTableGateway
{
    protected $table = 'application_resource';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll($count = false)
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
        if ($count)
            return $resultSet->count();
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new ApplicationResourceRow($this->adapter, $row));
        }
        return $return;
    }

    public function findByModuleId($module_id)
    {
        $resultSet = $this->select(function (Select $select) use ($module_id) {
            $select->columns([
                '*'
            ])
            ->where([
                'deleted' => 0,
                'module_id' => $module_id,
                'parent_id' => 0
            ])
            ->order('id ASC');
        });
        if (! $resultSet)
            return [];
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new ApplicationResourceRow($this->adapter, $row));
        }
        return $return;
    }

    public function findByParentId($parent_id)
    {
        $resultSet = $this->select(function (Select $select) use ($parent_id) {
            $select->columns([
                '*'
            ])
            ->where([
                'deleted' => 0,
                'parent_id' => $parent_id
            ])
            ->order('id ASC');
        });
        if (! $resultSet)
            return [];
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new ApplicationResourceRow($this->adapter, $row));
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
                'deleted' => 0,
                'id' => $id
            ]);
        })->current();
        if (! $result)
            return [];
        return new ApplicationResourceRow($this->adapter, $result);
    }

    public function search($slug, $count=false)
    {
        $resultSet = $this->select(function (Select $select) use ($slug) {
            $select->columns([
                '*'
            ])
            ->where([
                'deleted' => 0,
                new PredicateSet([
                    new Like('module', "%$slug%"),
                    new Like('controller', "%$slug%"),
                    new Like('action', "%$slug%")
                ], PredicateSet::OP_OR)
            ])
            ->order([
                'id DESC'
            ]);
        });
        if (! $resultSet)
            return [];
        if ($count)
            return $resultSet->count();
        $return = [];
        foreach ($resultSet as $row) {
            array_push($return, new ApplicationResourceRow($this->adapter, $row));
        }
        return $return;
    }
}