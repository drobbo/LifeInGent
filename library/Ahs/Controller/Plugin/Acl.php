<?php

/**
 * Description of Acl
 *  ACL = Access controll list.
 * @author Robbe
 */
class Ahs_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
    //put your code here
    
    protected $_acl;
    
    public function __construct() {
        $session = new Zend_Session_Namespace('acl');
        
        if(isset($session->acl)){
            
            $this->_acl = $session->acl;
            
        }
        else{
            
            $acl = new Ahs_Acl();
            
            $this->_acl = $acl;
            $session->acl = $this->_acl = $acl;
        }
    }
    
    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        
        parent::preDispatch($request);
        
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity()){
            $role = $auth->getStorage()->read()['role'];
            
        }
        else{
            $role = Ahs_Roles::ROLE_GUEST;
        }
        //$role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : Ahs_Acl::ROLE_GUEST;
                
        $resource = Ahs_Acl::getResource($request->getControllerName(),
                                         $request->getModuleName());
        
        $privilege = Ahs_Acl::getPrivilege($request->getActionName());
        
        if($this->_acl->isAllowed($role,$resource,$privilege)){
            return true;
        }
        throw new Zend_Exception("access violation for Role '{$role}':no access to resourc '{$resource}' for privilege '{$privilege}'");
        
    }
}

?>
