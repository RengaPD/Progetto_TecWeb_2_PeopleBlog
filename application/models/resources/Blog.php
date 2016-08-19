<?php

class Application_Resource_Blog extends Zend_Db_Table_Abstract
{
    protected $_name = 'blog';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Resource_Blog_Item';
    protected $_userModel;
    protected $_auth;

    public function init()
    {

    }
    
    public function creaBlog($info)
    {
        $_auth=Zend_Auth::getInstance();
        $datetime=new DateTime();
        $datetime=date_format($datetime, 'Y-m-d H:i:s');
        $this->insert(array('titoloblog' => $info['nomeblog'],
                            'Nome'=>$_auth->getIdentity()->Nome,
                            'Cognome'=>$_auth->getIdentity()->Cognome,
                            'data e ora'=>$datetime,
                            'titolo'=>$info['titolo'],
                            'post'=>$info['post']));
        
    }

    public function getposts($nome,$cognome)
    {
        $select=$this->select()
            ->where('Nome=?',$nome)
            ->where('Cognome=?',$cognome)->order('data e ora');
        $res=$this->fetchAll($select);
        return $res;
    }

    public function sendposts($dati)
    {
        $_auth=Zend_Auth::getInstance();
        $datetime=new DateTime();
        $datetime=date_format($datetime, 'Y-m-d H:i:s');
        $this->insert(array('titoloblog' => null, //non importa se è null, per visualizzarlo viene usato
            //il primissimo post con index 0 dove è specificato
            'Nome'=>$_auth->getIdentity()->Nome,
            'Cognome'=>$_auth->getIdentity()->Cognome,
            'data e ora'=>$datetime,
            'titolo'=>$dati['titolo'],
            'post'=>$dati['post']));

    }
}