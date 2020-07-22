<?php
namespace Product\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class ProductRow extends AbstractRowGateway
{
    protected $id;
    protected $merchant_id;
    protected $name;
    protected $price;
    protected $discount_price;
    protected $description;
    protected $weight;
    protected $unit;
    protected $is_featured;
    protected $is_deliverable;
    protected $product_category_id;
    protected $image_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'product';
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
    
    public function setName($name)
    {
        $this->data['name'] = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->data['name'];
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
    
    public function setDiscountPrice($discount_price)
    {
        $this->data['discount_price'] = $discount_price;
        return $this;
    }
    
    public function getDiscountPrice()
    {
        return $this->data['discount_price'];
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
    
    public function setWeight($weight)
    {
        $this->data['weight'] = $weight;
        return $this;
    }
    
    public function getWeight()
    {
        return $this->data['weight'];
    }
    
    public function setUnit($unit)
    {
        $this->data['unit'] = $unit;
        return $this;
    }
    
    public function getUnit()
    {
        return $this->data['unit'];
    }
    
    public function setIsFeatured($is_featured)
    {
        $this->data['is_featured'] = $is_featured;
        return $this;
    }
    
    public function getIsFeatured()
    {
        return $this->data['is_featured'];
    }
    
    public function setIsDeliverable($is_deliverable)
    {
        $this->data['is_deliverable'] = $is_deliverable;
        return $this;
    }
    
    public function getIsDeliverable()
    {
        return $this->data['is_deliverable'];
    }
    
    public function setProductCategoryId($product_category_id)
    {
        $this->data['product_category_id'] = $product_category_id;
        return $this;
    }
    
    public function getProductCategoryId()
    {
        return $this->data['product_category_id'];
    }
    
    public function setImageId($image_id)
    {
        $this->data['image_id'] = $image_id;
        return $this;
    }
    
    public function getImageId()
    {
        return $this->data['image_id'];
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