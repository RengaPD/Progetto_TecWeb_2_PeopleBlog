<?php
class PublicController extends Zend_Controller_Action
{
    protected $_userModel;
    protected $_authService;

    public function init()
    {
        $this->_userModel=new Application_Model_User();
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
        $a=$this->_authService->getIdentity()->Id;
        $form = new Application_Form_Utente_Modifica();
        $gigi=$this->_userModel->visualizzaUtentedaID($a)->toArray();
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

}