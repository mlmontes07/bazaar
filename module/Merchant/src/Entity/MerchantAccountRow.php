<?php
namespace Merchant\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class MerchantAccountRow extends AbstractRowGateway
{
    protected $id;
    protected $bank_name;
    protected $bank_branch;
    protected $account_name;
    protected $account_number;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'merchant_account';
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
    
    public function setBankName($bank_name)
    {
        $this->data['bank_name'] = $bank_name;
        return $this;
    }
    
    public function getBankName()
    {
        return $this->data['bank_name'];
    }
    
    public function setBankBranch($bank_branch)
    {
        $this->data['bank_branch'] = $bank_branch;
        return $this;
    }
    
    public function getBankBranch()
    {
        return $this->data['bank_branch'];
    }
    
    public function setAccountName($account_name)
    {
        $this->data['account_name'] = $account_name;
        return $this;
    }
    
    public function getAccountName()
    {
        return $this->data['account_name'];
    }
    
    public function setAccountNumber($account_number)
    {
        $this->data['account_number'] = $account_number;
        return $this;
    }
    
    public function getAccountNumber()
    {
        return $this->data['account_number'];
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