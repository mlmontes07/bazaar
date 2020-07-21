<?php
namespace Order\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class OrderPaymentRow extends AbstractRowGateway
{
    protected $id;
    protected $amount;
    protected $user_id;
    protected $payment_status_id;
    protected $payment_method_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'order_payment';
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
    
    public function setAmount($amount)
    {
        $this->data['amount'] = $amount;
        return $this;
    }
    
    public function getAmount()
    {
        return $this->data['amount'];
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
    
    public function setPaymentStatusId($payment_status_id)
    {
        $this->data['payment_status_id'] = $payment_status_id;
        return $this;
    }
    
    public function getPaymentStatusId()
    {
        return $this->data['payment_status_id'];
    }
    
    public function setPaymentMethodId($payment_method_id)
    {
        $this->data['payment_method_id'] = $payment_method_id;
        return $this;
    }
    
    public function getPaymentMethodId()
    {
        return $this->data['payment_method_id'];
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