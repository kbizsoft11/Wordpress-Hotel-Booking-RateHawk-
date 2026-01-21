



<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 <div class="mmt-top-nav">
    <div class="mmt-top-nav-item" data-tab="flights"><i class="fa-solid fa-plane"></i>Flights</div>
    <div class="mmt-top-nav-item active"  data-tab="hotels"><i class="fa-solid fa-hotel"></i>Hotels</div>
    <!-- <div class="mmt-top-nav-item"><i class="fa-solid fa-house"></i>Homestays</div> -->
    <div class="mmt-top-nav-item" data-tab="trains"><i class="fa-solid fa-train"></i>Trains</div>
    <!-- <div class="mmt-top-nav-item"><i class="fa-solid fa-bus"></i>Buses</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-car"></i>Cabs</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-passport"></i>Visa</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-ship"></i>Cruise</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-credit-card"></i>Forex</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-shield-heart"></i>Insurance</div> -->
  </div>
<div class="mmt-wrapper">
  <!-- SUB NAV -->
  <div class="mmt-sub-nav">
    <label><input type="radio" checked name='hotel'>Upto 4 Rooms</label>
    <label><input type="radio" name='hotel'>Group Deals <span class="new-badge">NEW</span></label>
    <small>Book Domestic and International Property Online. To list your property
      <a href="#">Click Here</a>
    </small>
  </div>

  <!-- SEARCH FORM -->
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get first available check-in date
$firstAvailableCheckInDate = mphb_availability_facade()
    ->getFirstAvailableCheckInDate(
        0,
        MPHB()->settings()->main()->isBookingRulesForAdminDisabled()
    )
    ->format( 'Y-m-d' );

// Destination handling
if ( isset( $destination ) && ! empty( $destination ) ) {
    $destination = $destination;
} elseif ( isset( $_GET['mphb_destination'] ) && ! empty( $_GET['mphb_destination'] ) ) {
    $destination = sanitize_text_field( wp_unslash( $_GET['mphb_destination'] ) );
} else {
   // $destination = "Los Angeles";
}
?>
<div id="hotels-form" class="search-form-container active">
<form method="GET" class="mphb_sc_search-form" action="<?php echo esc_url( site_url( '/hotel-search/' ) ); ?>">
    
    <?php do_action( 'mphb_sc_search_render_form_top' ); ?>

    <!-- Destination -->
    <p class="mphb_sc_search-destination">
        <label for="<?php echo esc_attr( 'mphb_destination-' . $uniqid ); ?>">
            <?php esc_html_e( 'Destination', 'motopress-hotel-booking' ); ?>
        </label>
        <br />
        <input
            id="<?php echo esc_attr( 'mphb_destination-' . $uniqid ); ?>"
            type="text"
            name="mphb_destination"
            
            placeholder="<?php esc_attr_e( 'City or property', 'motopress-hotel-booking' ); ?>"
            autocomplete="off"
            required
        />
        <?php if ( ! empty( $attributes ) && isset( $attributes['destination'] ) && is_array( $attributes['destination'] ) ) : ?>
            <datalist id="<?php echo esc_attr( 'mphb_destination_list-' . $uniqid ); ?>">
                <?php foreach ( $attributes['destination'] as $termId => $termLabel ) : ?>
                    <option value="<?php echo esc_attr( $termLabel ); ?>"></option>
                <?php endforeach; ?>
            </datalist>
            <script>
                (function() {
                    var el = document.getElementById('<?php echo esc_js( 'mphb_destination-' . $uniqid ); ?>');
                    if (el) el.setAttribute('list', '<?php echo esc_js( 'mphb_destination_list-' . $uniqid ); ?>');
                })();
            </script>
        <?php endif; ?>
    </p>
	<?php
