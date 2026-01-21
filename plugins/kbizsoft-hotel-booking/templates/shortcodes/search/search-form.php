



<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 <div class="mmt-top-nav">
    <div class="mmt-top-nav-item"><i class="fa-solid fa-plane"></i>Flights</div>
    <div class="mmt-top-nav-item active"><i class="fa-solid fa-hotel"></i>Hotels</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-house"></i>Homestays</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-train"></i>Trains</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-bus"></i>Buses</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-car"></i>Cabs</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-passport"></i>Visa</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-ship"></i>Cruise</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-credit-card"></i>Forex</div>
    <div class="mmt-top-nav-item"><i class="fa-solid fa-shield-heart"></i>Insurance</div>
  </div>
<div class="mmt-wrapper">
  <!-- SUB NAV -->
  <div class="mmt-sub-nav">
    <label><input type="radio" checked>Upto 4 Rooms</label>
    <label><input type="radio">Group Deals <span class="new-badge">NEW</span></label>
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

 
  window['initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>'] = initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>;
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMwU9kvAENr9xXm9z7lzdJZt2b0lDw16A&libraries=places&callback=initAutocomplete_<?php echo esc_js( $uniqid_safe ); ?>" async defer></script>
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
