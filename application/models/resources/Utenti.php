<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'utenti';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init()
    {

    }

    public function findUserEmail($info)
    {
        $select=$this->select()->where('email=?',$info);
        $res=$this->fetchRow($select);
        return $res;
    }

    public function insertUtenti($info)
    {
        $this->insert(array('Nome'=>$info['nome'],
            'Cognome'=>$info['cognome'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo']));
    }

    public function editUtenti($info,$id)
    {

        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update(array('Nome'=>$info['Nome'],
            'Cognome'=>$info['Cognome'],
            'eta'=>$info['eta'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi']), $where);
    }

    public function showUtenti()
    {
        $select=$this->select()->order('id');
        $res=$this->fetchAll($select);
        return $res;

    }

    public function showUtentedaID($id)
    {
        $select=$this->select()
            ->where('id =?', (int)$id);
        $res=$this->fetchAll($select);
        return $res;
    }
    
    public function deleteUtenti($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

    public function setBlogtrue()
    {
        $auth=Zend_Auth::getInstance();
        $id=$auth->getIdentity()->id;
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $true=true;
        $this->update(array('nome'=>$auth->getIdentity()->Nome,
            'cognome'=>$auth->getIdentity()->Cognome,
            'email'=>$auth->getIdentity()->email,
            'password'=>$auth->getIdentity()->password,
            'ruolo'=>$auth->getIdentity()->ruolo,
            'interessi'=>$auth->getIdentity()->interessi,
            'blog'=>$true),$where);
    }
}