$(document).ready(function () {


    $('#invia-btn').click(function () {
       comment_post_click();
    });


});

function comment_post_click(){

    var _testo=$('#comment-post-text').val();
    var _userId=$('#user-id').val();
    var _username=$('#username').val();
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var url=baseUrl + "/public/ajax/inserisci.php";
    if(_testo.length>0&&!_userId==0) //solo utenti loggati, quindi che hanno un userid!
    {
        //invia effettivamente, altrimenti non c'è bisogno
        $('.comment-insert-container').css('border','1px solid #e1e1e1'); //rimette colore originario

        $.ajax({
            type: "POST",
            url: url,
            data: {
                task : "inserisci",
                userId : _userId,
                username: _username,
                comment : _testo
            },
            success: function(data)
            {
                inserisci_commento(data);
                console.log("Risposta da file php: "+data+"");
            },
            error: function()
            {
                console.log("Error");
            }
        });

    }
    else{
        $('.comment-insert-container').css('border','1px solid red');
        console.log("Area vuota!");
    }
    $('#comment-post-text').val(""); //risvuota dopo aver cliccato!
}

function inserisci_commento(_username,_testo)
{
    var t='';
    t+='<li class="comment-holder" id="1">';
    t+='<div class="user-img"><img src="images/img2.jpg" class="user-imgpic"/></div>';
    t+='<div class="comment-body">';
    t+='<h3 class="username-field">'+_username+'</h3>';
    t+='<div class="comment-text">'+_testo+'</div>';
    t+='</div>';
    t+='<div class="comment-buttons-holder">';
    t+='<ul>';
    t+='<li class="delete-button">';
    t+='X';
    t+='</li>';
    t+='</ul>';
    t+='</div>';
    t+='</li>';
    $('ul.comments-holder').prepend(t);
}