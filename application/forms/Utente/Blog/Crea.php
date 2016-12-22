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

        $this->addElement('text', 'nomeblog', array(
            'label' => 'Nome blog',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
        ));

        $this->addElement('text', 'titolo', array(
            'label' => 'Titolo primo post',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
        ));

        $this->addElement('textarea', 'post', array(
            'label' => 'Primo post',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
        ));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Crea il tuo blog!',
        ));
    }
}
?>