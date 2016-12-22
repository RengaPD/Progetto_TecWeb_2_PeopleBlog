<?php

class Application_Form_Public_Auth_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$this->addElement('text', 'username', array(
            'label' => 'Username',
            'filters' => array('StringTrim','StringToLower'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
        ));
		
		$this->addElement('password', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
        ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
        ));
    }
}
?>