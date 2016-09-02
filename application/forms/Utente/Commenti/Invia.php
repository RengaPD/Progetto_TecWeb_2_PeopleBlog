<?php
class Application_Form_Utente_Commenti_Invia extends Zend_Form
{
    protected $_blogModel;

    public function init()
    {
        $this->_blogModel=new Application_Model_Blog();
        $this->setMethod('post');
        $this->setName('commenta');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');


        $this->addElement('textarea', 'commento', array(
            'label' => 'Il tuo commento:',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));

        $this->addElement('submit', 'add', array(
            'label' => 'Invia!',
        ));
    }
}
?>