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
        $this->insert(array('nome'=>$info['nome'],
            'cognome'=>$info['cognome'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo']));
    }

    public function editUtenti(array $info,$id)
    {

        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update(array('nome'=>$info['nome'],
            'cognome'=>$info['cognome'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo']), $where);
    }

    public function showUtenti()
    {
        $select=$this->select()->order('id');
        $res=$this->fetchAll($select);
        return $res;

    }

    public function showUtentedaID($info)
    {
        $select=$this->select()
            ->where('id =?', (int)$info);
        $res=$this->fetchAll($select);
        return $res;
    }
    
    public function deleteUtenti($mail)
    {
        $where = $this->getAdapter()->quoteInto('email = ?', $mail);
        $this->delete($where);
    }
}