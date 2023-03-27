$(document).ready(function() {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#sidebarCollapse').on('click', function() {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    $("#Submitbutton").on('dblclick', function(event) {
        event.preventDefault();
        var el = $(this);
        el.prop('disabled', true);
        setTimeout(function() {
            el.prop('disabled', false);
        }, 3000);
    });

    $("form").submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    });
});