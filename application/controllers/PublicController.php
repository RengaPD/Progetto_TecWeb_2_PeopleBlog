<?php

class PublicController extends Zend_Controller_Action
{
    protected $_publicModel;
    protected $_auth;
    protected $db;

    public function init()
    {
        $this->_helper->layout->setLayout('layout');
        $this->_logger = Zend_Registry::get('log');
        $this->_publicModel=new Application_Model_Public();
        $this->db=new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => 'localhost',
            'username' => 'admin',
            'password' => 'password',
            'dbname'   => 'tweb'
        ));
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
        
    }

    public function cercaUtenteAction(){

    }

    public function controllaemailAction($info){
        $a=new Application_Model_User();
        $email=$a->cercamail($info);
        return $email;
    }
    
}
