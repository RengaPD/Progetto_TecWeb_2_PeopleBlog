<?php

class Application_Model_Blog extends App_Model_Abstract
{


    public function __construct()
    {

    }

    public function prendipost($id_user)
    {
        return $this->getResource('Blog')->getposts_byuser($id_user);
    }
    
    public function postasuBlog($dati)
    {
        return $this->getResource('Blog')->sendposts($dati);
    }
    
    public function modpost($dati,$a)
    {
        return $this->getResource('Blog')->editpost($dati,$a);
    }
    
    public function selezionapost($datetime)
    {
        return $this->getResource('Blog')->getbydatetime($datetime);
    }
    
    public function cancellapost($a)
    {
        return $this->getResource('Blog')->deletepost($a);
    }
    
   public function contablog()
   {
        $res=$this->getResource('Blog')->selblogs();
        return $conta=count($res);
   }
    
    public function commenta($dati,$id){
        return $this->getResource('Commenti')->sendcomment($dati,$id);
    }
    
    public function prendicommenti(){
        return $this->getResource('Commenti')->getcomments();
    }

    public function cancellacommento($id){
        return $this->getResource('Commenti')->deletecomment($id);
    }
}