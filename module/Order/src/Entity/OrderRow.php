<?php
namespace Order\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class OrderRow extends AbstractRowGateway
{
    protected $id;
    protected $user_id;
    protected $order_status_id;
    protected $delivery_fee;
    protected $driver_id;
    protected $delivery_address_id;
    protected $order_payment_id;
    protected $product_id;
    protected $quantity;
    protected $total_amount;
    protected $market_id;
    protected $applied_tax;
    protected $commission;
    protected $market_earning;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'client_order';
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
    
    public function setOrderStatusId($order_status_id)
    {
        $this->data['order_status_id'] = $order_status_id;
        return $this;
    }
    
    public function getOrderStatusId()
    {
        return $this->data['order_status_id'];
    }
    
    public function setDeliveryFee($delivery_fee)
    {
        $this->data['delivery_fee'] = $delivery_fee;
        return $this;
    }
    
    public function getDeliveryFee()
    {
        return $this->data['delivery_fee'];
    }
    
    public function setDriverId($driver_id)
    {
        $this->data['driver_id'] = $driver_id;
        return $this;
    }
    
    public function getDriverId()
    {
        return $this->data['driver_id'];
    }
    
    public function setDeliveryAddressId($delivery_address_id)
    {
        $this->data['delivery_address_id'] = $delivery_address_id;
        return $this;
    }
    
    public function getDeliveryAddressId()
    {
        return $this->data['delivery_address_id'];
    }
    
    public function setOrderPaymentId($order_payment_id)
    {
        $this->data['order_payment_id'] = $order_payment_id;
        return $this;
    }
    
    public function getOrderPaymentId()
    {
        return $this->data['order_payment_id'];
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
    
    public function setTotalAmount($total_amount)
    {
        $this->data['total_amount'] = $total_amount;
        return $this;
    }
    
    public function getTotalAmount()
    {
        return $this->data['total_amount'];
    }
    
    public function setMarketId($market_id)
    {
        $this->data['market_id'] = $market_id;
        return $this;
    }
    
    public function getMarketId()
    {
        return $this->data['market_id'];
    }
    
    public function setAppliedTax($applied_tax)
    {
        $this->data['applied_tax'] = $applied_tax;
        return $this;
    }
    
    public function getAppliedTax()
    {
        return $this->data['applied_tax'];
    }
    
    public function setCommission($commission)
    {
        $this->data['commission'] = $commission;
        return $this;
    }
    
    public function getCommission()
    {
        return $this->data['commission'];
    }
    
    public function setMarketEarning($market_earning)
    {
        $this->data['market_earning'] = $market_earning;
        return $this;
    }
    
    public function getMarketEarning()
    {
        return $this->data['market_earning'];
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