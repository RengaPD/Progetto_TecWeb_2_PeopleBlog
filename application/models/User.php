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
    
    public function cercamail($info)
    {
        return $this->getResource('Utenti')->findUserEmail($info);
    }

}