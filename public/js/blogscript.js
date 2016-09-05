

var track_page = 1; //la track page è inizializzata a 1;
var caricamento  = false; //previene caricamenti multipli

load_contents(track_page); //primo caricamento

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
        $('.loading-info').show();
        $.ajax({
            type: 'POST',
            url: link,
            async:false,
            dataType: "json",
            data: { page: track_page,id: iduser},

            success: function(data)
            {

                caricamento = false;
                if(data.length <= 2) {
                    //se non carica niente
                    $('.loading-info').html("Nulla da caricare!");
                    return;
                }




                console.log(data);


                $('.loading-info').hide();                    //nasconde l'animazione---da rimuovere se non lo finisco

                console.log(Object.keys(data));
                console.log(iduser);

                for (i = 0; i <= [Object.keys(data).length - 1]; i++)
                {
                    //se sto vedendo il mio profilo aggiungo i bottoni di gestione
                    var appendbuttons = '';
                    if(iduser=='my'){appendbuttons =' <a href="#">Gestisci Privacy</a> <a href="#">Elimina</a> </div> </div>';}


                    $("#results").append('<div class="panel marRight30">    <div class="content"> <h3><span>' +
                        data[i].titolo + '</span></h3> <p><span>' +
                        data[i].datetime.substring(0, (data[i].datetime.length - 10)) + '</span></p>' +
                        '<p>' + data[i].descrizione + '</p> ' +
                        '<a href="#">Visita blog</a>'+ appendbuttons);
                }
            },
            fail: function(xhr, ajaxOptions, thrownError)
            { 
                console.log(thrownError);
                alert(thrownError);
            }

        })
    }
}



