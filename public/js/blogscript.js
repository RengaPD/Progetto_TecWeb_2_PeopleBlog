

var track_page = 1; //track user scroll as page number, right now page number is 1
var loading  = false; //prevents multiple loads
var informations;
var stop_page = 1;
var donefirst = false;
load_contents(track_page); //initial content load

$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() >= $('.primary-content').height() && donefirst) { //if user scrolled to bottom of the page
        console.log("prima dell'increm"+track_page);

        track_page++; //page number increment
        console.log("dopo dell'increm"+track_page);

        load_contents(track_page); //load content
    }
});
//Ajax load function
function load_contents(track_page){
    console.log("avviato loadcontents con trak="+track_page+" stop page="+stop_page);
    var condition = (stop_page >= track_page);
    if(loading == false && condition){

        console.log("iterazione"+track_page+"stop page="+stop_page);
        loading = true;  //set loading flag on
        $('.loading-info').show(); //show loading animation
        $.ajax({
            type: 'POST',
            url: link,
            dataType: "json",
            data: { page: track_page },

            success: function(data){

                donefirst = true;
                stop_page = data["maxpage"];
                console.log("ho settato stoppage "+stop_page);

                loading = false; //set loading flag off once the content is loaded
                if(data.length <= 2) {
                    //notify user if nothing to load
                    $('.loading-info').html("No more records!");
                    return;
                }






                $('.loading-info').hide();
                console.log(Object.keys(data));

                for (i = 0; i <= [Object.keys(data).length - 2]; i++)
                {
                    //hide loading animation once data is received
                    $("#results").append('<div class="panel marRight30">    <div class="content"> <h3><span>' +
                        data[i].titolo + '</span></h3> <p><span>' +
                        data[i].datetime.substring(0, (data[i].datetime.length - 10)) + '</span></p>' +
                        '<p>' + data[i].descrizione + '</p> ' +
                        '<a href="#">Visita blog</a><a href="#">Gestisci Privacy</a><a href="#">Elimina</a> </div> </div>'); //append data into #results element
                }
            },
            fail: function(xhr, ajaxOptions, thrownError)
            { //any errors?
                console.log(thrownError);
                alert(thrownError); //alert with HTTP error
            }

        })
    }
}



