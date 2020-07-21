<?php
namespace User\Model;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Predicate\Like;
use Laminas\Db\Sql\Predicate\PredicateSet;
use User\Entity\RoleRow;

class Role extends AbstractTableGateway
{
    protected $table = 'role';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll()
    {
        $resultSet = $this->select(function (Select $select) {
            $select->columns([
                'id',
                'name',
                'description'
            ])
            ->where([
                'deleted' => 0
            ])
            ->order('id ASC');
        });
        if (! $resultSet)
            return [];
        $return = [];
        foreach ($resultSet as $set) {
            array_push($return, new RoleRow($this->adapter, $set));
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
            return $result;
        return new RoleRow($this->adapter, $result);
    }

    public function search($slug)
    {
        $resultSet = $this->select(function (Select $select) use ($slug) {
            $select->columns([
                'id',
                'name',
                'description'
            ])
            ->join('access_list', 'access_list.role_id = role.id', [
                'role_id',
                'application_resource_id',
                'access_list_id' => 'id',
                'access_list_deleted' => 'deleted'
            ], $select::JOIN_LEFT)
            ->join('application_resource', 'application_resource.id = access_list.application_resource_id', [
                'module',
                'controller',
                'action'
            ], $select::JOIN_LEFT)
            ->where([
                'role.deleted' => 0,
                new PredicateSet([
                    new Like('name', "%$slug%"),
                    new Like('module', "%$slug%"),
                    new Like('controller', "%$slug%"),
                    new Like('action', "%$slug%")
                ], PredicateSet::OP_OR)
            ])
            ->order([
                'role.id DESC'
            ]);
        });

        $returnArray = [];

        if (! $resultSet)
            return false;

        foreach ($resultSet as $set) :
            if (! array_key_exists($set->id, $returnArray)) {
                $returnArray[$set->id] = [
                    'role_name' => $set->name,
                    'role_id' => $set->id,
                    'access_list' => []
                ];
            }
            if (isset($set->module, $set->controller, $set->action))
                $returnArray[$set->id]['access_list'][$set->application_resource_id] = $set->module . '|' . $set->controller . '|' . $set->action;
        endforeach
        ;

        return $returnArray;
    }
}