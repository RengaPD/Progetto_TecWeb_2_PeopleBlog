<?php
class Application_Form_Utente_Commenti_Invia extends App_Form_Abstract
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
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,20000))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('submit', 'add', array(
            'label' => 'Invia!',
            'decorators'=>$this->buttonDecorators,
        ));
    }
}
?>