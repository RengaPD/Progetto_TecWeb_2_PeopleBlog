<?php
class Application_Resource_Post extends Zend_Db_Table_Abstract
{
    protected $_name = 'post';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Resource_Post_Item';

    public function init()
    {

    }
    public function selectallpostbyidblog($id) //funziona
    {
        $select=$this->select()->where('blog_id=?',$id);
        return $select;
    }
    public function editpost($dati,$post) //versione utente, funziona
    {
        $where = $this->getAdapter()->quoteInto('id=?',$post);
        $this->update(array('title'=>$dati['title'],
            'content'=>$dati['content']), $where);
    }
    public function getpostbyid($post) //funziona
    {
        $select=$this->select()
            ->where('id=?',$post);
        $res=$this->fetchAll($select);

        return $res;
    }
    public function deletepost($id) //funziona
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }
    public function postownerbyidpost($idpost)
    {
        $select = $this->select()
            ->from('blog',array('id_user'))
            ->join('post','blog.idblog = post.blog_id')
            ->where('post.id=?',$idpost)
            ->setIntegrityCheck(false); //necessario per evitare l'errore della doppia tabella
        $res = $this->fetchAll($select);
        return $res;
    }
}