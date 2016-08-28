<?php
class Application_Form_Amministrazione_Utente_Modifica extends Zend_Form
{
    protected $_adminModel;

    public function init()
    {
        $this->_adminModel=new Application_Model_Admin();
        $this->setMethod('post');
        $this->setName('modificautente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden', 'id');

        $this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        $this->addElement('text', 'Cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'eta', array(
            'label' => 'Età',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        $this->addElement('select', 'ruolo', array(
            'label' => 'Ruolo:',
            'multiOptions' => array('utente'=>'Utente',
                'staff'=> 'Staff',
                'admin'=>'Admin'),
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('textarea', 'interessi', array(
            'label' => 'Interessi',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));

        $this->addElement('textarea', 'amici', array(
            'label' => 'Amici',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));

        $this->addElement('submit', 'add', array(
            'label' => 'Modifica',
        ));
    }
}