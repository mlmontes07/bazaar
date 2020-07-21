<?php
namespace User\Entity;

use Laminas\Db\RowGateway\AbstractRowGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class UserRow extends AbstractRowGateway
{
    protected $id;
    protected $full_name;
    protected $email; # email or phone number
    protected $password;
    protected $user_level;
    protected $role_id;
    protected $email_token;
    protected $device_token;
    protected $api_token;
    protected $remember_me_token;
    protected $last_login;
    protected $user_detail_id;
    protected $updated_by;
    protected $deleted;
    protected $adapter = null;
    protected $sql = null;
    protected $table = 'user';
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
    
    public function setFullName($full_name)
    {
        $this->data['full_name'] = $full_name;
        return $this;
    }
    
    public function getFullName()
    {
        return $this->data['full_name'];
    }
    
    public function setEmail($email)
    {
        $this->data['email'] = $email;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->data['email'];
    }
    
    public function setPassword($password)
    {
        $this->data['password'] = $password;
        return $this;
    }
    
    public function getPassword()
    {
        return $this->data['password'];
    }
    
    public function setUserLevel($user_level)
    {
        $this->data['user_level'] = $user_level;
        return $this;
    }
    
    public function getUserLevel()
    {
        return $this->data['user_level'];
    }
    
    public function setRoleId($role_id)
    {
        $this->data['role_id'] = $role_id;
        return $this;
    }
    
    public function getRoleId()
    {
        return $this->data['role_id'];
    }
    
    public function setEmailToken($email_token)
    {
        $this->data['email_token'] = $email_token;
        return $this;
    }
    
    public function getEmailToken()
    {
        return $this->data['email_token'];
    }
    
    public function setDeviceToken($device_token)
    {
        $this->data['device_token'] = $device_token;
        return $this;
    }
    
    public function getDeviceToken()
    {
        return $this->data['device_token'];
    }
    
    public function setApiToken($api_token)
    {
        $this->data['api_token'] = $api_token;
        return $this;
    }
    
    public function getApiToken()
    {
        return $this->data['api_token'];
    }
    
    public function setRememberMeToken($remember_me_token)
    {
        $this->data['remember_me_token'] = $remember_me_token;
        return $this;
    }
    
    public function getRememberMeToken()
    {
        return $this->data['remember_me_token'];
    }
    
    public function setLastLogin($last_login)
    {
        $this->data['last_login'] = $last_login;
        return $this;
    }
    
    public function getLastLogin()
    {
        return $this->data['last_login'];
    }
    
    public function setUserDetailId($user_detail_id)
    {
        $this->data['user_detail_id'] = $user_detail_id;
        return $this;
    }
    
    public function getUserDetailId()
    {
        return $this->data['user_detail_id'];
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