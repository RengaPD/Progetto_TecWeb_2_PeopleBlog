<?php

class Application_Model_Admin extends App_Model_Abstract
{

    public function __construct()
    {

    }

    public function inserisciUtente($info)
    {
        return $this->getResource('Utenti')->insertUtenti($info);
    }

    public function modificaUtente($info,$id)
    {
        return $this->getResource('Utenti')->editUtenti($info,$id);
    }

    public function eliminaUtente($id)
    {
        return $this->getResource('Utenti')->deleteUtenti($id);
    }

    public function visualizzaUtente()
    {
        return $this->getResource('Utenti')->showUtenti();
    }

    public function trovaEmailUtente($info)
    {
        return $this->getResource('Utenti')->findUserEmail($info);
    }
}