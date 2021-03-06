<?php
class BlogController extends Zend_Controller_Action
{
    protected $_blogModel;
    protected $_adminModel;
    protected $_userModel;
    protected $_authService;
    protected $nome;
    protected $cognome;

    public function init() //ok
    {
        $this->_blogModel = new Application_Model_Blog();
        $this->_userModel = new Application_Model_User();
        $this->_adminModel = new Application_Model_Admin();
        $this->_helper->layout->setLayout('layoutblog');
        $this->_authService = new Application_Service_Auth();
        $info = Zend_Auth::getInstance();
        $this->_nome = $info->getIdentity()->Nome;
        $this->_cognome = $info->getIdentity()->Cognome;
    }

    public function indexAction() //ok
    {
        $info = Zend_Auth::getInstance();
        $id_user = $info->getIdentity()->id;
        $this->prendipostAction($id_user);
        $this->prendicommentiAction();
        $this->prendiuserpicAction();
        $infouser = $this->_adminModel->visualizzaUtentedaID($id_user);
        $this->view->assign('nomeuser', $infouser[0]['Nome']);
        $this->view->assign('cognomeuser', $infouser[0]['Cognome']);
        $bottone = new Zend_Form_Element_Submit('modifica');
        $bottone->setLabel('Modifica');
        $this->view->assign('bottonemod', $bottone);
        $bottone = new Zend_Form_Element_Submit('cancella');
        $bottone->setLabel('Cancella');
        $this->view->assign('bottonedel', $bottone);
    }

    public function prendipostAction($id_user) //li ordina per data, l'elemento all'indice 0 sarà per forza
        //il primo post inviato sul blog con il titolo giusto.
    {
        $posts = $this->_blogModel->prendipost($id_user)->toArray();
        $this->view->assign('posts', $posts);
        Zend_Layout::getMvcInstance()->assign('titoloblog', $posts[0]['titoloblog']);
    }

    public function cancellablogAction(){
        $id=$this->getParam('id');
        $this->_blogModel->cancellablog($id);
        $this->_userModel->setblogfalse();
    }

    public function creapostAction() //deve riusare sempre stesso titolo specificato dal primo post
        //(vabbè che prende comunque il titolo specificato nel primo post fatto quindi...)
    {
        $form = new Application_Form_Utente_Blog_Posta();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_blogModel->postasuBlog($dati);
                echo 'Fatto!';
            } else {
                echo 'Errore nel post, riprova';
            }
        }
        $this->view->assign('form', $form);

    }

    public function modificapostAction()
    {
        $idblog = $this->_getParam('idblog');
        $post = $this->_getParam('idpost');
        $form = new Application_Form_Utente_Blog_Posta();
        $gigi = $this->_blogModel->selezionapost($post)->toArray();
        $form->populate($gigi[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $dati = $form->getValues();
                $this->_blogModel->modpost($dati, $post);
                echo 'Dati inseriti con successo';
                $this->redirect('user/showblog/id_blog/'.$idblog);

            } else {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }


    public function inviaNotificaAction($id_destinatario,$tipologia,$testo){ //ok
        $this->_userModel->inviaNotifica($id_destinatario,$tipologia,$testo);
    }
    
    public function prendiuserpicAction(){
        $immagini=$this->_adminModel->visualizzaUtente()->toArray();
        $this->view->assign('img',$immagini);
    }
}

