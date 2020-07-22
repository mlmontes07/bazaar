<?php
namespace Merchant\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class MerchantPayoutRow extends AbstractRowGateway
{
    protected $id;
    protected $merchant_id;
    protected $payout_method_id;
    protected $amount;
    protected $date_paid;
    protected $note;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'merchant_payout';
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
    
    public function setMerchantId($merchant_id)
    {
        $this->data['merchant_id'] = $merchant_id;
        return $this;
    }
    
    public function getMerchantId()
    {
        return $this->data['merchant_id'];
    }
    
    public function setPayoutMethodId($payout_method_id)
    {
        $this->data['payout_method_id'] = $payout_method_id;
        return $this;
    }
    
    public function getPayoutMethodId()
    {
        return $this->data['payout_method_id'];
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
    
    public function setDatePaid($date_paid)
    {
        $this->data['date_paid'] = $date_paid;
        return $this;
    }
    
    public function getDatePaid()
    {
        return $this->data['date_paid'];
    }
    
    public function setNote($note)
    {
        $this->data['note'] = $note;
        return $this;
    }
    
    public function getNote()
    {
        return $this->data['note'];
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