jQuery(function($) {
    "use strict";

    // Scroll to top functionality
    $(window).on('scroll', function() {
        if ($(this).scrollTop() >= 50) {
            $('#return-to-top').fadeIn(200);
        } else {
            $('#return-to-top').fadeOut(200);
        }
    });

    $('#return-to-top').on('click', function() {
        $('body,html').animate({ scrollTop: 0 }, 500);
    });

    // Side navigation toggle
    $('.gb_toggle').on('click', function() {
        destination_hotel_booking_Keyboard_loop($('.side_gb_nav'));
    });

    // Preloader fade out
    setTimeout(function() {
        $(".loader").fadeOut("slow");
    }, 1000);

});

// Mobile responsive menu
function destination_hotel_booking_menu_open_nav() {
    jQuery(".sidenav").addClass('open');
}

function destination_hotel_booking_menu_close_nav() {
    jQuery(".sidenav").removeClass('open');
}