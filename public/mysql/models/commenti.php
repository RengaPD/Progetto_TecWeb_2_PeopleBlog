<?php

/**
 * Created by PhpStorm.
 * User: Sara
 * Date: 28/08/2016
 * Time: 14:15
 */
class Commenti
{

    public static function getComments(){

    }

    //return a stdClass objiect dal db
    public static function insert($comment_txt,$userid){

        $std= new stdClass();
        $std->commentId=null;
        $std->userId=(int)$userid;
        $std->comment=$comment_txt;
        return $std;

    }

    public static function update($comment_txt,$userid){

    }

    public static function delete($commentId){
        
    }
}