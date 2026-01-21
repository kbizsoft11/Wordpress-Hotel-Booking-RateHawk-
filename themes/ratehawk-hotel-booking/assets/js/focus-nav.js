( function( window, document ) {
  function destination_hotel_booking_keepFocusInMenu() {
    document.addEventListener( 'keydown', function( e ) {
      const destination_hotel_booking_nav = document.querySelector( '.sidenav' );
      if ( ! destination_hotel_booking_nav || ! destination_hotel_booking_nav.classList.contains( 'open' ) ) {
        return;
      }
      const elements = [...destination_hotel_booking_nav.querySelectorAll( 'input, a, button' )],
        destination_hotel_booking_lastEl = elements[ elements.length - 1 ],
        destination_hotel_booking_firstEl = elements[0],
        destination_hotel_booking_activeEl = document.activeElement,
        tabKey = e.keyCode === 9,
        shiftKey = e.shiftKey;
      if ( ! shiftKey && tabKey && destination_hotel_booking_lastEl === destination_hotel_booking_activeEl ) {
        e.preventDefault();
        destination_hotel_booking_firstEl.focus();
      }
      if ( shiftKey && tabKey && destination_hotel_booking_firstEl === destination_hotel_booking_activeEl ) {
        e.preventDefault();
        destination_hotel_booking_lastEl.focus();
      }
    } );
  }
  destination_hotel_booking_keepFocusInMenu();
} )( window, document );