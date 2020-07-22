<?php
namespace Cart\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class CartContentRow extends AbstractRowGateway
{
    protected $id;
    protected $cart_id;
    protected $product_id;
    protected $quantity;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'cart_content';
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
    
    public function setCartId($cart_id)
    {
        $this->data['cart_id'] = $cart_id;
        return $this;
    }
    
    public function getCartId()
    {
        return $this->data['cart_id'];
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
    
    public function setQuantity($quantity)
    {
        $this->data['quantity'] = $quantity;
        return $this;
    }
    
    public function getQuantity()
    {
        return $this->data['quantity'];
    }
}