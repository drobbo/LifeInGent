<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initLocale(){
        try{
            $session = new Zend_Session_Namespace('nmdadIII_language');
            if(isset($session->lang)){
                $locale = new Zend_Locale($session->Lang);
            }
            else{
                $locale = new Zend_Locale();
            }
        }
        catch (Zend_Locale_Exception $e){
            $locale = new Zend_Locale('en');
            
        }
        Zend_Registry::set('Zend_Locale',$locale);
        
    }
    
    public function _initTranslate(){
        $translate = new Zend_Translate(
                array(
                    // 'adapter'=>'array',
                    'adapter'=>'Xliff',
                    'content'=>APPLICATION_PATH.'/languages',
                    'locale'=> Zend_Registry::get('Zend_Locale')->getLanguage(),
                    'scan'=> Zend_Translate::LOCALE_DIRECTORY,
                ));
        Zend_Registry::set('Zend_Translate', $translate);
    }
    
    public function _initValidate(){
        try{
            $translate = new Zend_Translate(
                    array(
                        'adapter'=>'array',
                        'content'=>APPLICATION_PATH.'/../../../ZendFramework-1.12.0/resources/languages',
                        'locale'=> 'auto',
                        'scan'=> Zend_Translate::LOCALE_DIRECTORY,
                    ));
            Zend_Validate_Abstract::setDefaultTranslator($translate);
        }
        catch(Zend_Translate_Exception $e){
            //do nothing
        }
    }
    
    public function _initViewHelpers()
    {
        $this->bootstrap('layout'); // Make a _initLayout()
        $view = $this->getResource('layout')->getView();

        // To make $view->baseUrl() available in this bootstrap
        $front = $this->getResource('frontController');
        $front->setRequest(new Zend_Controller_Request_Http());

        $view->doctype('HTML5'); // http://framework.zend.com/manual/en/zend.view.helpers.html#zend.view.helpers.initial.doctype
        $view->headMeta()
             ->setCharset('utf-8')
             ->appendName('viewport', 'width=device-width, initial-scale=1')
        ;

        $view->headTitle($view->title, 'PREPEND') // Zend_View_Helper_HeadTitle
             ->setDefaultAttachOrder('PREPEND')
             ->setSeparator(' ← ')
        ;

        $view->headLink() // Zend_View_Helper_HeadLink
             ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap.min.css'))
             ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap-responsive.min.css'))
             ->appendStylesheet($view->baseUrl("_styles/main.css"))
        ;

        $view->inlineScript()
             ->appendFile('http://code.jquery.com/jquery-latest.js')
             ->appendFile($view->baseUrl('bootstrap-2.1.1/js/bootstrap.min.js'))
                
        ;
    }
    
    protected function _initViewHelperNavigation(){
        $yaml = APPLICATION_PATH.'/configs/navigation.yml';
        $pages = new Zend_Config_Yaml($yaml);
        $navigation = new Zend_Navigation($pages);
        
        $this->bootstrap('layout'); // Make a _initLayout()
        $view = $this->getResource('layout')->getView();
        $view->navigation($navigation)->setAcl(new Ahs_Acl())
                ->setRole(Ahs_Roles::ROLE_GUEST);
        
        
        
        $view->navigation()->breadcrumbs()
                            ->setSeparator(' / ')
                            ->setPartial('partials/breadcrumbs.phtml')
                            ;

        
    }
}