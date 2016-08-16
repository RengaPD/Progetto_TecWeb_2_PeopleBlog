<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'utenti';
    protected $_primary  = 'email';
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
    
}