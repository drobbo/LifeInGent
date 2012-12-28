<?php



class Ahs_Acl extends Zend_Acl
{   
    public function __construct() 
    {
        
        $this->addRole(new Zend_Acl_Role(Ahs_Roles::ROLE_GUEST))
            ->addRole(new Zend_Acl_Role(Ahs_Roles::ROLE_ADMIN),Ahs_Roles::ROLE_GUEST)
            
            ->addResource(new Zend_Acl_Resource(self::getResource('index')))
            ->addResource(new Zend_Acl_Resource(self::getResource('error')))
                
            ->allow(Ahs_Roles::ROLE_GUEST,  
                    self::getResource('index'))
            ->allow(Ahs_Roles::ROLE_GUEST,  
                    self::getResource('error'))
            
            
            //admin pages
            ->addResource(new Zend_Acl_Resource(self::getResource('admin','backoffice')))
            ->deny(Ahs_Roles::ROLE_GUEST, self::getResource('admin','backoffice'))
            ->allow(Ahs_Roles::ROLE_ADMIN,  
                    self::getResource('admin','backoffice'))
            ;   
    }
    
    /*
     * 
     * @param string $controller Controller name.
     * 
     * 
     */
    
    public static function getResource($controller = 'index',$module = 'default')
    {
        
        
        //ucfirst -> begin with uppercase;
        $class_name = ucfirst($controller).'Controller';
        //Zend_Debug::dump($class_name);exit;
        
        if($module != 'default'){
            $class_name = ucfirst($module)."_".$class_name;
        }
        
        return $class_name;
        
    }
    
    public static function getPrivilege($action = 'index'){
        
        $method_name = lcfirst($action).'Action';
        
        return $method_name;
        
        
    }
}

?>
