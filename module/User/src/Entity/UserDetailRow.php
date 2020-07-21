<?php
namespace User\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class UserDetailRow extends AbstractRowGateway
{
    protected $id;
    protected $user_id;
    protected $address_1;
    protected $address_2;
    protected $city_municipality;
    protected $province;
    protected $zip_code;
    protected $phone;
    protected $bio;
    protected $image_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'user_detail';
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
    
    public function setAddress1($address_1)
    {
        $this->data['address_1'] = $address_1;
        return $this;
    }
    
    public function getAddress1()
    {
        return $this->data['address_1'];
    }
    
    public function setAddress2($address_2)
    {
        $this->data['address_2'] = $address_2;
        return $this;
    }
    
    public function getAddress2()
    {
        return $this->data['address_2'];
    }
    
    public function setCityMunicipality($city_municipality)
    {
        $this->data['city_municipality'] = $city_municipality;
        return $this;
    }
    
    public function getCityMunicipality()
    {
        return $this->data['city_municipality'];
    }
    
    public function setProvince($province)
    {
        $this->data['province'] = $province;
        return $this;
    }
    
    public function getProvince()
    {
        return $this->data['province'];
    }
    
    public function setZipCode($zip_code)
    {
        $this->data['zip_code'] = $zip_code;
        return $this;
    }
    
    public function getZipCode()
    {
        return $this->data['zip_code'];
    }
    
    public function setPhone($phone)
    {
        $this->data['phone'] = $phone;
        return $this;
    }
    
    public function getPhone()
    {
        return $this->data['phone'];
    }
    
    public function setBio($bio)
    {
        $this->data['bio'] = $bio;
        return $this;
    }
    
    public function getBio()
    {
        return $this->data['bio'];
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