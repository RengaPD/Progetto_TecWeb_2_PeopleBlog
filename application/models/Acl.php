<?php

class Application_Model_Acl extends Zend_Acl
{
    public function __construct()
    {

        $this->addRole(new Zend_Acl_Role('visitatore'))
            ->addResource(new Zend_Acl_Resource('public'))
            ->addResource(new Zend_Acl_Resource('error'))
            ->addResource((new Zend_Acl_Resource(('index'))))
            ->allow('visitatore', array('public','error','index'));

        $this->addRole(new Zend_Acl_Role('utente'))
            ->addResource(new Zend_Acl_Resource('user'))
            ->allow('utente',array('user','public','error','index'));


        $this->addRole(new Zend_Acl_Role('staff'), 'utente')
            ->addResource(new Zend_Acl_Resource('staff'))
            ->allow('staff',array('staff','user'));

        $this->addRole(new Zend_Acl_Role('admin'),'staff')
            ->addResource(new Zend_Acl_Resource('admin'))
            ->allow('admin','admin');
    }
}