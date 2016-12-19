<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'utenti';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init()
    {

    }

    public function findUserEmail($info)  //funziona
    {
        $select=$this->select()->where('email=?',$info);
        $res=$this->fetchRow($select);
        return $res;
    }

	public function findUserName($info)  //funziona
    {
        $select=$this->select()
            ->where('username=?',$info['username'])
            ->where('password=?',$info['password']);
        $res=$this->fetchRow($select);
		return $res;
    }

    public function insertUtenti($info) //funziona
    {
        $this->insert(array('Nome'=>$info['nome'],
            'Cognome'=>$info['cognome'],
            'immagine'=>'prova.jpg',
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi']));
    }

    public function editUtenti($info,$id)  //funziona
    {

        $where = $this->getAdapter()->quoteInto('id= ?', $id);
        $this->update(array('Nome'=>$info['Nome'],
            'Cognome'=>$info['Cognome'],
            'eta'=>$info['eta'],
            'email'=>$info['email'],
            'password'=>$info['password'],
            'ruolo'=>$info['ruolo'],
            'interessi'=>$info['interessi']), $where);
    }

    public function showUtenti($pagina=null)
	{
		$select=$this->select()->order('id');
		if (null !== $pagina) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(25)
		          	  ->setCurrentPageNumber((int) $pagina);
			return $paginator;
		}
        $res=$this->fetchAll($select);
        return $res;
	}

    public function showUserbyID($id) //funziona
    {
        $select=$this->select()->where('id=?',$id);
        $res=$this->fetchAll($select);
        return $res;
    }
    
    public function deleteUtenti($id) //funziona
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

    public function setBlogtrue()  //funziona
    {
        $auth=Zend_Auth::getInstance();
        $id=$auth->getIdentity()->id;
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $true=true;
        $this->update(array('nome'=>$auth->getIdentity()->Nome,
            'cognome'=>$auth->getIdentity()->Cognome,
            'immagine'=>$auth->getIdentity()->immagine,
            'email'=>$auth->getIdentity()->email,
            'password'=>$auth->getIdentity()->password,
            'ruolo'=>$auth->getIdentity()->ruolo,
            'interessi'=>$auth->getIdentity()->interessi,
            'blog'=>$true),$where);
    }

    public function setBlogfalse()  //funziona
    {
        $auth=Zend_Auth::getInstance();
        $id=$auth->getIdentity()->id;
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $false=false;
        $this->update(array('nome'=>$auth->getIdentity()->Nome,
            'cognome'=>$auth->getIdentity()->Cognome,
            'immagine'=>$auth->getIdentity()->immagine,
            'email'=>$auth->getIdentity()->email,
            'password'=>$auth->getIdentity()->password,
            'ruolo'=>$auth->getIdentity()->ruolo,
            'interessi'=>$auth->getIdentity()->interessi,
            'blog'=>$false),$where);
    }
    
    public function search($info) //funziona
    {
        //var_dump($info);

        $query = $this->select()
            ->where('Nome LIKE ?',$info.'%')
            ->orWhere('Cognome LIKE ?',$info.'%');
        $res=$this->fetchAll($query);
        return $res; 
    }

    public function changeprofilepic($dati,$id){
        $auth=Zend_Auth::getInstance();
        $where=$this->getAdapter()->quoteInto('id=?',$id);
        $this->update(array('immagine'=>$dati['immagine']), $where);
    }

    public function findUsersNotMeNotStaff($info) //funziona
    {

        $query = $this->select()
            ->where("ruolo = 'utente'")
            ->where('Nome LIKE ?',$info.'%')
            ->orWhere('Cognome LIKE ?',$info.'%');
        $res=$this->fetchAll($query);
        return $res;
    }

}