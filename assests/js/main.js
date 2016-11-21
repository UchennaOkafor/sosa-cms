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

        $("#deleteModalBody").text("Are you sure you want to delete <b>" + productName + "</b> ?");
        $("#deleteModal").modal("show");
        $("#btn-delete-item").attr("data-product-id", productId);
    });

    $("#btn-delete-item").on("click", function () {
        var postForm = {product_id: $(this).attr("data-product-id"), csrf_token: $("#csrf_token").val() };
        $(".progress-bar-striped").addClass("active");
        $(".progress-bar-striped").removeClass("hidden");

        $.get("/sosa-cms/backend/api/delete/", postForm).done(function(jsonMsg) {
            $("#deleteModal").modal("hide");

            var msg = JSON.parse(jsonMsg);

            var classValue = msg.success ? "alert alert-success" : "alert alert-danger";
            $("#deleteAlert").attr("class", classValue).html("<strong>" + msg.message + "</strong>").show().delay(5000).fadeOut(400);
            $(".progress-bar-striped").addClass("hidden");

            if (msg.success) {
                $("tr[data-product-id=" + postForm.product_id + "]").remove();
            }
        });
    });
});