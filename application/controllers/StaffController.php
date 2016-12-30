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
        $autore="";
        /*for($i=0;$i<=sizeof($res);$i++)
        {
            $id_autore=$res[$i]['id_user'];
            $ris=$this->_userModel->mostrautente($id_autore)->toArray();
            $autore[$i]=$ris[0]['Nome']." ".$ris[0]['Cognome'];
        }*/
        $this->view->assign('autore',$autore);
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
        $this->inviaNotificaAction($id_user,99,"Il tuo post è stato eliminato");
    }

    public function cancellainteroblogAction()
    {
        $a=$this->getParam('id');
        $id_user=$this->getParam('id_user');
        $form=new Application_Form_Staff_Blog_Cancella();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $this->_staffModel->eliminablog($a);
                $this->inviaNotificaAction($id_user,99,$form->getValue('motivazione'));
                $this->redirect('staff/visualizzablog');
                
            }
        }
        $this->view->assign('form',$form);
    }
    public function inviaNotificaAction($id_destinatario,$tipologia,$testo){
        $this->_userModel->inviaNotifica($id_destinatario,$tipologia,$testo);
    }
}