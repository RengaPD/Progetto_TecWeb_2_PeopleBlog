<?php

class Application_Model_Staff extends App_Model_Abstract
{

	public function __construct()
	{

	}

    public function visualizzaBlog(){
        return $this->getResource('Blog')->showBlog();
    }

    public function eliminablog($id) {
    return $this->getResource('Blog')->deleteblog($id);
    }

    public function visualizzaBlogdaID($id){
        return $this->getResource('Blog')->getposts_byid($id);
    }

    public function modificapost($dati,$id){
        return $this->getResource('Blog')->editpostbystaff($dati,$id);
    }

    public function eliminapost($a) {
        return $this->getResource('Blog')->deletepost($a);
    }

}