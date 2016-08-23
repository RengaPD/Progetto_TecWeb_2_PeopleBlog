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
       $this->getResource('Blog')->creaBlog($dati);
       $this->getResource('Utenti')->setBlogtrue(); 
    }
    
    public function cercaUtente($info)
    {
        return $this->getResource('Utenti')->search($info);
    }
}