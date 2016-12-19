<?php
class StaffController extends Zend_Controller_Action
{
    protected $_staffModel;
    protected $_adminModel;
    protected $_userModel;
    protected $_form;


    //le azioni dello staff sono state incorporate all'interno del blogscript e postscript visto che agiscono 
    //esclusivamente su di loro
    public function init()
    {
        $this->_helper->layout->setLayout('layoutstaff');
        $this->_staffModel = new Application_Model_Staff();
        $this->_adminModel= new Application_Model_Admin();
        $this->_userModel=new Application_Model_User();
    }
    public function indexAction()
    {
        
    }

}