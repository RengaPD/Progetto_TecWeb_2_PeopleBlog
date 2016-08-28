<?php
    if(isset($_POST['task'])&&$_POST['task']=='inserisci') //se è effettivamente quella
    {
        $userId=(int)$_POST['userId'];
        $comment=addslashes(str_replace("\n","<br>",$_POST['comment']));
        $username=addslashes($_POST['username']);
        $std=new stdClass();
        $std->commentId=24;
        $std->userId=$userId;
        $std->username=$username;
        $std->comment=$comment;
        $std->image_pic='images/img2.jpg';


        //require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'mysql'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'commenti.php';
        //require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'mysql'.DIRECTORY_SEPARATOR.'db_connect.php';
        if(class_exists('Commenti')){

            $commentinfo=Commenti::insert($comment_txt,$userid);
            if($commentinfo!=null){

            }
        }
        echo json_encode($std);


    }else{
        header('location: /');
    }

?>