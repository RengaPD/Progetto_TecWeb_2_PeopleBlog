<?php

class Application_Form_Public_Cerca extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('search');
        $this->setAction('');

        $this->addElement('text', 'Nome', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required' => true,
            'label' => 'Nome',
        ));

        $this->addElement('text', 'Cognome', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required' => true,
            'label' => 'Cognome',
        ));

        $this->addElement('submit', 'Cerca utente', array(
            'label' => 'Cerca!',
        ));
    }
}
