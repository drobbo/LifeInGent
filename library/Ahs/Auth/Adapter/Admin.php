<?php

class Ahs_Auth_Adapter_Admin extends Zend_Auth_Adapter_DbTable
{
    public function __construct($username, $password)
    {
        parent::__construct();
        $this->setTableName('Admins')
             ->setIdentityColumn(  'adm_username')
             ->setCredentialColumn('adm_password')
             ->setIdentity(  $username)
             ->setCredential($password)
        ;
//        Zend_Debug::dump($this); exit;
    }
}