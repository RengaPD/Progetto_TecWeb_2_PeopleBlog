<?php
class BlogController extends Zend_Controller_Action
{
    protected $_blogModel;
    protected $_authService;
    protected $nome;
    protected $cognome;

    public function init()
    {
        $this->_blogModel=new Application_Model_Blog();
        $this->_helper->layout->setLayout('layoutblog');
        $this->_authService = new Application_Service_Auth();
        $info=Zend_Auth::getInstance();
        $this->_nome=$info->getIdentity()->Nome;
        $this->_cognome=$info->getIdentity()->Cognome;
    }

    public function indexAction()
    {
        $info=Zend_Auth::getInstance();
        $nome=$info->getIdentity()->Nome;
        $cognome=$info->getIdentity()->Cognome;
        $this->prendipostAction($nome,$cognome);
        $bottone=new Zend_Form_Element_Submit('modifica');
        $bottone->setLabel('Modifica');
        $this->view->assign('bottonemod',$bottone);
        $bottone=new Zend_Form_Element_Submit('cancella');
        $bottone->setLabel('Cancella');
        $this->view->assign('bottonedel',$bottone);
    }
    
    public function prendipostAction($nome,$cognome) //li ordina per data, l'elemento all'indice 0 sarà per forza
        //il primo post inviato sul blog con il titolo giusto.
    {
        $posts=$this->_blogModel->prendipost($nome,$cognome)->toArray();
        $this->view->assign('posts',$posts);
        Zend_Layout::getMvcInstance()->assign('titoloblog',$posts[0]['titoloblog']);
    }

    public function creapostAction() //deve riusare sempre stesso titolo specificato dal primo post
        //(vabbè che prende comunque il titolo specificato nel primo post fatto quindi...)
    {
        $form=new Application_Form_Utente_Blog_Posta();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_blogModel->postasuBlog($dati);
                echo 'Fatto!';
            }
            else
            {
                echo 'Errore nel post, riprova';
            }
        }
        $this->view->assign('form', $form);
        
    }

    public function modificapostAction()
    {
        $a=$this->_getParam('a');
        $form=new Application_Form_Utente_Blog_Posta();
        $gigi=$this->_blogModel->selezionapost($a)->toArray();
        $form->populate($gigi[0]);
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                $this->_blogModel->modpost($dati,$a); 
                echo 'Dati inseriti con successo';
            }
            else
            {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }
    
    public function cancellapostAction()
    {
        $a=$this->getParam('a');
        $this->_blogModel->cancellapost($a);
    }

    
}

