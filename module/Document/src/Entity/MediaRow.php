<?php
namespace Document\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class MediaRow extends AbstractRowGateway
{
    protected $id;
    protected $filename;
    protected $mime_type;
    protected $size;
    protected $width;
    protected $height;
    protected $path;
    protected $type;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'media';
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
    
    public function setInformation($information)
    {
        $this->data['information'] = $information;
        return $this;
    }
    
    public function getInformation()
    {
        return $this->data['information'];
    }
    
    public function setMerchantType($merchant_type)
    {
        $this->data['merchant_type'] = $merchant_type;
        return $this;
    }
    
    public function getMerchantType()
    {
        return $this->data['merchant_type'];
    }
    
    public function setAddress($address)
    {
        $this->data['address'] = $address;
        return $this;
    }
    
    public function getAddress()
    {
        return $this->data['address'];
    }
    
    public function setBarangay($barangay)
    {
        $this->data['barangay'] = $barangay;
        return $this;
    }
    
    public function getBarangay()
    {
        return $this->data['barangay'];
    }
    
    public function setCityMuicipality($city_municipality)
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
    
    public function setCountry($country)
    {
        $this->data['country'] = $country;
        return $this;
    }
    
    public function getCountry()
    {
        return $this->data['country'];
    }
    
    public function setLatitude($latitude)
    {
        $this->data['latitude'] = $latitude;
        return $this;
    }
    
    public function getLatitude()
    {
        return $this->data['latitude'];
    }
    
    public function setLongitude($longitude)
    {
        $this->data['longitude'] = $longitude;
        return $this;
    }
    
    public function getLongitude()
    {
        return $this->data['longitude'];
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
    
    public function setMobile($mobile)
    {
        $this->data['mobile'] = $mobile;
        return $this;
    }
    
    public function getMobile()
    {
        return $this->data['mobile'];
    }
    
    public function setAvailableForDelivery($available_for_delivery)
    {
        $this->data['available_for_delivery'] = $available_for_delivery;
        return $this;
    }
    
    public function getAvailableForDelivery()
    {
        return $this->data['available_for_delivery'];
    }
    
    public function setDaysOpen($days_open)
    {
        $this->data['days_open'] = $days_open;
        return $this;
    }
    
    public function getDaysOpen()
    {
        return $this->data['days_open'];
    }
    
    public function setHoursStart($hours_start)
    {
        $this->data['hours_start'] = $hours_start;
        return $this;
    }
    
    public function getHoursStart()
    {
        return $this->data['hours_start'];
    }
    
    public function setHoursEnd($hours_end)
    {
        $this->data['hours_end'] = $hours_end;
        return $this;
    }
    
    public function getHoursEnd()
    {
        return $this->data['hours_end'];
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
    
    public function setDeliveryRange($delivery_range)
    {
        $this->data['delivery_range'] = $delivery_range;
        return $this;
    }
    
    public function getDeliveryRange()
    {
        return $this->data['delivery_range'];
    }
    
    public function setMerchantCategoryId($merchant_category_id)
    {
        $this->data['merchant_category_id'] = $merchant_category_id;
        return $this;
    }
    
    public function getMerchantCategoryId()
    {
        return $this->data['merchant_category_id'];
    }
    
    public function setMerchantAccountId($merchant_account_id)
    {
        $this->data['merchant_account_id'] = $merchant_account_id;
        return $this;
    }
    
    public function getMerchantAccountId()
    {
        return $this->data['merchant_account_id'];
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