function ajax_error_to_string(e){
    if(typeof e.responseJSON !== 'undefined'){
        if(e.responseJSON.errors){
            var html = [];
            for(var k in e.responseJSON.errors){
                html.push(e.responseJSON.errors[k].join("<br/>"));
            }

            return html.join("<br/>");
        }

        if(e.responseJSON.message){
            return e.responseJSON.message;
        }
    }
}
//Login
$('.bravo-theme-gotrip-login-form [type=submit]').click(function (e) {
    e.preventDefault();
    let form = $(this).closest('.bravo-theme-gotrip-login-form');
    var redirect = form.find('input[name=redirect]').val();

    $.ajax({
        url: bookingCore.url + '/login',
        data: {
            'email': form.find('input[name=email]').val(),
            'password': form.find('input[name=password]').val(),
            'remember': form.find('input[name=remember]').is(":checked") ? 1 : '',
            'g-recaptcha-response': form.find('[name=g-recaptcha-response]').val(),
            'redirect':form.find('input[name=redirect]').val()
        },
        method: 'POST',
        beforeSend: function () {
            form.find('.error').hide();
            form.find('.icon-arrow-top-right').hide();
            form.find('.icon-loading').removeClass('d-none');
        },
        dataType:'json',
        success: function (data) {
            if(data.two_factor){
                return window.location.href = bookingCore.url + '/two-factor-challenge';
            }
            form.find('.icon-arrow-top-right').show();
            form.find('.icon-loading').addClass('d-none');
            if (data.error === true) {
                if (data.messages !== undefined) {
                    for(var item in data.messages) {
                        var msg = data.messages[item];
                        form.find('.error-'+item).show().text(msg[0]);
                    }
                }
                if (data.messages.message_error !== undefined) {
                    form.find('.message-error').show().html('<div class="alert alert-danger">' + data.messages.message_error[0] + '</div>');
                }
            }
            if(data.message){
                form.find('.message-error').show().html('<div class="alert alert-danger">' + data.message + '</div>');
            }
            if (typeof BravoReCaptcha !== 'undefined') {
                BravoReCaptcha.reset('login');
                BravoReCaptcha.reset('login_normal');

            }
            if(redirect.trim('/')){
                window.location.href = bookingCore.url_root + form.find('input[name=redirect]').val();
            }else{
                window.location.reload();
            }

        },
        error:function (e){
            form.find('.icon-arrow-top-right').show();
            form.find('.icon-loading').addClass('d-none');
            var html = ajax_error_to_string(e);
            if (typeof BravoReCaptcha !== 'undefined') {
                BravoReCaptcha.reset('login');
                BravoReCaptcha.reset('login_normal');

            }
            if(html){
                form.find('.message-error').show().html('<div class="alert alert-danger">' + html + '</div>');
            }
        }
    });
})
