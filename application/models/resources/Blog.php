<?php

class Application_Resource_Blog extends Zend_Db_Table_Abstract
{
    protected $_name = 'blog';
    protected $_primary = 'idblog';
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
        $this->insert(array(
                            'datetime'=>$datetime,
                            'titolo'=>$info['titolo'],
                            'descrizione'=>$info['post'],
                            'id_user'=>$_auth->getIdentity()->id));
        
    }

    public function showBlog(){  //funziona
        $select=$this->select()->order('id_user');
        $res=$this->fetchAll($select);
        return $res;
    }

    public function getblog_byuser($id_user)  //funziona
    {
        $select=$this->select()->where('id_user=?',$id_user)->order('datetime');
        $res=$this->fetchAll($select);
        return $res;
    }
    public function getblog_byid($id_blog)  //funziona
    {
        $select=$this->select()
            ->where('idblog=?',$id_blog);
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
    
    public function editblog($dati,$a) //versione utente, funziona
    {
        $_auth=Zend_Auth::getInstance();
        $where=array('id_user=?'=>$_auth->getIdentity()->id,
                      'datetime=?'=>$a);
        $this->update(array('titolo'=>$dati['titolo'],
            'post'=>$dati['post']), $where);
    }
    
    public function editpostbystaff($dati,$a){  //funziona
        $where=$this->getAdapter()->quoteInto('idblog=?',$a);
        $this->update(array('titolo'=>$dati['titolo'],
            'post'=>$dati['post']),$where);
    }

    

    public function deleteblog($id) //funziona
    {
        $where = $this->getAdapter()->quoteInto('idblog = ?', $id);
        $this->delete($where);
    }
    
    

    public function selectallblogs()
    {
        $select=$this->select()->from('blog');
        $res= $this->fetchAll($select);
        $total = count($res);
        return $total;
    }
    public function selectallblogsicanseeofID($id)
    {
        $_auth=Zend_Auth::getInstance();

        
        $select = $this->select()
            ->from('blog')
            ->joinLeft('privacyrule','blog.idblog = privacyrule.id_blog')//effettua il left join che prende dalla tabella a destra anche quelle che non rispettano
            ->where('blog.id_user = ?',$id)// che appartengono alla persona di cui sto visitando la pagina
            ->where("privacyrule.idprv IS NULL OR privacyrule.id_friend <> ?",$_auth->getIdentity()->id)//di questi blog seleziono quelli che non hanno regole sulla privacy...
          //o se cele hanno non coinvolgono il richiedente...
            ->setIntegrityCheck(false);//necessario per evitare l'errore della doppia tabella
        
        return $select;
    }

}