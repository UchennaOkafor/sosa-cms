$(function () {
    $(".navbar-toggle").click(function () {
        $(".navbar-nav").toggleClass("slide-in");
        $(".side-body").toggleClass("body-slide-in");
        //$("#search").removeClass("in").addClass("collapse").slideUp(200);
    });

    // Remove menu for searching
    $("#search-trigger").click(function () {
        $(".navbar-nav").removeClass("slide-in");
        $(".side-body").removeClass("body-slide-in");
    });

    $(".btn-delete").on("click", function () {
        var productId = $(this).attr("data-product-id");
        var productName = $(this).attr("data-product-name");

        //Kinda hacky, I could of used the element#text method in jQuery but I wanted to escape only a portion of the HTML
        $("#deleteModalBody").html("Are you sure you want to delete <b>" + escapeHTML(productName) + "</b> ?");
        $("#deleteModal").modal("show");
        $("#btn-delete-item").attr("data-product-id", productId);
    });

    $("#btn-delete-item").on("click", function () {
        var postForm = {id: $(this).attr("data-product-id"), csrf_token: $("#csrf_token").val(), "action" : "delete"};

        $.post("/sosa-cms/backend/api/product/", postForm).done(function(jsonMsg) {
            $("#deleteModal").modal("hide");
            var responseMsg = JSON.parse(jsonMsg);

            var classValue = responseMsg.success ? "alert alert-success" : "alert alert-danger";
            var alertMsg = "";

            if (responseMsg.success) {
                alertMsg = "Product with Id " + postForm.id + "  has been successfully deleted.";
                $("tr[data-product-id=" + postForm.id + "]").remove();
            } else {
                alertMsg = "Product could not be deleted";
            }

            $("#deleteAlert").attr("class", classValue).html("<strong>" + alertMsg + "</strong>").show().delay(5000).fadeOut(400);
        });
    });

    $("#multipurpose-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url : form.attr("action"),
            type : form.attr("method"),
            data : form.serialize(),
            success: function(json) {
                var responseMsg = JSON.parse(json);
                var classValue = responseMsg.success ? "alert alert-success" : "alert alert-danger";
                var outputMSg = "";

                if (form.serialize().includes("action=add")) {
                    if (responseMsg.success) {
                        outputMSg = "<strong>Congratulations, the product has been created successfully!</strong>";
                        $(this).trigger("reset");
                    } else {
                        outputMSg += "<strong>Sorry, but the product could not be added.</strong>";
                        outputMSg += getErrorMessagesAsList(responseMsg.errorMessages);
                    }
                } else {
                    if (responseMsg.success) {
                        outputMSg = "<strong>Congratulations, the product has been edited successfully!</strong>";
                    } else {
                        outputMSg += "<strong>Sorry, but the product could not be edited.</strong>";
                        outputMSg += getErrorMessagesAsList(responseMsg.errorMessages);
                    }
                }

                $("#multipurpose-alert").attr("class", classValue).html(outputMSg).show().delay(6000).fadeOut(500);
            },
            error: function (xhr, textStatus, errorThrown) {
                var text = "A " + xhr.status + "<strong>[" + xhr.statusText + "]</strong> network error has occurred";
                $("#multipurpose-alert").attr("class", "alert alert-danger").html(text).show().delay(6000).fadeOut(500);
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

//TODO tidy up javascript/jquery