jQuery(function ($) {

    $(document).on('click','.save-cookie',function () {
        var button = $(this);
        button.closest('.booking_cookie_agreement').remove();
        if(typeof save_cookie_url !='undefined'){
            $.ajax({
                'url': save_cookie_url,
                'type': 'GET',
                success: function (data) {
                },
                error:function (e) {
                }
            });

        }

    })
});
