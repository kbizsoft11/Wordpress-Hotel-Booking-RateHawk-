( function( jQuery ){
 jQuery( document ).on( 'click', '.notice-get-started-class .notice-dismiss', function () {
        var type = jQuery( this ).closest( '.notice-get-started-class' ).data( 'notice' );
        jQuery.ajax( ajaxurl,
          {
            type: 'POST',
            data: {
              action: 'destination_hotel_booking_dismissed_notice_handler',
              type: type,
              wpnonce: hair_spa_salon.wpnonce
            }
          } );
      } );
}( jQuery ) )

// notice js
document.addEventListener("DOMContentLoaded", function() {
    let closeBtn = document.getElementById("close-detail-theme");
    let detailBox = document.getElementById("detail-theme-box");

    if (closeBtn && detailBox) {
        closeBtn.addEventListener("click", function() {
            detailBox.style.display = "none";
        });
    }
});