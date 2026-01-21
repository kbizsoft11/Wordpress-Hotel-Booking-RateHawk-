( function( api ) {

	// Extends our custom "destination-hotel-booking" section.
	api.sectionConstructor['destination-hotel-booking'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );