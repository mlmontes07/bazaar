<?php
namespace Cart\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class CartRow extends AbstractRowGateway
{
    protected $id;
    protected $user_id;
    protected $date_created;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'cart';
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
    
    public function setUserId($user_id)
    {
        $this->data['user_id'] = $user_id;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->data['user_id'];
    }
    
    public function setDateCreated($date_created)
    {
        $this->data['date_created'] = $date_created;
        return $this;
    }
    
    public function getDateCreated()
    {
        return $this->data['date_created'];
    }
}