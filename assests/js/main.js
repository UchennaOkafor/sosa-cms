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

    $("#btn-delete-item").on("click", function () {
        var postForm = {product_id: $(this).attr("data-product-id"), csrf_token: $("#csrf_token").val(), "action" : "delete"};

        $.post("/sosa-cms/backend/api/product/", postForm).done(function(jsonMsg) {
            $("#deleteModal").modal("hide");
            var responseMsg = JSON.parse(jsonMsg);

            var classValue = responseMsg.success ? "alert alert-success" : "alert alert-danger";
            var alertMsg = "";

            if (responseMsg.success) {
                alertMsg = "Product with Id " + postForm.product_id + "  has been successfully deleted.";
                $("tr[data-product-id=" + postForm.product_id + "]").remove();
            } else {
                alertMsg = "Product could not be deleted";
            }

            $("#deleteAlert").attr("class", classValue).html("<strong>" + alertMsg + "</strong>").show().delay(5000).fadeOut(400);
        });
    });
});

//TODO tidy up javascript/jquery