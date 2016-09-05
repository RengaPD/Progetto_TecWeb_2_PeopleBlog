<?php

class Application_Resource_Blog extends Zend_Db_Table_Abstract
{
    protected $_name = 'blog';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Resource_Blog_Item';
    protected $_userModel;
    protected $_auth;

    public function init()
    {

    }
    
    public function creaBlog($info)  //funziona
    {
        $_auth=Zend_Auth::getInstance();
        $datetime=new DateTime();
        $datetime=date_format($datetime, 'Y-m-d H:i:s');
        $this->insert(array('titoloblog' => $info['nomeblog'],
                            'datetime'=>$datetime,
                            'titolo'=>$info['titolo'],
                            'post'=>$info['post'],
                            'id_user'=>$_auth->getIdentity()->id));
        
    }

    public function showBlog(){  //funziona
        $select=$this->select()->order('id_user');
        $res=$this->fetchAll($select);
        return $res;
    }

    public function getposts_byuser($id_user)  //funziona
    {
        $select=$this->select()->where('id_user=?',$id_user)->order('datetime');
        $res=$this->fetchAll($select);
        return $res;
    }
    public function getposts_byid($id_post)  //funziona
    {
        $select=$this->select()
            ->where('id=?',$id_post);
        $res=$this->fetchAll($select);
        return $res;
    }

    public function sendposts($dati)
    {
        $_auth=Zend_Auth::getInstance();
        $datetime=new DateTime();
        $datetime=date_format($datetime, 'Y-m-d H:i:s');
        $this->insert(array('titoloblog' => null, //non importa se è null, per visualizzarlo viene usato
            //il primissimo post con index 0 dove è specificato
            'datetime'=>$datetime,
            'titolo'=>$dati['titolo'],
            'post'=>$dati['post'],
            'id_user'=>$_auth->getIdentity()->id,));

    }
    
    public function editpost($dati,$a) //versione utente, funziona
    {
        $_auth=Zend_Auth::getInstance();
        $where=array('id_user=?'=>$_auth->getIdentity()->id,
                      'datetime=?'=>$a);
        $this->update(array('titolo'=>$dati['titolo'],
            'post'=>$dati['post']), $where);
    }
    
    public function editpostbystaff($dati,$a){  //funziona
        $where=$this->getAdapter()->quoteInto('id=?',$a);
        $this->update(array('titolo'=>$dati['titolo'],
            'post'=>$dati['post']),$where);
    }

    public function getbydatetime($datetime) //funziona
    {
        $_auth=Zend_Auth::getInstance();
        $select=$this->select()
            ->where('id_user=?',$_auth->getIdentity()->id)
            ->where('datetime=?',$datetime);
        $res=$this->fetchAll($select);
        return $res;
    }

    public function deletepost($id) //funziona
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }
    
    public function selblogs() //funziona
    {
        $select=$this->select()
            ->where('titoloblog IS NOT NULL');
        $res=$this->fetchAll($select);
        return $res;
    }

    public function selectallblogs()
    {
        $select=$this->select()->from('blog');

        return $select;
    }
    public function selectallblogsicanseeofID($id)
    {

        $select = $this->select()
            ->from('blog',
                array('titoloblog','titolo', 'datetime', 'descrizione'))
            ->join(array('pryvacyrule'),
                'pryvacyrule.id_blog = blog.id')
            ->where('pryvacyrule.id_friend <> ?',$id)
            ->setIntegrityCheck(false);

        return $select;
    }

}