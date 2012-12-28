<?php

class Backoffice_AdminController extends Zend_Controller_Action
{

    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        Zend_Debug::dump($this->_auth->hasIdentity());
        Zend_Debug::dump($this->_auth->getIdentity());
        if(!$this->_auth->hasIdentity()){
            $return = $this->redirect("backoffice/admin/login");
        }
        else {
            $return = null;
        }
        return $return;
    }

    public function loginAction()
    {
        if($this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN){
            $this->redirect("backoffice/admin");
        }
        else{
            
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
        if($this->_auth->getStorage()->read()['role'] == Ahs_Roles::ROLE_ADMIN){
            
        }
        else{
            $this->redirect("backoffice/admin/login");
        }
    }
}