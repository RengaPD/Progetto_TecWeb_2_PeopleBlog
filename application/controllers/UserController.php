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
    {}

    public function logoutAction()
    {
        $this->_authService->clear();
        return $this->_helper->redirector('index','public');
    }
    public function modificaprofiloAction()
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
                echo 'Dati inseriti con successo';
                $this->_userModel->modificaProfilo($dati,$a);
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
    
}