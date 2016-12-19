/**
 * Created by francescomariafalini on 12/12/16.
 */
/**
 * Created by renga on 03/09/16.
 */



$(document).ready(function () {
    $("#privacybox").autocomplete({
        source: function (request, response) {

            // if(request.term.endsWith("*")){
            //  request.term.substring(0, request.length - 1);}
            console.log(request.term);
            console.log(urlajax);
            $.ajax({
                type: 'POST',
                url: urlAjaxSearchPrivacy,
                dataType: "json",
                data: {query: request.term},
                success: function (data) {
                    //alert("ajax searchprivacy succeded");
//                    console.log("succeded ajax response");
// per gestire il risultato nullo
                    response(data.length === 1 && data[0].length === 0 ? [] : data);
                },
                fail: function() {
                    alert("ajax searchprivacy failed");
                },
                error: function( jqXHR,  textStatus,  errorThrown) {
                    console.log(errorThrown);
                    	alert("ajax  searchprivacy error");
                }
            });


        },
        minLength: 2,
        focus: function (event, ui) {
            $("#searchbox").val(ui.item.Nome + " " + ui.item.Cognome);
            return false;
        },
        select: function (event, ui) {
            console.log(ui.item.id);


//INVIA L'ID DELL'UTENTE SELEZIONATO ALLA AGGIUNGIPRIVACYRULE

            $.ajax({
                type: 'POST',
                url: urlAjaxAddRule,
                dataType: "json",
                data: {user: ui.item.id ,blogid: idblog},
                success: function (data) {
                    alert("ajax addrule succeded");

                    // per gestire il risultato nullo
                    if (data.length == 0) {
                        //se non carica niente
                        return;
                    }
                    console.log("i dati di ajax addrule:");

                    console.log(data);

                        //qui ci va il jqueri che aggiunge l'utente

                        var userPrivacyBox = document.createElement('div');
                        userPrivacyBox.setAttribute('class','comment-text');
                        userPrivacyBox.setAttribute('user', ui.item.id);


                    var userNamePrivacy = document.createElement('H3');
                        userNamePrivacy.setAttribute('class', 'username-field');

                        var userNamePrivacyT = document.createTextNode(ui.item.Nome + ' ' + ui.item.Cognome);

                    var divcommentbutthold = document.createElement('div');
                    divcommentbutthold.setAttribute('class','comment-buttons-holder');

                    var ulcommentbutthold = document.createElement('ul');

                    var licommentbutthold = document.createElement('li');
                    licommentbutthold.setAttribute('class','delete-button');

                    var deletebutton = document.createElement('a');
                    deletebutton.setAttribute('class','deletebutton');
                    deletebutton.setAttribute('user',ui.item.id);

                    var deletebutt = document.createTextNode("x");
                    deletebutton.appendChild(deletebutt);



                    licommentbutthold.appendChild(deletebutton);
                    ulcommentbutthold.appendChild(licommentbutthold);
                    divcommentbutthold.appendChild(ulcommentbutthold);
                    userPrivacyBox.appendChild(divcommentbutthold);


                    userNamePrivacy.appendChild(userNamePrivacyT);
                        userPrivacyBox.appendChild(userNamePrivacy);

                        $("#results").append(userPrivacyBox);






                },
                fail: function() {
                    alert("ajax  addrule failed");
                },
                error: function( jqXHR,  textStatus,  errorThrown) {
                    console.log(errorThrown);
                    //	alert("ajax error");
                }
            });


            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        var $li = $("<li>");
        $li.addClass("searchItem");

        $outerDiv = $("<div>");
        $outerDiv.appendTo($li);

        $imageDiv = $("<div>");
        $imageDiv.addClass("contactImageDiv");
        $imageDiv.appendTo($outerDiv);

        $img = $("<img>");
        $img.addClass("contactImage");
        $img.attr("src", imagepath + item.immagine);
        $img.appendTo($imageDiv);

        $name = $("<div>");
        $name.addClass("nameDiv");
        $name.append(item.Nome + " " + item.Cognome + "<br/><span style='font-style:italic'>" + "</span>");
        $name.appendTo($outerDiv);

        $li.appendTo(ul);

        return $li;
    };

});



$(document).ready(function () {
    $.ajax({
        type: 'POST',
        url: urlajAjaxPrivacyReadAllRules,
        dataType: "json",
        async:false,
        data: {id_blog:idblog},
        success: function (data) {
            alert("ajax privacyreadrule succeded");

            // per gestire il risultato nullo
            if (data.length == 0) {
                //se non carica niente
                return;
            }
            console.log("i dati di ajax readruleprivacy:");

            console.log(data);

            //qui ci va il jquery che aggiunge tutti gli utenti

            for (i = 0; i <= [Object.keys(data).length - 1]; i++) {


                var userPrivacyBox = document.createElement('div');
                var userPrivacyBoxa = document.createElement('a');

                userPrivacyBox.setAttribute('class', 'button-link');
                userPrivacyBox.setAttribute('user', data[i].id);


                var userNamePrivacyT = document.createTextNode(data[i].Nome + ' ' + data[i].Cognome);







                userPrivacyBoxa.appendChild(userNamePrivacyT);
                userPrivacyBox.appendChild(userPrivacyBoxa);



                $("#results").append(userPrivacyBox);
            }


        },
        fail: function() {
            alert("ajax privacyreadrule failed");
        },
        error: function( jqXHR,  textStatus,  errorThrown) {
            console.log(errorThrown);
            alert("ajax privacyreadrule error");
        }
    });


});

$(".button-link").click(function () {
    var user = $(this).attr('user');

    $.ajax({
        type: 'POST',
        url: urlajAjaxPrivacyDeleteRule,
        dataType: "json",
        async:false,
        data: {user: user, idblog: idblog},
        success: function (data) {
            alert("ajax privacydeleterule succeded");

            // per gestire il risultato nullo
            if (data.length == 0) {
                //se non carica niente
                return;
            }
            console.log("i dati di ajax deleteruleprivacy:");

            console.log(data);



            $(this).closest(".comment-text").hide();


        },
        fail: function() {
            alert("ajax privacyDeleterule failed");
        },
        error: function( jqXHR,  textStatus,  errorThrown) {
            console.log(errorThrown);
            alert("ajax privacyDeleterule error");
        }
    });


});


