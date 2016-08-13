<?php
class StaffController extends Zend_Controller_Action
{
    protected $_staffModel;
    protected $_form;


    public function init()
    {
        $this->_helper->layout->setLayout('layoutstaff');
        $this->_staffModel = new Application_Model_Staff();
    }

    public function indexAction()
    {

    }
}