// Sanitize uniqid for JS-safe use
$uniqid_safe = str_replace('-', '_', $uniqid);
?>


   <!-- Check-in Date -->
    <p class="mphb_sc_search-check-in-date">
        <label for="<?php echo esc_attr( 'mphb_check_in_date-' . $uniqid ); ?>">
            <?php esc_html_e( 'Check-in', 'motopress-hotel-booking' ); ?>
            <abbr title="<?php echo esc_attr( sprintf( _x( 'Formatted as %s', 'Date format tip', 'motopress-hotel-booking' ), MPHB()->settings()->dateTime()->getDateFormatJS() ) ); ?>">*</abbr>
        </label>
        <br />
        <input
            id="<?php echo esc_attr( 'mphb_check_in_date-' . $uniqid ); ?>"
            data-datepick-group="<?php echo esc_attr( $uniqid ); ?>"
            value="<?php echo esc_attr( $checkInDate ); ?>"
            placeholder="<?php esc_attr_e( 'Check-in Date', 'motopress-hotel-booking' ); ?>"
            required
            type="text"
            inputmode="none"
            name="mphb_check_in_date"
            class="mphb-datepick"
            autocomplete="off"
        />
    </p>

    <!-- Check-out Date -->
    <p class="mphb_sc_search-check-out-date">
        <label for="<?php echo esc_attr( 'mphb_check_out_date-' . $uniqid ); ?>">
            <?php esc_html_e( 'Check-out', 'motopress-hotel-booking' ); ?>
            <abbr title="<?php echo esc_attr( sprintf( _x( 'Formatted as %s', 'Date format tip', 'motopress-hotel-booking' ), MPHB()->settings()->dateTime()->getDateFormatJS() ) ); ?>">*</abbr>
        </label>
        <br />
        <input
            id="<?php echo esc_attr( 'mphb_check_out_date-' . $uniqid ); ?>"
            data-datepick-group="<?php echo esc_attr( $uniqid ); ?>"
            value="<?php echo esc_attr( $checkOutDate ); ?>"
            placeholder="<?php esc_attr_e( 'Check-out Date', 'motopress-hotel-booking' ); ?>"
            required
            type="text"
            inputmode="none"
            name="mphb_check_out_date"
            class="mphb-datepick"
            autocomplete="off"
        />
    </p>

    <!-- Adults -->
    <?php if ( MPHB()->settings()->main()->isAdultsDisabledOrHidden() ) : ?>
        <input type="hidden" id="<?php echo esc_attr( 'mphb_adults-' . $uniqid ); ?>" name="mphb_adults" value="<?php echo esc_attr( MPHB()->settings()->main()->getMinAdults() ); ?>" />
    <?php else : ?>
        <p class="mphb_sc_search-adults">
            <label for="<?php echo esc_attr( 'mphb_adults-' . $uniqid ); ?>">
                <?php echo MPHB()->settings()->main()->isChildrenAllowed() ? esc_html__( 'Adults', 'motopress-hotel-booking' ) : esc_html__( 'Guests', 'motopress-hotel-booking' ); ?>
            </label>
            <br />
            <select id="<?php echo esc_attr( 'mphb_adults-' . $uniqid ); ?>" name="mphb_adults">
                <?php foreach ( $adultsList as $value ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $adults, $value ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    <?php endif; ?>

    <!-- Children -->
    <?php if ( MPHB()->settings()->main()->isChildrenDisabledOrHidden() ) : ?>
        <input type="hidden" id="<?php echo esc_attr( 'mphb_children-' . $uniqid ); ?>" name="mphb_children" value="<?php echo esc_attr( MPHB()->settings()->main()->getMinChildren() ); ?>" />
    <?php else : ?>
        <p class="mphb_sc_search-children">
            <label for="<?php echo esc_attr( 'mphb_children-' . $uniqid ); ?>">
                <?php
                $childrenAge = MPHB()->settings()->main()->getChildrenAgeText();
                echo empty( $childrenAge ) ? esc_html__( 'Children', 'motopress-hotel-booking' ) : esc_html( sprintf( __( 'Children %s', 'motopress-hotel-booking' ), $childrenAge ) );
                ?>
            </label>
            <br />
            <select id="<?php echo esc_attr( 'mphb_children-' . $uniqid ); ?>" name="mphb_children">
                <?php foreach ( $childrenList as $value ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $children, $value ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    <?php endif; ?>

    <?php do_action( 'mphb_sc_search_form_before_attributes' ); ?>

    <!-- Attributes -->
    <?php foreach ( $attributes as $attributeName => $terms ) : ?>
        <p class="<?php echo esc_attr( 'mphb_sc_search-' . $attributeName ); ?>">
            <label for="<?php echo esc_attr( 'mphb_' . $attributeName . '-' . $uniqid ); ?>">
                <?php echo esc_html( mphb_attribute_title( $attributeName ) ); ?>
            </label>
            <br />
            <select id="<?php echo esc_attr( 'mphb_' . $attributeName . '-' . $uniqid ); ?>" name="<?php echo esc_attr( 'mphb_attributes[' . $attributeName . ']' ); ?>">
                <option value=""><?php echo esc_html( mphb_attribute_default_text( $attributeName ) ); ?></option>
                <?php foreach ( $terms as $termId => $termLabel ) : ?>
                    <option value="<?php echo esc_attr( $termId ); ?>"><?php echo esc_html( $termLabel ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    <?php endforeach; ?>

    <?php do_action( 'mphb_sc_search_form_before_submit_btn' ); ?>

    <p class="mphb_sc_search-submit-button-wrapper">
        <input type="submit" class="button" value="<?php esc_attr_e( 'Search', 'motopress-hotel-booking' ); ?>"/>
    </p>

    <?php do_action( 'mphb_sc_search_form_bottom' ); ?>

</form>
</div>
 <div id="flights-form" class="search-form-container">
  <form method="GET" class="mphb_sc_search-form mmt-form" data-type="flight" action="<?php echo esc_url( site_url( '/flight-search/' ) ); ?>">
      <!-- top of form area (mirrors structure & hooks) -->
      <?php do_action( 'mphb_sc_search_render_form_top' ); ?>

      <!-- From -->
      <p class="flight-from">
        <label for="mmt_flight_from">From</label><br />
        <input id="mmt_flight_from" type="text" name="flight_from" placeholder="Departure city" autocomplete="off" required />
      </p>

      <!-- To -->
      <p class="flight-to">
        <label for="mmt_flight_to">To</label><br />
        <input id="mmt_flight_to" type="text" name="flight_to" placeholder="Arrival city" autocomplete="off" required />
      </p>

      <!-- Departure Date -->
      <p class="flight-departure">
        <label for="<?php echo esc_attr( 'mphb_check_out_date-' . $uniqid ); ?>">Departure
		 </label><br />
        <input  id="<?php echo esc_attr( 'mphb_check_out_date-' . $uniqid ); ?>"  type="text" name="flight_depart" placeholder="Departure date" inputmode="none" autocomplete="off" required class="mphb-datepick"  data-datepick-group="<?php echo esc_attr( $uniqid ); ?>"/>
      </p>
	 
      <!-- Return Date -->
     <!-- <p class="flight-return-date">
        <label for="mmt_flight_return">Return (optional)</label><br />
        <input id="mmt_flight_return" type="text" name="flight_return" placeholder="Return date" inputmode="none" autocomplete="off" class="mphb-datepick"/>
      </p>-->

      <!-- Passengers -->
      <p class="flight-passenger">
        <label for="mmt_flight_passengers">Passengers</label><br />
        <select id="mmt_flight_passengers" name="flight_passengers">
          <option value="1">1</option>
          <option value="2" selected>2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </p>

      <!-- Cabin/Class -->
      <p class="flight-class">
        <label for="mmt_flight_class">Class</label><br />
        <select id="mmt_flight_class" name="flight_class">
          <option value="economy">Economy</option>
          <option value="premium_economy">Premium Economy</option>
          <option value="business">Business</option>
          <option value="first">First</option>
        </select>
      </p>

      <p class="mphb_sc_search-submit-button-wrapper">
        <input type="submit" class="button" value="Search"/>
      </p>

      <?php do_action( 'mphb_sc_search_form_bottom' ); ?>
    </form>
	  </div>
</div>
<script>
  function initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>() {
    const input = document.getElementById('<?php echo esc_js( 'mphb_destination-' . $uniqid ); ?>');
    if (!input || !window.google || !google.maps || !google.maps.places) return;

   
    const ac = new google.maps.places.Autocomplete(input, {
      types: ['(cities)'], 
      fields: ['address_components', 'name', 'formatted_address']
    });

    ac.addListener('place_changed', function() {
      const place = ac.getPlace();
      if (!place || !place.address_components) return;


      let city = '';
      place.address_components.forEach(comp => {
        if (comp.types.includes('locality')) city = comp.long_name;
        else if (!city && comp.types.includes('administrative_area_level_2')) city = comp.long_name;
      });

      
      if (!city && place.name) city = place.name;

      input.value = city;
    });
  }
  function initFlightAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>() {
    const fromInput = document.getElementById('mmt_flight_from');
    const toInput = document.getElementById('mmt_flight_to');
    if (!fromInput || !toInput || !window.google || !google.maps || !google.maps.places) return;
	return;
    const fromAutocomplete = new google.maps.places.Autocomplete(fromInput, {
      types: ['(cities)'], 
      fields: ['address_components', 'name', 'formatted_address']
    });

    const toAutocomplete = new google.maps.places.Autocomplete(toInput, {
      types: ['(cities)'], 
      fields: ['address_components', 'name', 'formatted_address']
    });

    fromAutocomplete.addListener('place_changed', function() {
      const place = fromAutocomplete.getPlace();
      if (!place || !place.address_components) return;

      let city = '';
      place.address_components.forEach(comp => {
        if (comp.types.includes('locality')) city = comp.long_name;
        else if (!city && comp.types.includes('administrative_area_level_2')) city = comp.long_name;
      });

      if (!city && place.name) city = place.name;

      fromInput.value = city;
    });

    toAutocomplete.addListener('place_changed', function() {
      const place = toAutocomplete.getPlace();
      if (!place || !place.address_components) return;

      let city = '';
      place.address_components.forEach(comp => {
        if (comp.types.includes('locality')) city = comp.long_name;
        else if (!city && comp.types.includes('administrative_area_level_2')) city = comp.long_name;
      });

      if (!city && place.name) city = place.name;

      toInput.value = city;
    });
  }
  
 
  window['initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>'] = initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>;
   window['initFlightAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>'] = initFlightAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>;
   (function() {
    const NAV_SELECTOR = '.mmt-top-nav-item';
    const FORM_SELECTOR = '.search-form-container';

    function setActiveTab(tabName) {
      // nav items
      document.querySelectorAll(NAV_SELECTOR).forEach(nav => {
        if (nav.dataset.tab === tabName) nav.classList.add('active');
        else nav.classList.remove('active');
      });

      // form containers
      document.querySelectorAll(FORM_SELECTOR).forEach(form => {
        if (form.id === tabName + '-form') form.classList.add('active');
        else form.classList.remove('active');
      });
    }

    // attach click handlers
    document.querySelectorAll(NAV_SELECTOR).forEach(item => {
      item.addEventListener('click', function(e) {
        const tab = (this.dataset && this.dataset.tab) ? this.dataset.tab : null;
        if (!tab) return;
        setActiveTab(tab);
      });
    });

    // optional: ensure only one active form on load (if markup had multiple)
    // If you want hotels to be default, call setActiveTab('hotels') here.
    // If you want whichever nav has .active initially to be used:
    const initial = document.querySelector(NAV_SELECTOR + '.active');
    if (initial && initial.dataset.tab) {
      setActiveTab(initial.dataset.tab);
    } else {
      // fallback — first nav
      const first = document.querySelector(NAV_SELECTOR);
      if (first && first.dataset.tab) setActiveTab(first.dataset.tab);
    }
  })();
  
   function initializeAllAutocompletes_<?php echo esc_js( $uniqid_safe ); ?>() {
    initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>();
    initFlightAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>();
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMwU9kvAENr9xXm9z7lzdJZt2b0lDw16A&libraries=places&callback=initializeAllAutocompletes_<?php echo esc_js( $uniqid_safe ); ?>" async defer></script>
<style>
  .search-form-container { display: none; }
  .search-form-container.active { display: block; }
  </style>