<?php

class Application_Model_Blog extends App_Model_Abstract
{


    public function __construct()
    {

    }

    public function prendipost($id_user)
    {
        return $this->getResource('Blog')->getblog_byuser($id_user);
    }
    
    public function postasuBlog($dati)
    {
        return $this->getResource('Blog')->sendposts($dati);
    }
    
    public function modpost($dati,$a)
    {
        return $this->getResource('Post')->editpost($dati,$a);
    }
    public function modblog($dati,$a)
    {
        return $this->getResource('Blog')->editblog($dati,$a);
    }
    public function selezionapost($post)
    {
        return $this->getResource('Post')->getpostbyid($post);
    }
    
    public function cancellapost($a)
    {
        return $this->getResource('Post')->deletepost($a);
    }
    
    
    
   public function contablog()
   {
        return $this->getResource('Blog')->selectallblogs();
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

    public function cancellablog($id){
        return $this->getResource('Blog')->deleteblog($id);
    }

    //---------privacy
    public function prendiTuttiGliUtentiPrivacy($id){
        return $this->getResource('Privacy')->takeAllPrivacyUsers($id);
    }
    public function cancellaRegolaPrivacy($blog,$user){
        $this->getResource('Privacy')->deletePrivacyRule($blog,$user);
    }

    public function aggiungiRegolaPrivacy($blog,$user){
        $this->getResource('Privacy')->addPrivacyRule($blog,$user);
    }





}