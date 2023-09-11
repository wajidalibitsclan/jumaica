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

    $(".bravo_detail_tour .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });


    $(".bravo_detail_tour .g-itinerary").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 3,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    });

})(jQuery);
