<?php
class UserController extends Zend_Controller_Action
{
    protected $_adminModel;
    protected $_userModel;
    protected $_authService;

    public function init()
    {
        $this->_userModel=new Application_Model_User();
        $this->_adminModel=new Application_Model_Admin();
        $this->_helper->layout->setLayout('layoutuser');
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction()
    {

    }

    public function logoutAction()
    {
        $this->_authService->clear();
        return $this->_helper->redirector('index','public');
    }
    public function aggiungiamicoAction()
    {
        $id = $this->getParam('id');
        $this->_userModel->aggiungiamico($id);
        return $this->_helper->redirector('showuserprofile', 'user', null, array('id' => $id));
    }
    public function modificaprofiloAction() //non funziona?
    {
        $a=$this->_authService->getIdentity()->id;
        $form = new Application_Form_Utente_Profilo_Aggiorna();
        $gigi=$this->_adminModel->visualizzaUtentedaID($a)->toArray();
        $form->populate($gigi[0]);
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_userModel->modificaProfilo($dati,$a);
                echo 'Dati inseriti con successo';
            }
            else
            {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }

    public function creablogAction() //ok funziona!
    {
        $form=new Application_Form_Utente_Blog_Crea();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_userModel->creaBlog($dati);
                echo 'Blog creato!';
            }
            else
            {
                echo 'Creazione blog fallita';
            }
        }
        $this->view->assign('form', $form);
    }

    public function controllaamiciAction()
    {
        $this->_userModel->controllaamici();
    }
    public function showuserprofileAction()
    {
    
        $auth=Zend_Auth::getInstance();
        $myid=$auth->getIdentity()->id;
        
        $id=$this->getParam('id');

        if(('my'==$id)) {
            $this->view->sonoio = true;
            $this->view->interessi = $auth->getIdentity()->interessi;
            $this->view->assign('nome',$auth->getIdentity()->Nome);
            $this->view->assign('cognome',$auth->getIdentity()->Cognome);
            $this->view->assign('eta',$auth->getIdentity()->eta);
        }else{
            $this->view->sonoio = false;
            $this->view->idprofile = $id;
            $userinfo = $this->_userModel->mostrautente($id)->toArray();
            $this->view->interessi = $userinfo[0]["interessi"];
            $this->view->assign('nome',$userinfo[0]["Nome"]);
            $this->view->assign('cognome',$userinfo[0]["Cognome"]);
            $this->view->assign('eta',$userinfo[0]["eta"]);

            if($this->_userModel->sonoamici($id,$myid))
            {
                $this->view->assign('amici',true);

            }else
            {
                $this->view->assign('amici',false);

            }

        }

        

    }
    public function updateajaxAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $user = $this->_userModel->cercautente($_POST['q']);
        if ($user != null) {
            $this->getResponse()->setHeader('Content-type', 'application/json')->setBody(json_encode($user));
        }
    }
}