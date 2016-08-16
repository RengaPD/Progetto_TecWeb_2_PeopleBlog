<?php
class Application_Service_Auth
{
    protected $_adminModel;
    protected $_auth;

    public function __construct()
    {
        $this->_adminModel=new Application_Model_Admin();
    }

    public function autenticazione($credenziali)
    {
        $adattatore=$this->getAuthAdapter($credenziali);
        $auth    = $this->getAutenticazione();
        $result  = $auth->authenticate($adattatore);

        if (!$result->isValid()) {
            return false;
        }
        $user = $this->_adminModel->trovaEmailUtente($credenziali['email']);
        $auth->getStorage()->write($user);
        return true;
    }

    public function getAutenticazione()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }

    public function getIdentity()
    {
        $auth = $this->getAutenticazione();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }

    public function clear()
    {
        $this->getAutenticazione()->clearIdentity();
    }

    public function getAuthAdapter($valori)
    {
        $adattore = new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table_Abstract::getDefaultAdapter(),
            'utenti',
            'email',
            'password'
        );
        $adattore->setIdentity($valori['email']);
        $adattore->setCredential($valori['password']);
        return $adattore;
    }
}