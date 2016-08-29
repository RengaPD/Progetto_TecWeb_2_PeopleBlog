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

    public function show_outgoing_requests($id_user)
    {
        $select->where
            ->equalTo('requestedby', $id_user);

        $res=$this->fetchAll($select);
        return $res;
    }


    public function sendrequest($id_requester, $id)
    {
        //controllo pre-richiesta

        $select->where
            //il richiedente ha gia richiesto ?
            ->nest()
            ->equalTo('requestedby', $id_requester)
            ->and
            ->equalTo('idamico_b', $id)
            ->unnest()
            ->or
            //oppure il richiesto ha gia mandato una richiesta?
            ->nest()
            ->equalTo('requestedby', $id)
            ->and
            ->equalTo('idamico_b', $id_requester)
            ->unnest();
            //il codice così scritto sottintende anche un controllo sul fatto che non ci sia gia un amicizia

        $res=$this->fetchAll($select);

        if(!empty($res))
        {

            //se non ci sono richieste da parte di b nei confronti di a e non sono gia state fatte altre richiesta da parte di a crea la richiesta
            $this->insert(array('idamico_a' => $id_requester,
                'idamico_b' => $id,
                'requestedby' => $id_requester,
                'state' => 'requested',
            ));
            return true
        }else return false
    }

    public function removefriend($id_remover,$id_removed)
    {
        $selection->where

            ->nest()
            ->nest()
            ->equalTo('requestedby', $id_requester)
            ->and
            ->equalTo('idamico_b', $id_removed)
            ->unnest()
            ->or
            ->nest()
            ->equalTo('requestedby', $id_removed)
            ->and
            ->equalTo('idamico_b', $id_requester)
            ->unnest()
            ->unnest()
            ->and
            ->equalTo('state', 'accepted');

        $this->delete($selection);

    }