<?php

class Backoffice_Form_Login extends Zend_Form
{
    public function init()
    {
        

        $text_username = new Zend_Form_Element_Text('username');

        if ($text_username->hasErrors()) die('ok');

        $text_username->setRequired()
                      ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                      ->addValidator('NotEmpty', true)
                      ->setAttrib("class", "input-block-level")
                      ->setAttrib("placeholder", "Username")
        ;

        $password_raw = new Zend_Form_Element_Password('passwordraw');
        $password_raw->setRequired()
                     ->addValidator('NotEmpty', true)
                     ->setAttrib("class", "input-block-level")
                      ->setAttrib("placeholder", "Password")
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
               ->setOptions(array('class' => 'btn btn-large btn-block btn-primary'))
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

        

        $this->setAttrib('class','form-signin')
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_username)
             ->addElement($password_raw )
             ->addElement($submit       )
        ;
    }

    public function isValid($data)
    {
        $valid = parent::isValid($data);

        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {

                $decorator = $element->getDecorator('outer');

                $options = $decorator->getOptions();
                $options['class'] .= ' error';

                $decorator->setOptions($options);
            }
        }

        return $valid;
    }
}