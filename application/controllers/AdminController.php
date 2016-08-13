<?php

class AdminController extends Zend_Controller_Action
{
    protected $_adminModel;
    protected $_form;
    public $param;


    public function init()
    {
        $this->_helper->layout->setLayout('layoutadmin');
        $this->_adminModel = new Application_Model_Admin();
    }

    public function indexAction()
    {

    }
}