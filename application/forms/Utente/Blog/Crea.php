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



        $this->addElement('text', 'titolo', array(
            'label' => 'Titolo del Blog',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        $this->titolo->setAttrib('class','input_text');

        $this->addElement('textarea', 'post', array(
            'label' => 'Descrizione',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));
        $this->post->setAttrib('class','message');
        $this->addElement('submit', 'add', array('label' => 'Crea il tuo blog!',
        ));
        $this->add->setAttrib('class','button');

    }
}
?>