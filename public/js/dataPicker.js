$(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end) {
        $("#hotel_search_form_StartDate").val(start.format('YYYY-MM-DD'));
        $("#hotel_search_form_EndDate").val(end.format('YYYY-MM-DD'));
    });
});