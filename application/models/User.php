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

    public function mostraamici($id_user)
    {
        return $this->getResource('Amici')->showmyfriends($id_user);
    }
    
    public function aggiungiamico($id_user)
    {
        return $this->getResource('Amici')->addfriend($id_user);
    }
    public function rimuoviamco($id_user)
    {
        return $this->getResource('Amici')->remfriend($id_user);
    }
    public function accettarichiesta($id_request)
    {
        return $this->getResource('Amici')->acceptfriend($id_request);
    }
    public function rifiutarichiesta($id_request)
    {
        return $this->getResource('Amici')->refusefriend($id_request);
    }
}