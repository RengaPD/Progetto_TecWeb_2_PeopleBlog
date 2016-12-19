<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLogging()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        Zend_Registry::set('log', $logger);

        $this->_logger = $logger;
        $this->_logger->info('Bootstrap ' . __METHOD__);
    }

    protected function _initDefaultModuleAutoloader()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('App_');
        $this->getResourceLoader()
            ->addResourceType('modelResource','models/resources','Resource');
    }
    protected function _initFrontControllerPlugin()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new App_Controller_Plugin_Acl());
    }
    protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }
/*
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        // but what you really want is
        $view->headTitle('My title');
    }

*/
    protected function _initViewSettings()
    {
        $this->bootstrap('view');
        //$this->_view = $this->getResource('View');
        $view = $this->getResource('view');
        $view->doctype('HTML5');

        // Setto il separatore tra il nome del sito e il nome della pagina
        $view->headTitle('PeopleBlog')
            ->setSeparator(' | ');

        // Setto il foglio di stile
        $view->headLink()->prependStylesheet($view->baseUrl('/css/style.css'));
        $view->headLink()->prependStylesheet('http://fonts.googleapis.com/css?family=Droid+Sans:400,700');
        $view->headLink()->prependStylesheet($view->baseUrl('/js/jquery-ui.min.css'));

        // Setto i metadati
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');

        //Setto gli script js
        //Uso il prepend negli script principali in ordine inverso poiché faccio prepend, anche se trovo questa cosa assurda

        $view->headScript()->prependFile($view->baseUrl("/js/jquery.redirect.js"));
        $view->headScript()->prependFile($view->baseUrl("/js/jquery-ui.min.js"));
        $view->headScript()->prependFile($view->baseUrl("/js/jquery.js"));

        //uso l'append per searchscript per poter usare le variabili definite nella view
        $view->headScript()->appendFile($view->baseUrl("/js/searchscript.js"));



    }



    protected function _initDbParms()
    {
        include_once(APPLICATION_PATH . '/../../include/connect.php');
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host' => $HOST,
            'username' => $USER,
            'password' => $PASSWORD,
            'dbname' => $DB
        ));
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }


}

