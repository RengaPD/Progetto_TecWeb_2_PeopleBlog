<?php
class Application_Resource_Amici extends Zend_Db_Table_Abstract
{
    protected $_name = 'amicizie';
    protected $_primary = 'id_friendship';
    protected $_rowClass = 'Application_Resource_Amici_Item';

    public function init()
    {

    }

    public function showmyfriends($id_user)
    {

        $query = 'SELECT * FROM amicizie  WHERE (idamico_a = "'.$id_user.'" OR  idamico_b = "'.$id_user.'") AND  state = "accepted"';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();
        return $res;
    }
	
	public function showpending($id_user)
	{
		$query='SELECT * FROM amicizie WHERE idamico_b= "'.$id_user.'" AND state= "requested"';
		$db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();
        return $res;
		
	}
    
    
    public function show_all_request($id_user){
        $query='SELECT * FROM amicizie WHERE idamico_a ='.$id_user.' OR idamico_b ='.$id_user.'';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();
        return $res;
    }

    public function show_outgoing_requests($id_user)
    {

        $query = 'SELECT * FROM amicizie  WHERE requestedby = "'.$id_user.'"';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();

        return $res;
    }
    public function show_request($id_request)
    {
        $query = 'SELECT * FROM amicizie  WHERE id_friendship = "'.$id_request.'"';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();
        return $res;
    }


    public function sendrequest($id)
    {
        //controllo pre-richiesta
        $auth=Zend_Auth::getInstance();
        $id_requester=$auth->getIdentity()->id;

        $query = 'SELECT * FROM amicizie  WHERE (requestedby = "'.$id_requester.'" AND  idamico_b = "'.$id.'") OR (requestedby = "'.$id.'" AND idamico_b = "'.$id_requester.'") ';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();



        if (empty($res)) {

            //se non ci sono richieste da parte di b nei confronti di a e non sono gia state fatte altre richiesta da parte di a crea la richiesta
            $this->insert(array('idamico_a' => $id_requester,
                'idamico_b' => $id,
                'requestedby' => $id_requester,
                'state' => 'requested',
            ));
            return true;
        } else return false;
    }

    public function removefriend($id_removed)
    {
        $auth=Zend_Auth::getInstance();
        $id_remover=$auth->getIdentity()->id;

        $query = 'DELETE FROM amicizie  WHERE ((requestedby = "'.$id_remover.'" AND  idamico_b = "'.$id_removed.'") OR (requestedby = "'.$id_removed.'" AND idamico_b = "'.$id_remover.'")) AND state = "accepted" ';
        $db=Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);


    }
    public function acceptrequest($id_requester)
    {

        $auth=Zend_Auth::getInstance();
        $id_user=$auth->getIdentity()->id;
        //$select=$this->select()->where('requestedby =?', $id_requester)->where('idamico_b =?', $id_user);
		$where=array();
		$where[] = $this->getAdapter()->quoteInto('requestedby= ?',$id_requester);
		$where[] = $this->getAdapter()->quoteInto('idamico_b = ?', $id_user);
        $this->update(array('state'=>'accepted'), $where);
    }
    public function refuserequest($id_requester)
    {
        $auth=Zend_Auth::getInstance();
        $id_user=$auth->getIdentity()->id;
        $where=array();
		$where[] = $this->getAdapter()->quoteInto('requestedby= ?',$id_requester);
		$where[] = $this->getAdapter()->quoteInto('idamico_b = ?', $id_user);
        $this->update(array('state'=>'refused'), $where);
    }
    public function arefriends($ida,$idb)
    {
        $query = 'SELECT * FROM amicizie  WHERE ((requestedby = "'.$ida.'" AND  idamico_b = "'.$idb.'") OR (requestedby = "'.$idb.'" AND idamico_b = "'.$ida.'")) AND state = "accepted" ';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter()->query($query);
        $res=$db->fetchAll();


        if (empty($res)) {
            return false;
        } else return true;
    }



}