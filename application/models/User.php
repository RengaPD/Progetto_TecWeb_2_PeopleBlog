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
    public function cercautente($info)
    {
        return $this->getResource('Utenti')->searchUtenti($info);
    }
    public function mostrautente($id)
    {
        return $this->getResource('Utenti')->showUtentedaID($id);
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
        return $this->getResource('Amici')->sendrequest($id_user);
    }
    public function rimuoviamco($id_user)
    {
        $this->getResource('Amici')->removefriend($id_user);
    }
    public function accettarichiesta($id_requester)
    {
        $this->getResource('Amici')->acceptrequest($id_requester);
    }
    public function rifiutarichiesta($id_requester)
    {
        return $this->getResource('Amici')->refuserequest($id_requester);
    }
    public function sonoamici($ida,$idb)
    {        
        return $this->getResource('Amici')->arefriends($ida,$idb);
    }
    
    public function controllaNotifiche($id){
        return $this->getResource('Notifiche')->controlnotification($id);
    }
    
    public function inviaNotifica($id,$tipo){
        return $this->getResource('Notifiche')->sendNotification($id,$tipo);
    }
    
    public function cambiaImmagine($dati,$id){
        return $this->getResource('Utenti')->changeprofilepic($dati,$id);
    }
    public function selezionatuttiblog()
    {
        return $this->getResource('Blog')->selectallblogs();
    }
}