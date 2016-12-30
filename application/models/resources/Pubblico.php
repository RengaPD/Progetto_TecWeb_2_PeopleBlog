<?php

class Application_Resource_Pubblico extends Zend_Db_Table_Abstract
{
    protected $_name    = 'utenti';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init()
    {
    }

    public function register($info)
    {
        $this->insert(array('Nome'=>$info['Nome'],
            'Cognome'=>$info['Cognome'],
            'username'=>$info['username'],
            'immagine'=>'prova.jpg',
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi']));
    }

   
}