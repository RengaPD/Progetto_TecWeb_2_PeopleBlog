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
                            'datetime'=>$datetime,
                            'titolo'=>$info['titolo'],
                            'post'=>$info['post']));
        
    }

    public function getposts_byuser($id_user)
    {
        $select=$this->select()
            ->where('Nome=?',$nome)
            ->where('Cognome=?',$cognome)->order('datetime');
        $res=$this->fetchAll($select);
        return $res;
    }
    public function getposts_byid($id_post)
    {
        $select=$this->select()
            ->where('id=?',$id_post)
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
            'id'=>$_auth->getIdentity()->id,
            'datetime'=>$datetime,
            'titolo'=>$dati['titolo'],
            'post'=>$dati['post']));

    }
    
    public function editpost($dati,$a)
    {
        $_auth=Zend_Auth::getInstance();
        $where=array('id_user=?'=>$_auth->getIdentity()->id,
                      'datetime=?'=>$a);
        $this->update(array('titolo'=>$dati['titolo'],
            'post'=>$dati['post']), $where);
    }

    public function getbydatetime($datetime)
    {
        $_auth=Zend_Auth::getInstance();
        $select=$this->select()
            ->where('id_user=?',$_auth->getIdentity()->id)
            ->where('datetime=?',$datetime);
        $res=$this->fetchAll($select);
        return $res;
    }

    public function deletepost($a)
    {
        $_auth=Zend_Auth::getInstance();
        $where=array('Nome=?'=>$_auth->getIdentity()->Nome,
            'Cognome=?'=>$_auth->getIdentity()->Cognome,
            'datetime=?'=>$a);
        $this->delete($where);
    }

    public function selblogs()
    {
        $select=$this->select()
            ->where('titoloblog IS NOT NULL');
        $res=$this->fetchAll($select);
        return $res;
    }
}