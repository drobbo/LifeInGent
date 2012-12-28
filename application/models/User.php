<?php

class Application_Model_User
{
    protected $_username;

    protected $_password;


    public function __construct(array $values) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setPasswordraw($password)
    {
        $this->_password = Ahs_Utility::hash($password);
    }
}