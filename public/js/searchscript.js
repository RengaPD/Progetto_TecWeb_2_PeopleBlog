/**
 * Created by renga on 03/09/16.
 */
//$(document).ready(function () {

//});


$(document).ready(function () {
    $("#searchbox").autocomplete({
        source: function (request, response) {

            // if(request.term.endsWith("*")){
            //  request.term.substring(0, request.length - 1);}
            console.log(request.term);
			console.log(urlajax);
            $.ajax({
                type: 'POST',
                url: urlajax,
                dataType: "json",
                data: {query: request.term},
                success: function (data) {
					//alert("ajax succeded");
//                    console.log("succeded ajax response");
// per gestire il risultato nullo
                    response(data.length === 1 && data[0].length === 0 ? [] : data);
                },
				fail: function() {
					alert("ajax failed");
				},
				error: function( jqXHR,  textStatus,  errorThrown) {
					console.log(errorThrown);
				//	alert("ajax error");
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
            var getInput = function (name, value, parent, array) {
                var parentString;
                if (parent.length > 0) {
                    parentString = parent[0];
                    var i;
                    for (i = 1; i < parent.length; i += 1) {
                        parentString += "[" + parent[i] + "]";
                    }

                    if (array) {
                        name = parentString + "[]";
                    } else {
                        name = parentString + "[" + name + "]";
                    }
                }

                return $("<input>").attr("type", "hidden")
                    .attr("name", name)
                    .attr("value", value);
            };
            var iterateValues = function (values, parent, form, array) {
                var i, iterateParent = [];
                for (i in values) {
                    if (typeof values[i] === "object") {
                        iterateParent = parent.slice();
                        if (array) {
                            iterateParent.push('');
                        } else {
                            iterateParent.push(i);
                        }
                        iterateValues(values[i], iterateParent, form, Array.isArray(values[i]));
                    } else {
                        form.append(getInput(i, values[i], parent, array));
                    }
                }
            };

            var url = urlaction, values = {'id': ui.item.id}, method = "GET", target;
            method = (method && ["GET", "POST", "PUT", "DELETE"].indexOf(method.toUpperCase()) != -1) ? method.toUpperCase() : 'GET';

            if (!values) {
                var obj = $.parseUrl(url);
                url = obj.url;
                values = obj.params;
            }

            var form = $('<form>')
                .attr("method", method)
                .attr("action", url);

            if (target) {
                form.attr("target", target);
            }

            var submit = {}; //Create a symbol
            form[0][submit] = form[0].submit;
            iterateValues(values, [], form);
            $('body').append(form);
            form[0][submit]();


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

