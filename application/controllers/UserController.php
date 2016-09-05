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

    public function indexAction() //funziona
    {
        $notifiche=$this->controllaNotificheAction();
        $this->view->assign('notifiche',$notifiche);
        $messaggio='';
        for($i=0;$i<sizeof($notifiche);$i++){
            $id_mittente=$notifiche[$i]['id_mittente'];
            $res=$this->_adminModel->visualizzaUtentedaID($id_mittente)->toArray();
            $nome_mittente=$res[0]['Nome'].' '.$res[0]['Cognome'];
            switch ($notifiche[$i]['tipologia']){
                case 1:{
                    $messaggio[$i]='<li>Hai ricevuto una richiesta di amicizia da '.$nome_mittente.'</li>';
                    break;
                }
                case 2:{
                    $messaggio[$i]='<li>'.$nome_mittente.' ha commentato un tuo post!</li>';
                    break;
                }
                case 3:{
                    $messaggio[$i]='<li>Hai ricevuto una notifica dallo staff</li>';
                    break;
                }
            }
        }
        $bottone=new Zend_Form_Element_Submit('gestisci');
        $bottone->setLabel('Gestisci');
        $this->view->assign('bottone',$bottone);
        $this->view->assign('messaggio',$messaggio);
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
    
    public function cambiaimmagineAction(){ //funziona
        $a=$this->_authService->getIdentity()->id;
        $form = new Application_Form_Utente_Profilo_CambiaImg();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_userModel->cambiaImmagine($dati,$a);
                echo 'Immagine cambiata con successo';
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
    
    public function controllaNotificheAction(){ //funziona
        $info=Zend_Auth::getInstance();
        $id_user=$info->getIdentity()->id;
        $notifiche=$this->_userModel->controllaNotifiche($id_user);
        return $notifiche;
    }
    
    public function inviaNotificaAction($id_destinatario,$tipologia){  //funziona
        $this->_userModel->inviaNotifica($id_destinatario,$tipologia);
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
            $this->view->assign('immagine',$auth->getIdentity()->immagine);

        }else{
            $this->view->sonoio = false;
            $this->view->idprofile = $id;
            $userinfo = $this->_userModel->mostrautente($id)->toArray();
            $this->view->interessi = $userinfo[0]["interessi"];
            $this->view->assign('nome',$userinfo[0]["Nome"]);
            $this->view->assign('cognome',$userinfo[0]["Cognome"]);
            $this->view->assign('eta',$userinfo[0]["eta"]);
            $this->view->assign('immagine',$userinfo[0]["immagine"]);


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
    public function updateajaxblogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $data = $this->_userModel->selezionatuttiblogvisibiliamediID($_POST['id']);

        $adapter = new Zend_Paginator_Adapter_DbSelect($data);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(3);
        $paginator->setCurrentPageNumber($_POST['page']);
        //il massimo numero di pagine
        $condition = (integer) ceil($paginator->getTotalItemCount() / $paginator->getItemCountPerPage());

        if ($paginator != null && ($condition >= $_POST['page'])) {
            $this->getResponse()->setHeader('Content-type', 'application/json')->setBody($paginator->toJson());
        }
    }

    public function updateajaxpostAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $user = $this->_userModel->cercautente($_POST['q']);
        if ($user != null) {
            $this->getResponse()->setHeader('Content-type', 'application/json')->setBody(json_encode($user));
        }
    }
}