<?php

class Application_Model_User extends App_Model_Abstract
{


    public function __construct()
    {

    }

    public function modificaProfilo($info,$id)
    {
        return $this->getResource('Utenti')->editUtenti($info,$id);
    }
    
    public function creaBlog($dati)
    {
       //da rivedere, come si possono gestire i blog??
        //unica tabella blog. righe sono i post identificate da nome e cognome.
        //accedendo a blog si selezionano solo post di quell'utente
    }
}