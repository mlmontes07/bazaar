<?php
namespace User\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use User\Model\ApplicationResource;

class ModuleResourceRow extends AbstractRowGateway
{
    protected $id;
    protected $name;
    protected $code;
    protected $adapter = null;
    protected $table = 'module_resource';
    protected $primaryKeyColumn = array(
        'id'
    );

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

    public function setName($name)
    {
        $this->data['name'] = $name;
        return $this;
    }

    public function getName()
    {
        return $this->data['_name'];
    }

    public function setCode($code)
    {
        $this->data['code'] = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->data['code'];
    }

    public function getObjects()
    {
        $objects = [];
        # find the objects in application resource table
        if ($this->getId()) {
            $applicationResource = new ApplicationResource($this->adapter);
            $objects = $applicationResource->findByModuleId($this->getId());
        }
        return $objects;
    }
}