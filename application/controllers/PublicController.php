<?php

class PublicController extends Zend_Controller_Action
{
    protected $_publicModel;
    protected $_userModel;
    protected $_auth;
    protected $db;

    public function init()
    {
        $this->_helper->layout->setLayout('layout');
        $this->_logger = Zend_Registry::get('log');
        $this->_publicModel=new Application_Model_Public();
        $this->_userModel=new Application_Model_User();
        $this->_auth=new Application_Service_Auth();
    }

    public function indexAction()
    {
        $view = new Zend_View();
        $view->setScriptPath(VIEW_PATH);
        return $view->render('index.phtml');
    }

    public function viewstaticAction () {
        $page = $this->_getParam('staticPage');
        $this->render($page);
    }
    
    public function registratiAction() {
        $form=new Application_Form_Public_Registra();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST)) {
                $dati = $form->getValues();
                $mail=$form->getValue('email');
                $mailgiàpresente=$this->controllaemailAction($mail);
                if(!$mail==$mailgiàpresente)
                {
                    $this->_publicModel->registrati($dati);
                    echo 'Registrazione avvenuta!';
                }
                else{
                    echo 'Mail già in uso, inserirne una diversa';
                }

            }
            else
            {
                echo 'Qualcosa è andato storto';
            }
        }
        $this->view->assign('form', $form);
    }
    
    public function loginAction() {
        $form=new Application_Form_Public_Auth_Login();
        if($form->isValid($_POST))
        {
            $credenziali=$form->getValues();
            $this->_auth->autenticazione($credenziali);
            $this->redirect('index');
        }
        $this->view->assign('form',$form);
    }

    public function cercautenteAction(){
        $form=new Application_Form_Public_Cerca();
        if($form->isValid($_POST))
        {
            $info=$form->getValues();
            $res=$this->_userModel->cercaUtente($info)->toArray();
            if($res) //trovato, da espandere con amicizie ecc
            {
                $nome=$res[0]['Nome'];
                $cognome=$res[0]['Cognome'];
                $eta=$res[0]['eta'];
                $interessi=$res[0]['interessi'];
                $this->redirect('public/show/a/'.$nome.'/b/'.$cognome.'/c/'.$eta.'/d/'.$interessi);
            }
            else{
                echo 'Errore!';
            }
        }
        $this->view->assign('form',$form);
    }

    public function controllaemailAction($info){
        $a=new Application_Model_Admin();
        $email=$a->trovaEmailUtente($info);
        return $email;
    }

    public function showAction()
    {
        $nome=$this->getParam('a');
        $cognome=$this->getParam('b');
        $eta=$this->getParam('c');
        $interessi=$this->getParam('d');
        $this->view->assign('nome',$nome);
        $this->view->assign('cognome',$cognome);
        $this->view->assign('eta',$eta);
        $this->view->assign('interessi',$interessi);
    }


}
