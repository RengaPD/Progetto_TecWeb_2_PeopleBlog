<?php
class Application_Form_Utente_Blog_Posta extends Zend_Form
{
    protected $_blogModel;

    public function init()
    {
        $this->_blogModel=new Application_Model_Blog();
        $this->setMethod('post');
        $this->setName('posta');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');


        $this->addElement('text', 'title', array(
            'label' => 'Titolo del tuo post',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,200))),
        ));

        $this->addElement('textarea', 'content', array(
            'label' => 'Il tuo post',
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