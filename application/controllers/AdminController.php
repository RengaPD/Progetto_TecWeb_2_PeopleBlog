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
        $this->contablogAction();

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
        $bottone=new Zend_Form_Element_Submit('amici');
        $bottone->setLabel('Amici');
        $this->view->assign('bottoneamici',$bottone);
        $bottone=new Zend_Form_Element_Submit('richieste');
        $bottone->setLabel('Richieste');
        $this->view->assign('bottonerichieste',$bottone);


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
    
    public function contablogAction()
    {
        $num=$this->_blogModel->contablog();
        $this->view->assign('numeroblog',$num);
    }
    
    public function visualizzaamiciAction()
    {
        $a=$this->getParam('id');
        $res=$this->_adminModel->visualizzaAmici($a);

        $amici[]='';
        for($i=0;$i<sizeof($res);$i++) { //esegue solo prima iterazione. Perchè???
            if($a==$res[$i]['idamico_b']) //voglio vedere gli amici DI b quindi prendo a
            {
                $idamico=$res[$i]['idamico_a'];
                $nome=$this->_adminModel->visualizzaUtentedaID($idamico)->toArray();
                $amici[$i]=$nome[0]['Nome'].' '.$nome[0]['Cognome'];

            }
            else if($a==$res[$i]['idamico_a']) //viceversa
            {
                $idamico=$res[$i]['idamico_b'];
                $nome=$this->_adminModel->visualizzaUtentedaID($idamico)->toArray();
                $amici[$i]=$nome[0]['Nome'].' '.$nome[0]['Cognome'];
            }
            else {
                echo 'Nessun amico trovato';
            }
        }
        $this->view->assign('amici',$amici);
        
    }
    
    public function visualizzarichiesteAction(){
        $a=$this->getParam('id');
        $res=$this->_adminModel->visualizzaRichieste($a);
        $richieste[]='';
        for($i=0;$i<sizeof($res);$i++){
            $idamicoa=$res[$i]['idamico_a'];
            $nome_a=$this->_adminModel->visualizzaUtentedaID($idamicoa)->toArray();
            $pa=$nome_a[0]['Nome'].' '.$nome_a[0]['Cognome'];
            $idamicob=$res[$i]['idamico_b'];
            $nome_b=$this->_adminModel->visualizzaUtentedaID($idamicob)->toArray();
            $pb=$nome_b[0]['Nome'].' '.$nome_b[0]['Cognome'];
            if($res[$i]['state']=='accepted')
            {
                $richieste[$i]=''.$pa.'  è amico di '.$pb.'';
            }
            else if($res[$i]['state']=='refused')
            {
                $richieste[$i]=''.$pa.' ha rifiutato una richiesta di amicizia  da '.$pb.'';
            }
            else
            {
                $richieste[$i]=''.$pa.' sta aspettando conferma della sua richiesta da '.$pb.'';
            }

        }
            $this->view->assign('richieste',$richieste);
    }
}