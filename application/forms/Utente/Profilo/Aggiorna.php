<?php
class Application_Form_Utente_Profilo_Aggiorna extends Zend_Form
{
    protected $_publicModel;

    public function init()
    {
        $this->_publicModel=new Application_Model_Public();
        $this->setMethod('post');
        $this->setName('aggiornaprofilo');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden','id');

        $this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        $this->addElement('text', 'Cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'eta', array(
            'label' => 'Età',
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

        $this->addElement('hidden','ruolo');

        $this->addElement('textarea', 'interessi', array(
            'label' => 'Interessi',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));

        $this->addElement('hidden','blog');

        $this->addElement('submit', 'add', array(
            'label' => 'Aggiorna profilo',
        ));
    }
}
?>