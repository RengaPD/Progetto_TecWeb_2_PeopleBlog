

/*----------------------
 Vi sono due funzioni principali piú una ch parte a documento pronto

 load_contents carica i post allo scrolling della pagina, é praticamente identica alla funzione per caricare i blog
 se non per il fatto che carica per ogni elemento la funzione load_comments passandole l'id del post chiamante.

 la funzione loadcomments effettua una ulteriore chiamata ajax che permette di visualizzare i commenti per ogni post

 bisogne implementare una funzione che permetta di cancellare i commenti;
 tale funzione deve prendere dall'attributo commentlink (linea 107) l'id del commento da cancellare
 e al click deve avviare un akax per la cancellazione del commento, poi refreshare la pagina, eventualmente riportandola al
 punto dove stava

 l'ultima funzione é quella che permette la cancellazione del post

 bisogna creare una ulteriore funzione che si lega a tutte le box di inserimento di testo per commento che sono nella pagina e
 che prendendo il contenuto del box e l'id del post a cui appartiene(ispirandosi alla funzione che cancella i post)
 permetta di commentare gestendo anche il fatto che poi il commento deve essere visualizzato
 alla piú facile con un refresh

 -----------------------*/



var track_page = 1; //la track page è inizializzata a 1;
var caricamento  = false; //previene caricamenti multipli su load_contents
var cari=false; //previene caricamenti multipli su load_comments
var deletion = false;
var doneloadingcomments = false;

load_contents(track_page); //primo caricamento


function load_comments(id_post, lastcomment )
{


    while(!doneloadingcomments)
    {
        doneloadingcomments = true;
        if (cari == false) {



            cari = true;



            $.ajax({
                type: 'POST',
                url: linkforupdateajaxcomments,
                async: false,
                dataType: "json",
                data: {idpost: id_post },

                success: function (data) {

                    cari = false;
                    if (data.length == 0) {
                        //se non carica niente
                        return;
                    }
                    console.log("i dati:");

                    console.log(data);



                    for (i = 0; i <= [Object.keys(data).length - 1]; i++)
                    {



                        var divcommentli = document.createElement('li');
                        divcommentli.setAttribute('class','comment-holder');
                        divcommentli.setAttribute('commentid',data[i].comment_id);//necessario per la delete
                        divcommentli.setAttribute('idpost',data[i].post_id);//necessario per la delete




                        var divuserimg = document.createElement('img');
                        divuserimg.setAttribute('class','user-img');
                        divuserimg.setAttribute('src',linkimg + data[i].immagine);

                        var divcommentbody = document.createElement('div');
                        divcommentbody.setAttribute('class','comment-body');

                        var commentuser = document.createElement('H3');
                        commentuser.setAttribute('class','username-field');

                        var commentusert = document.createTextNode(data[i].Nome +' '+ data[i].Cognome);

                        var divcommenttext = document.createElement('div');
                        divcommenttext.setAttribute('class','comment-text');

                        var commentt = document.createTextNode(data[i].comment);

                        var divcommentbutthold = document.createElement('div');
                        divcommentbutthold.setAttribute('class','comment-buttons-holder');

                        var ulcommentbutthold = document.createElement('ul');

                        var licommentbutthold = document.createElement('li');
                        licommentbutthold.setAttribute('class','delete-button');

                        var deletebutton = document.createElement('a');
                        deletebutton.setAttribute('class','deletebutton');
                        deletebutton.setAttribute('commentlink',linkdeletecomment + data[i].comment_id);
                        deletebutton.setAttribute('commentid',data[i].comment_id);
                        deletebutton.setAttribute('commentpost',id_post);

                        deletebutton.setAttribute('lastcomment',lastcomment);

                        var deletebutt = document.createTextNode("x");







                        divcommentli.appendChild(divuserimg);

                        commentuser.appendChild(commentusert);
                        divcommentbody.appendChild(commentuser);

                        divcommenttext.appendChild(commentt);
                        divcommentbody.appendChild(divcommenttext);


                        if(sonoio || staff)
                        {

                            deletebutton.appendChild(deletebutt);
                            licommentbutthold.appendChild(deletebutton);
                            ulcommentbutthold.appendChild(licommentbutthold);
                            divcommentbutthold.appendChild(ulcommentbutthold);
                            divcommentbody.appendChild(divcommentbutthold);

                        }

                        divcommentli.appendChild(divcommentbody);

                        console.log("appendo il commento al post:"+data[i].post_id);
                        //ficca i dati dopo l'elemento ul della sezione commenti del post
                        $("#"+ data[i].post_id).append(divcommentli);
                    }



                },
                fail: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                    alert(thrownError);
                },
                complete:function (xhr, status) {
                    console.log("ajax Commentreader complete");


                },
                error: function( jqXHR,  textStatus,  errorThrown) {
                    console.log(errorThrown);
                    console.log(jqXHR);

                    alert("ajax CommentReader error");
                }

            })

        }

    }
}



$(window).scroll(function() { //in caso di scroll della pagina riaziona il caricamento
    if($(window).scrollTop() + $(window).height() >= $('.primary-content').height() ) { //if user scrolled to bottom of the page


        track_page++; //con un numero di pagina successivo

        load_contents(track_page);
    }
});



