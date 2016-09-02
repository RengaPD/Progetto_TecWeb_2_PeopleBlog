<?php

class Application_Resource_Notifiche extends Zend_Db_Table_Abstract
{
    protected $_name = 'notifiche';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Resource_Notifiche_Item';

    public function init()
    {

    }

    public function controlnotification($id){ //funziona
        $select=$this->select()->where('id_destinatario=?',$id);
        $res=$this->fetchAll($select);
        return $res;
    }
    
    public function sendNotification($id,$tipo){
        $auth=Zend_Auth::getInstance();
        $this->insert(array('id_destinatario'=>$id,
                            'id_mittente'=>$auth->getIdentity()->id,
                            'tipologia'=>$tipo));
    }
    
    
}