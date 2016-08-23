<?php

class AdminController extends Zend_Controller_Action
{
    protected $_adminModel;
    protected $_blogModel;


    public function init()
    {
        $this->_helper->layout->setLayout('layoutadmin');
        $this->_adminModel = new Application_Model_Admin();
        $this->_blogModel=new Application_Model_Blog();
    }

    public function indexAction()
    {
        $this->contablog();

    }

    public function aggiungiutenteAction()
    {
        $form = new Application_Form_Amministrazione_Utente_Aggiungi();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                echo 'Dati inseriti con successo';
                $this->_adminModel->inserisciUtente($dati);
            }
            else
            {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }

    public function selezionaAction()
    {

        $result = $this->_adminModel->visualizzaUtente()->toArray();
        $this->view->assign('risultato', $result);
        $bottone=new Zend_Form_Element_Submit('modifica');
        $bottone->setLabel('Modifica');
        $this->view->assign('bottonemod',$bottone);
        $bottone=new Zend_Form_Element_Submit('cancella');
        $bottone->setLabel('Cancella');
        $this->view->assign('bottonedel',$bottone);


    }
    public function modificautenteAction() //non popola tutta la form?
    {

        $a=$this->_getParam('id');
        $form = new Application_Form_Amministrazione_Utente_Modifica();
        $gigi=$this->_adminModel->visualizzaUtentedaID($a)->toArray();
        $form->populate($gigi[0]);
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $dati= $form->getValues();
                echo 'Dati inseriti con successo';
                $this->_adminModel->modificautente($dati,$a);
            }
            else
            {
                echo 'Inserimento fallito';
            }
        }
        $this->view->assign('form', $form);
    }



    public function cancellautenteAction() //funziona
    {
        $a=$this->getParam('id');
        $this->_adminModel->eliminaUtente($a);

    }
    
    public function contablog()
    {
        $num=$this->_blogModel->contablog();
        $this->view->assign('numeroblog',$num);
    }
}