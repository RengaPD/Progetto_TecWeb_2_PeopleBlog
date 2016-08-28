$(document).ready(function () {

    
    $('#invia-btn').click(function () {
       var _testo=$('#comment-post-text').val();
        var _userId=$('#user-id').val();
        var _username=$('#username').val();
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var url=baseUrl + "/public/ajax/inserisci.php";
        console.log(url);
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
                    comment : _testo
                },
                success: function(data)
                {
                    console.log("ResponseText " + data);
                    inserisci(jQuery.parseJSON(data));

                },
                error: function()
                {
                    console.log("Error");
                }
            });

            /*$.post(url,
                {
                    task: "inserisci_commento",
                    userId: _userId,
                    comment: _testo
                }
            ).success(
                    function (data) {
                        inserisci_commento(jQuery.parseJSON(data));
                        console.log("Response: "+data);

                    }
                ).error(
                    function(){
                        console.log("Error");
                    }

                );*/

            console.log(_testo+" "+_userId+" "+_username+"");

        }
        else{
            $('.comment-insert-container').css('border','1px solid red');
            console.log("Area vuota!");
        }
        $('#comment-post-text').val(""); //risvuota dopo aver cliccato!
    });

    }
);
