<?php
class UserController extends Zend_Controller_Action
{
    protected $_userModel;
    protected $_authService;
    protected $_blogModel;


    public function init()
    {
        $this->_userModel = new Application_Model_User();
        $this->_blogModel = new Application_Model_Blog();
        $this->_helper->layout->setLayout('layoutuser');
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction() //funziona
    {
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $this->view->assign('sonoio',true);
        $this->view->interessi = $auth->getIdentity()->interessi;
        $this->view->assign('nome', $auth->getIdentity()->Nome);
        $this->view->assign('cognome', $auth->getIdentity()->Cognome);
        $this->view->assign('eta', $auth->getIdentity()->eta);
        $this->view->assign('immagine', $auth->getIdentity()->immagine);

        $notifiche = $this->controllaNotificheAction();
        $this->view->assign('notifiche', $notifiche);
        $messaggio = '';
        for ($i = 0; $i < sizeof($notifiche); $i++) {
            $id_mittente = $notifiche[$i]['id_mittente'];
            //da spostare la funzione nell'user model
            $res = $this->_userModel->mostrautente($id_mittente)->toArray();
            $nome_mittente = $res[0]['Nome'] . ' ' . $res[0]['Cognome'];
            switch ($notifiche[$i]['tipologia']) {
                case 1: {
                    $messaggio[$i]['mex'] = '<li>Hai ricevuto una richiesta di amicizia da ' . $nome_mittente . '</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;
                }
                case 2: {
                    $messaggio[$i]['mex'] = '<li>' . $nome_mittente . ' ha commentato un tuo post!</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;
                }
                case 3: {
                    $messaggio[$i]['mex'] = '<li>Hai ricevuto una notifica dallo staff</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;
                }
                case 4: {
                    $messaggio[$i]['mex']= '<li>' . $nome_mittente . ' ti ha eliminato dagli amici</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;
                }
                case 6: {
                    $messaggio[$i]['mex'] = '<li>' . $nome_mittente . ' ha inserito un nuovo post nel suo blog</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;
                }
                default: {
                    $messaggio[$i]['mex'] = '<li>' . $notifiche[$i]['testo'] . '</li>';
					$messaggio[$i]['data']= $notifiche[$i]['datetime'];
                    break;

                }
            }
        }
        $bottone = new Zend_Form_Element_Submit('gestisci');
        $bottone->setLabel('Gestisci');
        $this->view->assign('bottone', $bottone);
        $this->view->assign('messaggio', $messaggio);
    }

    public function logoutAction()
    {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }

    public function aggiungiamicoAction()
    {
        $id = $this->getParam('id');
        $this->_userModel->aggiungiamico($id);
        return $this->_helper->redirector('showuserprofile', 'user', null, array('id' => $id));
    }

    public function modificaprofiloAction() //non funziona?
    {
        $a = $this->_authService->getIdentity()->id;
        $form = new Application_Form_Utente_Profilo_Aggiorna();
        $gigi = $this->_userModel->mostrautente($a)->toArray();
        $form->populate($gigi[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_userModel->modificaProfilo($dati, $a);
                echo 'Dati inseriti con successo';
            } else {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }

    public function cambiaimmagineAction()
    { //funziona
        $a = Zend_Auth::getInstance()->getIdentity()->id;
        $form = new Application_Form_Utente_Profilo_CambiaImg();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_userModel->cambiaImmagine($dati, $a);
                echo 'Immagine cambiata con successo';
                $this->redirect('user/showuserprofile/id/my');

            } else {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }

   

    public function controllaamiciAction()
    {
        $this->_userModel->controllaamici();
    }

    public function controllaNotificheAction()
    { //funziona
        $info = Zend_Auth::getInstance();
        $id_user = $info->getIdentity()->id;
        $notifiche = $this->_userModel->controllaNotifiche($id_user);
        return $notifiche;
    }

    public function inviaNotificaAction($id_destinatario, $tipologia,$testo)
    {  //funziona
        $this->_userModel->inviaNotifica($id_destinatario, $tipologia,$testo);
    }


    public function showuserprofileAction()
    {

        $auth = Zend_Auth::getInstance();
        $myid = $auth->getIdentity()->id;
        $role = $auth->getIdentity()->ruolo;
        if ($role == 'admin' or $role == 'staff')
        {
            $this->view->assign('staff',true);

        }else
        {
            $this->view->assign('staff',false);
        }
        if (isset($_POST["id"])){$id = $_POST["id"];}else{ $id = $this->getParam('id');}



        if ($id == $myid) {

            $id = $auth->getIdentity()->id;
            $this->view->assign('sonoio',true);
            $this->view->idprofile = $id;
            $this->view->interessi = $auth->getIdentity()->interessi;
            $this->view->assign('nome', $auth->getIdentity()->Nome);
            $this->view->assign('cognome', $auth->getIdentity()->Cognome);
            $this->view->assign('eta', $auth->getIdentity()->eta);
            $this->view->assign('immagine', $auth->getIdentity()->immagine);

        } else {
            $this->view->assign('sonoio',false);
            $this->view->idprofile = $id;
            $userinfo = $this->_userModel->mostrautente($id)->toArray();
            $this->view->interessi = $userinfo[0]["interessi"];
            $this->view->assign('nome', $userinfo[0]["Nome"]);
            $this->view->assign('cognome', $userinfo[0]["Cognome"]);
            $this->view->assign('eta', $userinfo[0]["eta"]);
            $this->view->assign('immagine', $userinfo[0]["immagine"]);


            if ($this->_userModel->sonoamici($id, $myid)) {
                $this->view->assign('amici', true);

            } else {
                $this->view->assign('amici', false);

            }

        }


    }

    public function updateajaxAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (isset($_POST["query"])){
            $user = $this->_userModel->cercautente($_POST["query"])->toArray();
            if ($user != null) {
                $this->getResponse()->setHeader('Content-type', 'application/json')->setBody(json_encode($user));

            }
        }
    }

    public function updateajaxblogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (isset($_POST["page"]) && isset($_POST["iduser"])) {


            $data = $this->_userModel->selezionatuttiblogvisibiliamediID(intval($_POST['iduser']));

            $adapter = new Zend_Paginator_Adapter_DbSelect($data);
            $paginator = new Zend_Paginator($adapter);

            $paginator->setItemCountPerPage(3);
            $paginator->setCurrentPageNumber(intval($_POST['page']));

            //il massimo numero di pagine
            $condition = (integer)ceil($paginator->getTotalItemCount() / $paginator->getItemCountPerPage());
            if ($paginator != null && ($condition >= $_POST['page'])) {
                $this->getResponse()->setHeader('Content-type', 'application/json')->setBody($paginator->toJson());
            }
        }
    }

    public function updateajaxpostAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (isset($_POST["page"]) && isset($_POST["idblog"])) {


            $data = $this->_userModel->selezionatuttipostdelblog(intval($_POST['idblog']));

            $adapter = new Zend_Paginator_Adapter_DbSelect($data);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(1);
            $paginator->setCurrentPageNumber(intval($_POST['page']));

            //il massimo numero di pagine
            $condition = (integer)ceil($paginator->getTotalItemCount() / $paginator->getItemCountPerPage());
            if ($paginator != null && ($condition >= $_POST['page'])) {
                $this->getResponse()->setHeader('Content-type', 'application/json')->setBody($paginator->toJson());
            }
        }
    }

