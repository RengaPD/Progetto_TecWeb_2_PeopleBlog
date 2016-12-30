<?php
class Application_Form_Public_Registra extends App_Form_Abstract
{
    protected $_publicModel;

    public function init()
    {
        $this->_publicModel=new Application_Model_Public();
        $this->setMethod('post');
        $this->setName('registrati');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden','id');
        
        $this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                    'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
                ))),
                array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('text', 'Cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('hidden','immagine');
        $this->immagine->setValue('nobody.jpg');
        
        $this->addElement('text', 'eta', array(
            'label' => 'Età',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('Int',true,array('locale'=>'it',
                    'messages'=>array('notInt'=>"Il valore inserito non è un intero"))),
                array('Between',true,array('min'=>18,
                    'max'=>120,
                    'messages'=>array('notBetween'=>"Hai inserito un'età non ammessa"))),

        ),
            'decorators'=>$this->elementDecorators,));

        $this->addElement('text', 'email', array(
            'label' => 'email',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('EmailAddress',true,array('messages'=>array(
                    'emailAddressInvalid'=>'Il valore inserito non è una stringa',
                    'emailAddressInvalidFormat'=>"'%value%' non è un formato email accettabile"
                )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('password', 'passwordripeti', array(
            'label' => 'Ripeti password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('Identical',true,array('token'=>'password',
                    'messages'=>array(
                    'notSame'=>'Le due password non coincidono'
                )))),
            'decorators'=>$this->elementDecorators,
        ));



        $this->addElement('hidden','ruolo');
        $this->ruolo->setValue('utente');

        $this->addElement('textarea', 'interessi', array(
            'label' => 'Interessi',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('hidden','public');
        $this->public->setValue(0);


        $this->addElement('submit', 'add', array(
            'label' => 'Registrati',
            'decorators'=>$this->buttonDecorators,
        ));
    }
}
?>