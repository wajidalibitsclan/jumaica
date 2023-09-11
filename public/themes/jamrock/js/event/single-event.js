(function ($) {
    $(window).on("load", function () {
        var urlHash = window.location.href.split("#")[1];
        if (urlHash &&  $('.' + urlHash).length ){
            var offset_other = 70
            if(urlHash === "review-list"){
                offset_other = 330;
            }
            $('html,body').animate({
                scrollTop: $('.' + urlHash).offset().top - offset_other
            }, 1000);
        }
    });

    $(".bravo-button-book-mobile").click(function () {
        $('.bravo_single_book_wrap').modal('show');
    });

    $(".bravo_detail_event .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });

})(jQuery);
