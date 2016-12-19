<?php
class Application_Form_Amministrazione_Utente_Aggiungi extends Zend_Form
{
    protected $_adminModel;

    public function init()
    {
        $this->_adminModel=new Application_Model_Admin();
        $this->setMethod('post');
        $this->setName('aggiungiutente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden','id');

        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        
        $this->addElement('text', 'email', array(
            'label' => 'email',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
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

        $this->addElement('hidden','interessi');

        $this->addElement('hidden','blog');
        $this->blog->setValue(0);
        

        $this->addElement('submit', 'add', array(
            'label' => 'Aggiungi Utente',
        ));
    }
}
?>