<?php
class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'amici';
    protected $_primary  = 'id_friendship';
    protected $_rowClass = 'Application_Resource_Amici_Item';

    public function init()
    {

    }

    public function showmyfriends($id_user)
    {
        $select->where
            ->nest()
            ->equalTo('idamico_a', $id_user)
            ->or
            ->equalTo('idamico_b', $id_user)
            ->unnest()
            ->and
            ->equalTo('state', 'accepted');

        $res=$this->fetchAll($select);
        return $res;
    }
