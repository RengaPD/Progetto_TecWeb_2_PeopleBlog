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

    public function logoutAction() //funziona
    {
        $this->_authService->clear();
        return $this->_helper->redirector('index','public');
    }
    public function modificaprofiloAction() //
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
    
    public function controllaNotificheAction(){ //funziona
        $info=Zend_Auth::getInstance();
        $id_user=$info->getIdentity()->id;
        $notifiche=$this->_userModel->controllaNotifiche($id_user);
        return $notifiche;
    }
    
    public function inviaNotificaAction($id_destinatario,$tipologia){ 
        $this->_userModel->inviaNotifica($id_destinatario,$tipologia);
    }
}