//funzione di caricamento dati
function load_contents(track_page)
{
    if(caricamento == false){


        caricamento = true;
        $.ajax({
            type: 'POST',
            url: linkforupdateajax,
            async:false,
            dataType: "json",
            data: { page: track_page, idblog: idblog},

            success: function(data)
            {

                caricamento = false;
                if(data.length <= 2) {
                    //se non carica niente
                    return;
                }

                console.log(data);

                console.log('idblog = '+ idblog);
                for (i = 0; i <= [Object.keys(data).length - 1]; i++)
                {




                    var div = document.createElement('div');
                    div.setAttribute('class','panel wid90');
                    var innerdiv = document.createElement('div');
                    innerdiv.setAttribute('class','content');
                    var titoloh = document.createElement('H3');
                    var spantitolo = document.createElement('span');
                    var spandatetime = document.createElement('span');
                    var pdatetime = document.createElement('p');
                    var pcontent = document.createElement('p');
                    var titolo = document.createTextNode(data[i].title);
                    var datetime = document.createTextNode(data[i].datetime.substring(0, (data[i].datetime.length - 10)));
                    var content = document.createTextNode(data[i].content);
                    var eliminabutton = document.createElement('a');
                    eliminabutton.setAttribute('href',linkdel + data[i].id);
                    var modificabutton = document.createElement('a');
                    modificabutton.setAttribute('href',linkmodif + data[i].id);
                    var modifbutt = document.createTextNode("Modifica");
                    var elimbutt = document.createTextNode("Elimina");
                    modificabutton.appendChild(modifbutt);
                    eliminabutton.appendChild(elimbutt);


                    var divcommentwrap = document.createElement('div');
                    divcommentwrap.setAttribute('class','comment-wrapper');

                    divcommentwrap.setAttribute('postid',data[i].id);

                    var commentinsert = document.createElement('H3');
                    commentinsert.setAttribute('class','chi');
                    var commentitlet = document.createTextNode("Commenti");

                    var divcommentinsert = document.createElement('div');
                    divcommentinsert.setAttribute('class','comment-insert');
                    var commenttextarea = document.createElement('textarea');
                    commenttextarea.setAttribute('class','comment-insert-text');
                    commenttextarea.setAttribute('placeholder','Commenta...');
                    var commentbutton = document.createElement('a');
                    commentbutton.setAttribute('class','buttonsend');

                    var commentbutt = document.createTextNode("Commenta");


                    var divcommentlist = document.createElement('div');
                    divcommentlist.setAttribute('class','comments-list');

                    var divcommentholder = document.createElement('ul');
                    divcommentholder.setAttribute('id', data[i].id);
                    divcommentholder.setAttribute('class','comments-holder');





                    spantitolo.appendChild(titolo);
                    spandatetime.appendChild(datetime);
                    pcontent.appendChild(content);
                    pdatetime.appendChild(spandatetime);
                    titoloh.appendChild(spantitolo);
                    innerdiv.appendChild(titoloh);//
                    innerdiv.appendChild(pdatetime);
                    innerdiv.appendChild(pcontent);

                    if(staff || sonoio)
                    {
                        innerdiv.appendChild(eliminabutton);
                    }
                    if(sonoio)
                    {
                        innerdiv.appendChild(modificabutton);
                    }

                    commentbutton.appendChild(commentbutt);
                    commentinsert.appendChild(commentitlet);

                    divcommentlist.appendChild(divcommentholder);
                    divcommentwrap.appendChild(commentinsert);
                    divcommentwrap.appendChild(divcommentlist);

                    divcommentinsert.appendChild(commenttextarea);
                    divcommentinsert.appendChild(commentbutton);
                    divcommentwrap.appendChild(divcommentinsert);
                    innerdiv.appendChild(divcommentwrap);


                    div.appendChild(innerdiv);

                    $("#results").append(div);
                    console.log("continuing with "+ data[i].id);

                    load_comments(data[i].id,1);

                }
            },
            fail: function(xhr, ajaxOptions, thrownError)
            {
                console.log(thrownError);
                alert(thrownError);
            }

        })

    }
}//gli passo l'id del post, il numero dell'ultimo commento e un parametro, se il parametro è false
$(document).ready(

    function() {
        $('.deletebutton').click(function () {
            var linkdelete = $(this).attr("commentlink");
            var commentid = $(this).attr("commentid");
            $.ajax({
                type: 'POST',
                url: linkdelete,
                async: false,
                dataType: "json",
                data: {idcomment: commentid },

                success: function (data) {

                    alert("Commento Cancellato");

                    console.log(data);
                    $("li[commentid=" + commentid + "]").hide();
                },
                fail: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                    alert(thrownError);
                },
                complete: function (data,status) {
                    deletion = true;
                  //  alert("complete commentdel");

                },
                error: function( jqXHR,  textStatus,  errorThrown) {
                    console.log(errorThrown);
                    console.log(jqXHR);

                    alert("ajax commentdel error");
                }

            })

        });



    });
$(document).ready(

    function() {
        $('.buttonsend').click(function () {

            var postid = $(this).closest('.comment-wrapper').attr("postid");
            var comment = $(this).siblings('textarea').val();
            console.log(postid);

            $.ajax({
                type: 'POST',
                url: linkcomment,
                async: false,
                dataType: "json",
                data: {comment: comment, idpost: postid },

                success: function (data) {

                   // alert("succeded commentwrite");

                  //  console.log(data);
                    location.reload();


                },
                fail: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                    alert(thrownError);
                },
                complete: function (data,status) {
                    deletion = true;
                  //  alert("complete commentwrite");

                },
                error: function( jqXHR,  textStatus,  errorThrown) {
                    console.log(errorThrown);
                    console.log(jqXHR);

                    alert("ajax commentwrite error");
                }

            })

        });



    });

