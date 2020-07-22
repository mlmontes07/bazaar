<?php
namespace Application\Library;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Log\Logger;
use Laminas\Db\Sql\Sql;

class Session
{
    protected $adapter;
    protected $logger;
    protected $config;
    protected $container;

    public function __construct(AdapterInterface $adapter, Logger $logger, array $config, object $sessionContainer)
    {
        $this->adapter = $adapter;
        $this->logger = $logger;
        $this->config = $config;
        $this->sqlObj = new Sql($adapter);
        $this->container = $sessionContainer;
    }

    public function getConfigVariable($variable_name)
    {
        return $this->config[$variable_name] ?? null;
    }

    public function setIdentityId($identity_id)
    {
        $this->container->offsetSet('identityId-' . session_id(), $identity_id);
        return true;
    }

    public function getIdentityId()
    {
        if ($this->container->offsetExists('identityId-' . session_id())) {
            return $this->container->offsetGet('identityId-' . session_id());
        }
        return false;
    }
    
    public function setCSRFToken($token)
    {
        $this->container->offsetSet('csrfToken-' . session_id(), $token);
        $this->logger->info('saved csrf token', array(
            'token' => $token
        ));
        return true;
    }
    
    public function getCSRFToken()
    {
        if ($this->container->offsetExists('csrfToken-' . session_id()))
            return $this->container->offsetGet('csrfToken-' . session_id());
            
        return false;
    }
    
    public function setUserPasswordHash($hash)
    {
        $this->container->offsetSet('passwordHash-' . session_id(), $hash);
        return true;
    }
    
    public function getUserPasswordHash()
    {
        if ($this->container->offsetExists('passwordHash-' . session_id()))
            return $this->container->offsetGet('passwordHash-' . session_id());
            
        return null;
    }
    
    public function setUserLevel($user_level)
    {
        $this->container->offsetSet('userLevel-' . session_id(), $user_level);
        return true;
    }
    
    public function getUserLevel()
    {
        if ($this->container->offsetExists('userLevel-' . session_id()))
            return $this->container->offsetGet('userLevel-' . session_id());
            
        return 0;
    }
    
    public function setAclList($list)
    {
        $this->container->offsetSet('aclList-' . session_id(), $list);
        return true;
    }
    
    public function getAclList()
    {
        if ($this->container->offsetExists('aclList-' . session_id()))
            return $this->container->offsetGet('aclList-' . session_id());
            
        return $this->container;
    }
    
    public function setAccess($access)
    {
        $this->container->offsetSet('access-' . session_id(), $access);
        return true;
    }
    
    public function getAccess()
    {
        if ($this->container->offsetExists('access-' . session_id()))
            return $this->container->offsetGet('access-' . session_id());
            
        return $this->container;
    }
    
    public function setSessionItem($name, $value)
    {
        $this->container->offsetSet($name . '-' . session_id(), $value);
        return true;
    }
    
    public function getSessionItem($name, $default = false)
    {
        if ($this->container->offsetExists($name . '-' . session_id()))
            return $this->container->offsetGet($name . '-' . session_id());
            
        return $default;
    }
    
    public function setLastLogin($last_login)
    {
        $this->container->offsetSet('lastLogin-' . session_id(), $last_login);
        return true;
    }
    
    public function getLastLogin()
    {
        if ($this->container->offsetExists('lastLogin-' . session_id()))
            return $this->container->offsetGet('lastLogin-' . session_id());
            
        return false;
    }

    public function findIP()
    {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';

        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }

    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function runInBackground($cmd)
    {
        if (substr(php_uname(), 0, 7) == "Windows") {
            $this->logger->info('Calling Background Process in Windows Machine (maybe)');
            $return = pclose(popen("start /B " . $cmd, "r"));
            $this->logger->info('Process Running in the Background...' . $return);
        } else {
            $this->logger->info('Calling Background Process in Linux Machine (maybe)');
            $result = shell_exec($cmd . " >/dev/null 2>&1 &");
            $this->logger->info('Shell Process Running in the Background...' . $result);
        }
    }

    public function curlWrap($url, $method, $params)
    {
        $ch = curl_init();
        $params = http_build_query($params);

        switch ($method) {
            case 'GET':
                if (! empty($params)) {
                    $url .= '?' . $params;
                }
                break;
            case 'UPLOAD':
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $params
                ]);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                break;
            case 'PUT':
            case 'POST':
                if ($method === 'POST') {
                    curl_setopt($ch, CURLOPT_POST, true);
                } else {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                }
                if ($params) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                }

                $headers = [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Content-Length:' . strlen($params)
                ];

                break;
        }
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $i = 0;
        while ($i < 5) {
            $data = curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = $this->parseHeaders(substr($data, 0, $header_size));
            if ($status === 400) {
                $i ++;
                sleep(10);
            } else {
                break;
            }
        }

        $body = substr($data, $header_size);

        $errorInfo = curl_error($ch);
        $error = curl_errno($ch);
        curl_close($ch);
        
        $this->logger->debug('curl wrapper error',[
            $error,
            $errorInfo
        ]);

        if (! empty($headers['id']))
            return (int) $headers['id'];
        else
            return $body;
    }

    public function parseHeaders($stringHeaders)
    {
        $headers = [];
        $stringHeaders = trim($stringHeaders);
        if ($stringHeaders) {
            $parts = explode("\n", $stringHeaders);
            foreach ($parts as $header) {
                $header = trim($header);
                if ($header && false !== strpos($header, ':')) {
                    list ($name, $value) = explode(':', $header, 2);
                    $value = trim($value);
                    $name = trim($name);
                    if (isset($headers[$name])) {
                        if (is_array($headers[$name])) {
                            $headers[$name][] = $value;
                        } else {
                            $_val = $headers[$name];
                            $headers[$name] = [
                                $_val,
                                $value
                            ];
                        }
                    } else {
                        $headers[$name] = $value;
                    }
                }
            }
        }
        return $headers;
    }
}