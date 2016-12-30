/**
 * Created by renga on 03/09/16.
 */
$(document).ready(function () {
    $("#searchbox").autocomplete({
        source: function( request, response ){
            if(request.term.endsWith("*")){
                request.substring(0, str.length - 1);}

            $.ajax({
                type: 'POST',
                url: urlajax,
                dataType: "json",
                data: {

                    q: request.term
                },
                success: function (data) {
                    console.log(typeof data);
                    console.log(data);
// per gestire il risultato nullo
                    response(data.length === 1 && data[0].length === 0 ? [] : data);
                }
            });



        },
        minLength: 2,
        focus: function (event, ui) {
            $("#searchbox").val(ui.item.Nome + " " + ui.item.Cognome)
            return false;
        },
        select: function (event, ui) {

            var url = urlaction + ui.item.id ;
            location.href = url;
            return false;
        },
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
        $img.attr("src", item.imgUrl);
        $img.appendTo($imageDiv);

        $name = $("<div>");
        $name.addClass("nameDiv");
        $name.append(item.Nome + " " + item.Cognome + "<br/><span style='font-style:italic'>"+"</span>");
        $name.appendTo($outerDiv);

        $li.appendTo(ul);

        return $li;
    };

})

