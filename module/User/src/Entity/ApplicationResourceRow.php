<?php
namespace User\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use User\Model\ApplicationResource;

class ApplicationResourceRow extends AbstractRowGateway
{
    protected $id;
    protected $resource_name;
    protected $module_id;
    protected $parent_id;
    protected $add;
    protected $edit;
    protected $view;
    protected $delete;
    protected $adapter = null;
    protected $table = 'application_resource';
    protected $primaryKeyColumn = [
        'id'
    ];

    public function __construct(Adapter $adapter, $row = null)
    {
        $this->sql = new Sql($adapter, $this->table);
        $this->adapter = $adapter;

        if ($row) {
            if (($row instanceof \ArrayObject)) {
                $options = (array) $row;
                $this->populate($options, true);
            } elseif (is_array($row)) {
                $options = $row;
            } else {
                throw new \Exception('Invalid data supplied');
            }
        }
        if (isset($options) && is_array($options)) {
            $this->setOptions($options);
        }

        $this->initialize();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $key = $this->formatKey($key);
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
            if ($method == 'setId') {
                $this->data['id'] = $value;
            }
        }
        return $this;
    }

    public function formatKey($key)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($key))));
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function setResourceName($resource_name)
    {
        $this->data['resource_name'] = $resource_name;
        return $this;
    }

    public function getResourceName()
    {
        return $this->data['resource_name'];
    }

    public function setModuleId($module_id)
    {
        $this->data['module_id'] = $module_id;
        return $this;
    }

    public function getModuleId()
    {
        return $this->data['module_id'];
    }

    public function setParentId($parent_id)
    {
        $this->data['parent_id'] = $parent_id;
        return $this;
    }

    public function getParentId()
    {
        return $this->data['parent_id'];
    }

    public function setAdd($add)
    {
        $this->data['add'] = $add;
        return $this;
    }

    public function getAdd()
    {
        return $this->data['add'];
    }

    public function setEdit($edit)
    {
        $this->data['edit'] = $edit;
        return $this;
    }

    public function getEdit()
    {
        return $this->data['edit'];
    }

    public function setView($view)
    {
        $this->data['view'] = $view;
        return $this;
    }

    public function getView()
    {
        return $this->data['view'];
    }

    public function setDelete($delete)
    {
        $this->data['delete'] = $delete;
        return $this;
    }

    public function getDelete()
    {
        return $this->data['delete'];
    }

    public function getChildren()
    {
        $objects = [];
        # find the objects in application resource table that is a child of this object
        if ($this->getId()) {
            $applicationResource = new ApplicationResource($this->adapter);
            $objects = $applicationResource->findByParentId($this->getId());
        }
        return $objects;
    }
}