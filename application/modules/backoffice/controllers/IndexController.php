<?php

class Backoffice_IndexController extends Zend_Controller_Action
{
    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $this->view->loggedIn = $this->_auth->hasIdentity() && $this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN ? true : false;
        $translate = Zend_Registry::get('Zend_Translate');
        $myService = new Ahs_LifeInGentService();
        $arr = $myService->getAllHospitals();
        $this->view->data = $arr;
        
        if(!$this->_auth->hasIdentity()){
            $return = $this->redirect("backoffice/index/login");
        }
        else {
            $return = null;
        }
        return $return;
    }

    public function loginAction()
    {
        $this->view->loggedIn = $loggedIn = $this->_auth->hasIdentity() && $this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN ? true : false;
        if($loggedIn){
            $this->redirect("backoffice");
        }
        
        $form = new Backoffice_Form_Login();
        $translate = Zend_Registry::get('Zend_Translate');
        
        $view = $this->view;
        $view->title = $translate->_('Login'). '- Backoffice';

        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $admin = new Backoffice_Model_Admin($values);

                $adapter = new Ahs_Auth_Adapter_Admin($admin->getUsername(),
                                                      $admin->getPassword());

                $this->_auth->authenticate($adapter);

                if ($this->_auth->hasIdentity() ) {
                    $admin_data = $adapter->getResultRowObject();

                    $this->_auth->getStorage()->write(array('role' => Ahs_Roles::ROLE_ADMIN,
                                                            'id'   => (int) $admin_data->adm_id,
                                              ));
                    return $this->redirect('backoffice/index/');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice');
                }
            }
        }
        $view->form = $form;
        
    }

    public function logoutAction()
    {
        $this->_auth->clearIdentity();

        return $this->redirect('backoffice');
        
    }
    public function editAction(){
        $this->view->loggedIn = $loggedIn = $this->_auth->hasIdentity() && $this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN ? true : false;
        $translate = Zend_Registry::get('Zend_Translate');
        $this->view->title = $translate->_('Edit Profile'). '- Backoffice';
        if($loggedIn){
            $form = new Backoffice_Form_Register();
            $request = $this->getRequest();
            if ($request->isPost() ) {
                if ($form->isValid( $request->getPost() )) {
                    $values = $form->getValues();

                    $admin = new Backoffice_Model_Admin($values);
                    $myService = new Ahs_LifeInGentService();
                    if($myService->updateAdminData($admin,$this->_auth->getStorage()->read()["id"])){
                        print_r("info updated");
                    }
                    else{
                        print_r("updating failed");
                    }
                }
            }
            else{
                
            }
            
            $id = $this->_auth->getStorage()->read()["id"];
            $myService = new Ahs_LifeInGentService();
            $arr = $myService->getAdminData($id);
            $form = new Backoffice_Form_Register();
            $form->populate($arr);
            $this->_helper->viewRenderer('main');
            $this->view->form = $form;
            
            $this->view->data = $arr;
            
        }
        else{
            $this->redirect("backoffice/index/login");
        }
    }
    
    public function updateallAction(){
        $this->view->loggedIn = $loggedIn  = $this->_auth->hasIdentity() && $this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN ? true : false;
        $translate = Zend_Registry::get('Zend_Translate');
        $this->view->title = 'Update - Backoffice';
        $this->_helper->viewRenderer('main');
        if($loggedIn){
            
            $myService = new Ahs_LifeInGentService();
            $myService->updatePOI();
            print_r($myService->getPOI());
            //$myService->updatePrimarySchools();
            
        }
        else{
            $this->redirect("backoffice");
        }
    }
}