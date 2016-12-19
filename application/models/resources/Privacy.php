<?php

class Application_Resource_Privacy extends Zend_Db_Table_Abstract
{
    protected $_name = 'privacyrule';
    protected $_primary = 'idprv';
    protected $_rowClass = 'Application_Resource_Privacy_Item';
    protected $_userModel;
    protected $_auth;

    public function init()
    {

    }

    public function takeAllPrivacyUsers($idblog)
    {
        $select = $this->select()
            ->from(array('p' =>'privacyrule'),array('id_friend','id_blog'))
            ->join('utenti','p.id_friend = utenti.id',array('Nome','Cognome'))
            ->where('id_blog = ?',$idblog)
        ->setIntegrityCheck(false);//necessario per evitare l'errore della doppia tabella


        $res=$this->fetchAll($select);
        return $res;
    }

    public function deletePrivacyRule($blog,$user)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = array();
        $where[] = $db->quoteInto('id_friend = ?',$user);
        $where[] = $db->quoteInto('id_blog = ?',$blog);
        $db->delete('privacyrule', $where);

    }
    public function addPrivacyRule($blog,$user)
    {
        $this->insert(array(
            'id_friend'=>$user,
            'id_blog'=>$blog));

    }

}