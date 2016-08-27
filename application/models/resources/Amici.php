<?php
class Application_Resource_Utenti extends Zend_Db_Table_Abstract
{
    protected $_name    = 'amici';
    protected $_primary  = 'id_friendship';
    protected $_rowClass = 'Application_Resource_Amici_Item';

    public function init()
    {

    }

 
