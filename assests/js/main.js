$(function () {

    $(".navbar-toggle").click(function () {
        $(".navbar-nav").toggleClass("slide-in");
        $(".side-body").toggleClass("body-slide-in");
        $("#search").removeClass("in").addClass("collapse").slideUp(200);
    });

    // Remove menu for searching
    $("#search-trigger").click(function () {
        $(".navbar-nav").removeClass("slide-in");
        $(".side-body").removeClass("body-slide-in");
        var childSpan = $("#search-trigger span");

        if ($(childSpan).attr("class").includes("menu-up")) {
            $(childSpan).attr("class", "glyphicon glyphicon-menu-down");
        } else {
            $(childSpan).attr("class", "glyphicon glyphicon-menu-up");
        }
    });

    /**
     * An event for the btn delete class, it will associate the the product id of the last product the delete button was clicked on to the modal
     */
    $(".btn-delete").on("click", function () {
        var productId = $(this).attr("data-product-id");
        var productName = $(this).attr("data-product-name");

        //Kinda hacky, I could of used the jQuery#text method in jQuery but I wanted to escape only a portion of the HTML
        $("#deleteModalBody").html("Are you sure you want to delete <b>" + escapeHTML(productName) + "</b> ?");
        $("#deleteModal").modal("show");

        //Associates the most recent product id with the delete button on the modal
        $("#modalDeleteBtn").attr("data-product-id", productId);
    });

    $("#modalDeleteBtn").on("click", function () {
        var postForm = {
            id: $(this).attr("data-product-id"),
            csrf_token: $("#csrf_token").val(),
            action : "delete"
        };

        var alertMsg = "";
        var classValue = "";
        var deleteButton = $(this);

        $.ajax({
            url : "/sosa-cms/backend/api/product/",
            type : "POST",
            data : postForm,
            beforeSend: function () {
                deleteButton.button("loading");
                return true;
            },
            success: function(json) {
                var responseJson = null;

                try {
                    responseJson = JSON.parse(json);
                } catch (ex) {
                    classValue = "alert alert-danger";
                    alertMsg = "<strong>Sorry, but server data could not be interpreted.</strong>";
                    console.log(ex);
                }

                if (responseJson != null) {
                    classValue = responseJson.success ? "alert alert-success" : "alert alert-danger";

                    if (responseJson.success) {
                        alertMsg = "Product with Id " + postForm.id + "  has been successfully deleted.";
                        $("tr[data-product-id=" + postForm.id + "]").remove();
                    } else {
                        alertMsg = "Product could not be deleted";
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                alertMsg = "A " + xhr.status + "<strong>[" + xhr.statusText + "]</strong> network error has occurred";
                classValue = "alert alert-danger";
            },
            complete: function () {
                deleteButton.button("reset");
                $("#deleteModal").modal("hide");
                $("#deleteAlert").attr("class", classValue).html("<strong>" + alertMsg + "</strong>").show().delay(4000).fadeOut(400);
            }
        });
    });

    $("#multipurpose-form").submit(function(event) {
        event.preventDefault();
        var form = $(this);

        var submitButton = $("input[type=submit]", form);

        var classValue = "";
        var outputMsg = "";

        $.ajax({
            url : form.attr("action"),
            type : form.attr("method"),
            data : form.serialize(),
            beforeSend: function () {
                submitButton.button("loading");
                return true;
            },
            success: function(json) {
                var responseJson = null;

                try {
                    responseJson = JSON.parse(json);
                } catch (ex) {
                    classValue = "alert alert-danger";
                    outputMsg = "<strong>Sorry, but server data could not be interpreted.</strong>";
                    console.log(ex);
                }

                if (responseJson != null) {
                    classValue = responseJson.success ? "alert alert-success" : "alert alert-danger";

                    //This means the form was used for an add action
                    if (form.serialize().includes("action=add")) {
                        if (responseJson.success) {
                            outputMsg = "<strong>Congratulations, the product has been created successfully!</strong>";
                            form.trigger("reset");
                        } else {
                            outputMsg += "<strong>Sorry, but the product could not be added.</strong>";
                            outputMsg += getErrorMessagesAsList(responseJson.errorMessages);
                        }
                    } else { //Else it was used for an edit action
                        if (responseJson.success) {
                            outputMsg = "<strong>Congratulations, the product has been edited successfully!</strong>";
                        } else {
                            outputMsg += "<strong>Sorry, but the product could not be edited.</strong>";
                            outputMsg += getErrorMessagesAsList(responseJson.errorMessages);
                        }
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                outputMsg = "A " + xhr.status + "<strong>[" + xhr.statusText + "]</strong> network error has occurred";
                classValue = "alert alert-danger";
            },
            complete: function () {
                $("#multipurpose-alert").attr("class", classValue).html(outputMsg).show().delay(6000).fadeOut(500);
                submitButton.button("reset");
            }
        });

        function getErrorMessagesAsList(errorMessages) {
            var ul = $("<ul></ul>");

            $.each(errorMessages, function(i, item) {
                ul.append($("<li></li>").text(item));
            });

            return ul[0].outerHTML;
        }
    });

    $("#txt-name").on("keypress keyup keydown", function () {
        var charsLeft = parseInt($(this).attr("maxlength")) - $(this).val().length;
        $("#lbl-char-remaining").html(charsLeft + " character(s) remaining");
    });
});

/**
 *
 * @param s
 * @returns {XML|string|void}
 */
function escapeHTML(s) {
    return s.replace(/[&"<>]/g, function (c) {
        return {
            '&': "&amp;",
            '"': "&quot;",
            '<': "&lt;",
            '>': "&gt;"
        }[c];
    });
}