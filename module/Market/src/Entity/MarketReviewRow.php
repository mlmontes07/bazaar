<?php
namespace Market\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class MarketReviewRow extends AbstractRowGateway
{
    protected $id;
    protected $review;
    protected $rate;
    protected $user_id;
    protected $market_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'market_review';
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
    
    public function setReview($review)
    {
        $this->data['review'] = $review;
        return $this;
    }
    
    public function getReview()
    {
        return $this->data['review'];
    }
    
    public function setRate($rate)
    {
        $this->data['rate'] = $rate;
        return $this;
    }
    
    public function getRate()
    {
        return $this->data['rate'];
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
    
    public function setUserId($user_id)
    {
        $this->data['user_id'] = $user_id;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->data['user_id'];
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