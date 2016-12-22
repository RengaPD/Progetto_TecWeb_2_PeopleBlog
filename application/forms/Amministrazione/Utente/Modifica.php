<?php
class Application_Form_Amministrazione_Utente_Modifica extends Zend_Form
{
    protected $_adminModel;

    public function init()
    {
        $this->_adminModel=new Application_Model_Admin();
        $this->setMethod('post');
        $this->setName('modificautente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden', 'id');

        $this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'Cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'username', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
        ));

        $this->addElement('text', 'eta', array(
            'label' => 'Età',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('Int',true,array('locale'=>'it',
                    'messages'=>array('notInt'=>"Il valore inserito non è un intero"))),
                array('Between',true,array('min'=>18,
                    'max'=>120,
                    'messages'=>array('notBetween'=>"Hai inserito un'età non ammessa"))),
            )));

        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('EmailAddress',true,array('messages'=>array(
                    'emailAddressInvalid'=>'Il valore inserito non è una stringa',
                    'emailAddressInvalidFormat'=>"'%value%' non è un formato email accettabile"
                )))),
        ));

        $this->addElement('text', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
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

        $this->addElement('textarea', 'interessi', array(
            'label' => 'Interessi',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,10000))),
        ));

        $this->addElement('hidden', 'public');

        $this->addElement('submit', 'add', array(
            'label' => 'Modifica',
        ));
    }
}