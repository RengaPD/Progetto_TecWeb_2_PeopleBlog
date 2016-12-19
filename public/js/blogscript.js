

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
        $.ajax({
            type: 'POST',
            url: linkforupdateajax,
            async:false,
            dataType: "json",
            data: { page: track_page, iduser: iduser},

            success: function(data)
            {

                caricamento = false;
                if(data.length <= 2) {
                    //se non carica niente
                    return;
                }

                
                for (i = 0; i <= [Object.keys(data).length - 1]; i++)
                {
                    
                    //se sto vedendo il mio profilo aggiungo i bottoni di gestione
                    var appendbuttons = '';
                    if(staff)
                    {
                        
                        appendbuttons =' <a href="'+ linkdel + data[i].idblog +'">Elimina</a> </div> </div>';
                    }
                    if(sonoio)
                    {
                        appendbuttons =' <a href="'+ linksetp + data[i].idblog +'">Gestisci Privacy</a> <a href="'+ linkdel + data[i].idblog +'">Elimina</a> </div> </div>';

                    }


                    $("#results").append('<div class="panel marRight30">    <div class="content"> <h3><span>' +
                        data[i].titolo + '</span></h3> <p><span>' +
                        data[i].datetime.substring(0, (data[i].datetime.length - 10)) + '</span></p>' +
                        '<p>' + data[i].descrizione + '</p> ' +
                        '<a href="'+ linkshow + data[i].idblog +'">Visita blog</a>'+ appendbuttons);
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



