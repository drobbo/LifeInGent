<?php

class Backoffice_Form_Register extends Zend_Form
{
    public function init()
    {

        $text_givenname = new Zend_Form_Element_Text('givenname');
        $text_givenname->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                       ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
                       ->setAttrib("class", "input-block-level")
                       ->setAttrib("placeholder", "Given name")
        ;

        $text_familyname = new Zend_Form_Element_Text('familyname');
        $text_familyname->addFilter('StringTrim')                               // Zend/Filter/StringTrim.php
                        ->addValidator('NotEmpty', true)                        // Zend/Validate/NotEmpty.php
                        ->setAttrib("class", "input-block-level")
                        ->setAttrib("placeholder", "Family name")
        ;

        $text_email = new Zend_Form_Element_Text('email');
        $text_email->addFilter('StringTrim')                                    // Zend/Filter/StringTrim.php
                   ->addValidator('EmailAddress', true)                         // Zend/Validate/EmailAddress.php
                   ->addValidator('NotEmpty', true)                             // Zend/Validate/NotEmpty.php
                   ->setAttrib("class", "input-block-level")
                   ->setAttrib("placeholder", "email")
        ;

        $text_username = new Zend_Form_Element_Text('username');
        $text_username->setRequired()
                      ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                      ->addValidator('NotEmpty', true)                          // Zend/Validate/NotEmpty.php
                      ->setAttrib("class", "input-block-level")
                      ->setAttrib("placeholder", "Username")
        ;

        $password_raw = new Zend_Form_Element_Password('passwordraw');
        $password_raw->setRequired()
                     ->addValidator('NotEmpty', true)                           // Zend/Validate/NotEmpty.php
                     ->setAttrib("class", "input-block-level")
                     ->setAttrib("placeholder", "Password")
        ;

        $password_repeat = new Zend_Form_Element_Password('passwordrepeat');
        $password_repeat->setRequired()
                        ->addValidator('NotEmpty', true)                        // Zend/Validate/NotEmpty.php
                        ->setAttrib("class", "input-block-level")
                        ->setAttrib("placeholder", "Repeat Password")
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit')
               ->setOptions(array('class' => 'btn btn-large btn-block btn-primary'))
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setAttrib('class','form-signin')
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_givenname )
             ->addElement($text_familyname)
             ->addElement($text_email     )
             ->addElement($text_username  )
             ->addElement($password_raw   )
             ->addElement($password_repeat)
             ->addElement($submit         )
        ;
    }
}