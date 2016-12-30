<?php
class Application_Form_Utente_Blog_Posta extends App_Form_Abstract
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
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('textarea', 'content', array(
            'label' => 'Il tuo post',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('submit', 'add', array(
            'label' => 'Invia!',
            'decorators'=>$this->buttonDecorators,
        ));
    }
}
?>