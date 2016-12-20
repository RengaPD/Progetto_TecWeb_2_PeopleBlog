<?php

class Application_Form_Public_Auth_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim','StringToLower'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
		
		$this->addElement('password', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
        ));
    }
}
?>