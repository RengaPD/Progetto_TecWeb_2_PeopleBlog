<?php
class Application_Form_Amministrazione_Utente_Aggiungi extends App_Form_Abstract
{
    protected $_adminModel;

    public function init()
    {
        $this->_adminModel=new Application_Model_Admin();
        $this->setMethod('post');
        $this->setName('aggiungiutente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('hidden','id');

        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('text', 'cognome', array(
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
            'label' => 'Cognome',
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            ))),
                array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

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

        $this->addElement('text', 'password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('NotEmpty',true,array('messages'=>array(
                'isEmpty'=>'Il campo è obbligatorio e non può essere vuoto'
            )))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('select', 'ruolo', array(
            'label' => 'Ruolo:',
            'multiOptions' => array('utente'=>'Utente',
                'staff'=> 'Staff',
                'admin'=>'Admin'),
            'filters' => array('StringTrim'),
            'required' => false,
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators'=>$this->elementDecorators,
        ));

        $this->addElement('hidden','interessi');
        $this->interessi->setValue('Inserisci qui interessi');

        $this->addElement('hidden','public');
        $this->blog->setValue(0);
        

        $this->addElement('submit', 'add', array(
            'label' => 'Aggiungi Utente',
            'decorators'=>$this->buttonDecorators,
        ));
    }
}
?>