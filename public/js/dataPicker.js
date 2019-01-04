$(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end) {
        $("#home_form_StartDate").val(start.format('YYYY-MM-DD'));
        $("#home_form_EndDate").val(end.format('YYYY-MM-DD'));
    });
});