    public function showblogAction()
    {

        $auth = Zend_Auth::getInstance();
        $myid = $auth->getIdentity()->id;
        $role = $auth->getIdentity()->ruolo;
        $id = $this->getParam('id');
        
        $idblog = $this->getParam('id_blog');
        $info = $this->_userModel->visualizzaBlogdaID($idblog)->toArray();
        $this->view->blogtitle = $info[0]['titolo'];
        $this->view->blogdescr = $info[0]['descrizione'];
        $this->view->idblog = $idblog;
        if ($role == 'admin' or $role == 'staff')
        {
            $this->view->assign('staff',true);

        }else
        {
            $this->view->assign('staff',false);
        }
        if (isset($_POST["id"])){$id = $_POST["id"];}else{ $id = $this->getParam('id');}





        if ($id == $myid) {
            $this->view->sonoio = true;
            $this->view->interessi = $auth->getIdentity()->interessi;
            $this->view->assign('nome', $auth->getIdentity()->Nome);
            $this->view->assign('cognome', $auth->getIdentity()->Cognome);
            $this->view->assign('eta', $auth->getIdentity()->eta);
            $this->view->assign('immagine', $auth->getIdentity()->immagine);

        } else {
            $this->view->sonoio = false;
            $this->view->idprofile = $id;
            $userinfo = $this->_userModel->mostrautente($id)->toArray();
            $this->view->interessi = $userinfo[0]["interessi"];
            $this->view->assign('nome', $userinfo[0]["Nome"]);
            $this->view->assign('cognome', $userinfo[0]["Cognome"]);
            $this->view->assign('eta', $userinfo[0]["eta"]);
            $this->view->assign('immagine', $userinfo[0]["immagine"]);


            if ($this->_userModel->sonoamici($id, $myid)) {
                $this->view->assign('amici', true);

            } else {
                $this->view->assign('amici', false);

            }

        }

    }
    
