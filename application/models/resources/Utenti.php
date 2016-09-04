<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'utenti';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init()
    {

    }

    public function findUserEmail($info)  //funziona
    {
        $select=$this->select()->where('email=?',$info);
        $res=$this->fetchRow($select);
        return $res;
    }

    public function insertUtenti($info) //funziona
    {
        $this->insert(array('Nome'=>$info['nome'],
            'Cognome'=>$info['cognome'],
            'immagine'=>$info['immagine'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi']));
    }

    public function editUtenti($info,$id)  //funziona
    {

        $where = $this->getAdapter()->quoteInto('id= ?', $id);
        $this->update(array('Nome'=>$info['Nome'],
            'Cognome'=>$info['Cognome'],
            'eta'=>$info['eta'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi'],
            'blog'=>$info['blog']), $where);
    }

    public function showUtenti()
    {
        $select=$this->select()->order('id');
        $res=$this->fetchAll($select);
        return $res;

    }

    public function showUtentedaID($id) //funziona
    {
        $select=$this->select()->where('id=?',$id);
        $res=$this->fetchAll($select);
        return $res;
    }
    
    public function deleteUtenti($id) //funziona
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

    public function setBlogtrue()  //funziona
    {
        $auth=Zend_Auth::getInstance();
        $id=$auth->getIdentity()->id;
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $true=true;
        $this->update(array('nome'=>$auth->getIdentity()->Nome,
            'cognome'=>$auth->getIdentity()->Cognome,
            'immagine'=>$auth->getIdentity()->immagine,
            'email'=>$auth->getIdentity()->email,
            'password'=>$auth->getIdentity()->password,
            'ruolo'=>$auth->getIdentity()->ruolo,
            'interessi'=>$auth->getIdentity()->interessi,
            'blog'=>$true),$where);
    }
    
    public function searchutenti($info)
    {
        $query = 'SELECT * FROM utenti  WHERE Nome LIKE "'.$info.'%" OR  Cognome LIKE "'.$info.'%"';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();
        return $res; 
    }

    public function changeprofilepic($dati,$id){
        $auth=Zend_Auth::getInstance();
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $this->update(array('immagine'=>$dati['immagine']), $where);
    }
    
}