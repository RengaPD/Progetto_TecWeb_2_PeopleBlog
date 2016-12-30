<?php
class Application_Form_Utente_Profilo_CambiaImg extends App_Form_Abstract
{
    protected $_publicModel;

    public function init()
    {
        $this->_publicModel=new Application_Model_Public();
        $this->setMethod('post');
        $this->setName('cambiaimmagine');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('file', 'immagine', array(
            'label' => 'Scegli immagine del profilo',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,50))),
            'decorators'=>$this->fileDecorators,
        ));
        $this->immagine->setDestination(PUBLIC_PATH.'/images/profiles/');
        
        $this->addElement('submit', 'add', array(
            'label' => 'Aggiorna profilo',
            'decorators'=>$this->buttonDecorators,
        ));
    }
}
?>