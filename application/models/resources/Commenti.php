<?php

class Application_Resource_Commenti extends Zend_Db_Table_Abstract
{
    protected $_name = 'commenti';
    protected $_primary = 'comment_id';
    protected $_rowClass = 'Application_Resource_Notifiche_Item';

    public function init()
    {

    }

    public function sendcomment($dati,$id){
        $auth=Zend_Auth::getInstance();
        $this->insert(array('user_id'=>$auth->getIdentity()->id,
                            'post_id'=>$id,
                            'comment'=>$dati['commento']));
    }
    
    public function getcomments($id_post){
        $select=$this->select()
        ->where('post_id=?',$id_post);
        $res=$this->fetchAll($select);
        return $res;
    }

    public function deletecomment($id){
        $where = $this->getAdapter()->quoteInto('comment_id= ?', $id);
        $this->delete($where);
    }


}