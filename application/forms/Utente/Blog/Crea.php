<?php
class Application_Form_Utente_Blog_Crea extends Zend_Form
{
    protected $_userModel;

    public function init()
    {
        $this->_userModel=new Application_Model_User();
        $this->setMethod('post');
        $this->setName('creablog');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Crea il tuo blog!',
        ));
    }
}
?>