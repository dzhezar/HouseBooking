$(document).ready(function () {
   $('#hotel_search_form_City').keyup(function () {
      $.ajax({
          url:'/search',
           data: {
               slug: $(this).val()
           }
       }
      )
        .done(function (text) {
            $('#ajax-result').css('display','block');
            $('#ajax-result').html(text);
        })
   });
});
$(document).on('click','.ajax-choose',function () {
    $('#hotel_search_form_City').val($(this).html());
    $('#ajax-result').hide();
});
$(document).on('focusout','#home_form_City',function () {
    if ($('.ajax-choose').hover(function () {
        $('#hotel_search_form_City').val($(this).html());
    }))


    $('#ajax-result').hide();
});