    //funzioni blog-----------------------------------------
    
    public function creablogAction() //ok funziona!
    {
        $form = new Application_Form_Utente_Blog_Crea();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_userModel->creaBlog($dati);
                echo 'Blog creato!';
            } else {
                echo 'Creazione blog fallita';
            }
        }
        $this->view->assign('form', $form);
    }

    public function cancellablogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $a = $this->getParam('id_blog');
        $info = $this->_userModel->visualizzaBlogdaID($a)->toArray();

        $this->_blogModel->cancellablog($a);
        $ruolo=Zend_Auth::getInstance()->getIdentity()->ruolo; //invia notifica se a cancellare è stato staff
        if($ruolo=='staff' or $ruolo=='admin')
        {
            $user = $info[0]['id_user'];
            $this->inviaNotificaAction($user,10,'Lo Staff ha cancellato un tuo Blog');

        }
        $this->redirect('user/showuserprofile/id/'.Zend_Auth::getInstance()->getIdentity()->id);


    }
    
    //funzioni post ----------------------------------
    public function modificapostAction()
    {
      

        $post = $this->_getParam('idpost');
        $form = new Application_Form_Utente_Blog_Posta();
        $gigi = $this->_blogModel->selezionapost($post)->toArray();
        var_dump($gigi);
        $idblog =$gigi[0]['blog_id'];

        $form->populate($gigi[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_blogModel->modpost($dati,$post);
                echo 'Dati inseriti con successo';
                $this->redirect('user/showblog/id/'.Zend_Auth::getInstance()->getIdentity()->id.'/id_blog/'.$idblog);

            } else {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }

    public function cancellapostAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $a = $this->getParam('id_post');
        $info = $this->_userModel->utentepostdaidpost($a);

        $this->_blogModel->cancellapost($a);
        $ruolo=Zend_Auth::getInstance()->getIdentity()->ruolo; //invia notifica se a cancellare è stato staff
        if($ruolo=='staff' or $ruolo=='admin')
        {
            $user = $info[0]['id_user'];
            $this->inviaNotificaAction($user,10,'Lo Staff ha cancellato un tuo Post');

        }
        $this->redirect('user/showuserprofile/id/'.Zend_Auth::getInstance()->getIdentity()->id);



    }

    public function updateajaxcommentAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (isset($_POST["idpost"])) {

            $data = $this->_userModel->selezionatutticommentipost(intval($_POST['idpost']))->toArray();



                $this->getResponse()->setHeader('Content-type', 'application/json')->setBody(json_encode($data));

        }
    }

	//funzioni amici

	public function gestisciamiciAction()
	{
		$id=Zend_Auth::getInstance()->getIdentity()->id;
        $amiciaccettati=$this->_userModel->mostraamici($id);
		$inattesa=$this->_userModel->mostrainattesa($id);
        $richieste=$this->_userModel->mostrainviate($id);
		$richiesteinattesa='';
		for($i=0;$i<sizeof($inattesa);$i++)
		{
			//idamico_a contiene l'id di chi ha FATTO la richiesta, ovvero di chi me l'ha inviata
			$id_inattesa=$inattesa[$i]['idamico_a'];
            var_dump($id_inattesa);
			$res =$this->_userModel->mostrautente($id_inattesa)->toArray();
            var_dump($res);
			$richiesteinattesa[$i]['mex']="".$res[0]['Nome']." ".$res[0]['Cognome']." ti ha inviato una richiesta di amicizia";
			$richiesteinattesa[$i]['id']=$id_inattesa;
            $richiesteinattesa[$i]['immagine']=$res[0]['immagine'];

		}
		$richiesteaccettate='';
		for($i=0;$i<sizeof($amiciaccettati);$i++)
		{
			if($id==$amiciaccettati[$i]['idamico_a']) //l'amico da visualizzare è l'altro
			{
				$id_accettato=$amiciaccettati[$i]['idamico_b'];
			}
			else
				$id_accettato=$amiciaccettati[$i]['idamico_a'];
			$res=$this->_userModel->mostrautente($id_accettato)->toArray();
			$richiesteaccettate[$i]['mex']="".$res[0]['Nome']." ".$res[0]['Cognome']."";
			$richiesteaccettate[$i]['id']=$id_accettato;
            $richiesteaccettate[$i]['immagine']=$res[0]['immagine'];
		}
        $richiesteinviate='';
        for($i=0;$i<=sizeof($richieste);$i++)
        {
            $id_richiesto=$richieste[$i]['idamico_b'];
            $res=$this->_userModel->mostrautente($id_richiesto)->toArray();
            $richiesteinviate[$i]['mex']="Hai inviato una richiesta a ".$res[0]['Nome']." ".$res[0]['Cognome']."";
            $richiesteinviate[$i]['id']=$id_richiesto;
            $richiesteinviate[$i]['immagine']=$res[0]['immagine'];
        }
		$this->view->assign('amici',$richiesteaccettate);
		$this->view->assign('inattesa',$richiesteinattesa);
        $this->view->assign('inviate',$richiesteinviate);
		$bottone=new Zend_Form_Element_Submit('accetta');
        $bottone->setLabel('Accetta');
        $this->view->assign('accettaamico',$bottone);
		$bottone=new Zend_Form_Element_Submit('elimina');
        $bottone->setLabel('Elimina');
        $this->view->assign('eliminaamico',$bottone);
		$bottone=new Zend_Form_Element_Submit('rifiuta');
        $bottone->setLabel('Rifiuta');
	}

	public function accettaamicoAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		$id=$this->getParam('id');
		$this->_userModel->accettarichiesta($id);
		$this->redirect('user/gestisciamici');
	}

	public function eliminaamicoAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		$id=$this->getParam('id');
		$this->_userModel->rimuoviamco($id);
		$this->redirect('user/gestisciamici');
	}

	public function cancellacommentoAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (isset($_POST["idcomment"])) {

            //verifica che il commento sia mio o che io sia staff o amministratore

            $data = $this->_userModel->proprietadelcommento(intval($_POST['idcommento']));

            if($data | (Zend_Auth::getInstance()->getIdentity()->ruolo == "admin") | (Zend_Auth::getInstance()->getIdentity()->ruolo == "staff")){

                $this->_userModel->eliminacommento(intval($_POST['idcomment']));
                $this->getResponse()->setHeader('Content-type', 'application/json')->setBody(json_encode("ok"));

            }
            //elimina il commento



        }
    }

}