<?php
namespace Product\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class ProductOptionRow extends AbstractRowGateway
{
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $product_id;
    protected $option_group_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'product_option';
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
    
    public function setName($name)
    {
        $this->data['name'] = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->data['name'];
    }
    
    public function setDescription($description)
    {
        $this->data['description'] = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->data['description'];
    }
    
    public function setPrice($price)
    {
        $this->data['price'] = $price;
        return $this;
    }
    
    public function getPrice()
    {
        return $this->data['price'];
    }
    
    public function setProductId($product_id)
    {
        $this->data['product_id'] = $product_id;
        return $this;
    }
    
    public function getProductId()
    {
        return $this->data['product_id'];
    }
    
    public function setOptionGroupId($option_group_id)
    {
        $this->data['option_group_id'] = $option_group_id;
        return $this;
    }
    
    public function getOptionGroupId()
    {
        return $this->data['option_group_id'];
    }
    
    public function setUpdatedBy($updated_by)
    {
        $this->data['updated_by'] = $updated_by;
        return $this;
    }
    
    public function getUpdatedBy()
    {
        return $this->data['updated_by'];
    }
    
    public function setDeleted($deleted)
    {
        $this->data['deleted'] = $deleted;
        return $this;
    }
    
    public function getDeleted()
    {
        return $this->data['deleted'];
    }
}