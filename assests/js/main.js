$(function () {
    $('.navbar-toggle').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        //$('#search').removeClass('in').addClass('collapse').slideUp(200);
    });

    // Remove menu for searching
    $('#search-trigger').click(function () {
        $('.navbar-nav').removeClass('slide-in');
        $('.side-body').removeClass('body-slide-in');
    });

    $('.btn-delete').on('click', function () {
        $('#deleteModalBody').html('Are you sure you want to delete ' + $(this).attr('data-product-id') + '?');
        $('#deleteModal').modal('show');
    });
});