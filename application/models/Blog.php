<?php

class Application_Model_Blog extends App_Model_Abstract
{


    public function __construct()
    {

    }

    public function prendipost($nome,$cognome)
    {
        return $this->getResource('Blog')->getposts($nome,$cognome);
    }
    
    public function postasuBlog($dati)
    {
        return $this->getResource('Blog')->sendposts($dati);
    }
}