<?php

class Application_Resource_Commenti extends Zend_Db_Table_Abstract
{
    protected $_name = 'commenti';
    protected $_primary = 'comment_id';
    protected $_rowClass = 'Application_Resource_Commenti_Item';

    public function init()
    {

    }

    public function sendcomment($dati,$id){
        $auth=Zend_Auth::getInstance();
        $nome_completo=$auth->getIdentity()->Nome.' '.$auth->getIdentity()->Cognome;
        $this->insert(array('user_id'=>$auth->getIdentity()->id,
                            'autore_commento'=>$nome_completo,
                            'post_id'=>$id,
                            'comment'=>$dati['commento']));
    }
    
    public function selectallcommentspost($idpost){

        $select = $this->select()
            ->from(array('c' =>'commenti'),array('comment_id','user_id','post_id','comment'))
            ->where('c.post_id=?',$idpost)
            ->join('utenti','c.user_id = utenti.id',array('Nome','Cognome','immagine'))
            ->setIntegrityCheck(false); //necessario per evitare l'errore della doppia tabella
        $res=$this->fetchAll($select);
        return $res;
    }

    public function deletecomment($id){
        $where = $this->getAdapter()->quoteInto('comment_id= ?', $id);
        $this->delete($where);
    }

    public function commentownership($idcomment, $idowner){
        $select = $this->select()->from('commenti')
            ->where('commenti.user_id=?',$idowner)
            ->where('commenti.comment_id=?',$idcomment);
        $res=$this->fetchAll($select);

        if (count($res)){
            return true;
        }else return false;
    }

    public function insertcomment($comment, $idpost){

        $_auth=Zend_Auth::getInstance();

        $this->insert(array(
            'user_id'=>$_auth->getIdentity()->id,
            'post_id'=>$idpost,
            'comment'=>$comment));
    }


}

