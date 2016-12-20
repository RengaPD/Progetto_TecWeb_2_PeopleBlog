<?php
class StaffController extends Zend_Controller_Action
{
    protected $_staffModel;
    protected $_adminModel;
    protected $_userModel;
    protected $_form;


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

    public function visualizzablogAction(){
        $res=$this->_staffModel->visualizzablog()->toArray();
        $this->view->assign('risultato', $res);
        $bottone=new Zend_Form_Element_Submit('modifica');
        $bottone->setLabel('Modifica');
        $this->view->assign('bottonemod',$bottone);
        $bottone=new Zend_Form_Element_Submit('cancella');
        $bottone->setLabel('Cancella');
        $this->view->assign('bottonedel',$bottone);

    }

    public function modificablogAction(){
        $a=$this->_getParam('id');
        $id_user=$this->getParam('id_user');
        $form = new Application_Form_Utente_Blog_Posta();
        $gigi=$this->_staffModel->visualizzaBlogdaID($a)->toArray();
        $form->populate($gigi[0]);
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_staffModel->modificapost($dati,$a);
                echo 'Dati inseriti con successo';
                $auth=Zend_Auth::getInstance();
                $this->inviaNotificaAction($id_user,3,"");
            }
            else
            {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);

    }

    public function cancellablogAction(){
        $a=$this->getParam('id');
        $id_user=$this->getParam('id_user');
        $this->_staffModel->eliminapost($a);
        $this->inviaNotificaAction($id_user,3);
    }

    public function inviaNotificaAction($id_destinatario,$tipologia,$testo){
        $this->_userModel->inviaNotifica($id_destinatario,$tipologia,$testo);
    }
}