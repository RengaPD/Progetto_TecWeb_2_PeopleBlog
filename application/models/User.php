<?php

class Application_Model_User extends App_Model_Abstract
{


    public function __construct()
    {

    }
    
//FUNZIONI BASE UTENTE
    public function modificaProfilo($info,$id)
    {
        return $this->getResource('Utenti')->editUtenti($info,$id);
    }
    public function cercautente($info)
    {
        return $this->getResource('Utenti')->search($info);
    }
    public function mostrautente($id)
    {
        return $this->getResource('Utenti')->showUserbyID($id);
    }
    
    
    
    public function creaBlog($dati)
    {
       $this->getResource('Blog')->creaBlog($dati);
    }

    public function mostraamici($id_user)
    {
        return $this->getResource('Amici')->showmyfriends($id_user);
    }
	
	public function mostrainattesa($id_user)
	{
		return $this->getResource('Amici')->showpending($id_user);
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
    
    public function inviaNotifica($id,$tipo,$testo){
        return $this->getResource('Notifiche')->sendNotification($id,$tipo,$testo);
    }
    
    public function cambiaImmagine($dati,$id){
        return $this->getResource('Utenti')->changeprofilepic($dati,$id);
    }
    
    
    
    //FUNZIONI BLOG----------------------
    public function selezionatuttiblog()
    {
        return $this->getResource('Blog')->selectallblogs();
    }
    public function visualizzaBlogdaID($id){
        return $this->getResource('Blog')->getblog_byid($id);
    }
    
    public function selezionatuttiblogvisibiliamediID($id)
    {
        return $this->getResource('Blog')->selectallblogsicanseeofID($id);
    }
    //-----------------------
    //FUNZIONI DEI POST
    public function selezionatuttipostdelblog($id)
    {
        return $this->getResource('Post')->selectallpostbyidblog($id);
    }


    
    public function gestisciNotifiche($id){
        return $this->getResource('Notifiche')->setread($id);
    }
    
    public function setblogfalse(){
        return $this->getResource('Utenti')->setBlogfalse();
    }
    public function utentepostdaidpost($id)
    {
        return $this->getResource('Post')->postownerbyidpost($id);

    }
    public function selezionatutticommentipost($idpost)
    {
        return $this->getResource('Commenti')->selectallcommentspost($idpost);

    }
    
}