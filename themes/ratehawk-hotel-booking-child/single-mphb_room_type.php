
<?php

if ( ! session_id() ) {
    @session_start();
}

get_header(); ?>

<!-- <div class="box-image-page">
    <div class="single-page-img"></div>
    <div class="box-text">
        <?php if ( have_posts() ) : ?>
            <div class="page-header">
                <?php
                    the_archive_title( '<h2 class="page-title">', '</h2>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
            </div>
        <?php endif; ?>  
    </div> 
</div> -->

<div class="hotel-single">
    <div class="container">
        <main id="primary" class="site-main content-area">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="main-single-cotent">
                        <!-- LEFT:  -->
                        <div class="left-content">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <span class="room-thumbnail"><?php the_post_thumbnail( 'large' ); ?></span>
                            <?php else: ?>
                                <span class="room-thumbnail">
                                    <img src="https://ratehawk.scalon.in/wp-content/themes/destination-hotel-booking/assets/images/sliderimage.png" alt="Default Image" />
                                </span>
                            <?php endif; ?>

                            <span class="room-price"><?php mphb_tmpl_the_room_type_default_price(); ?></span>
							
						</div>
						
						<div class="right-content">
                            <span class="room-booking-form">
                                <?php echo do_shortcode( '[mphb_availability id="' . get_the_ID() . '"]' ); ?>
                            </span>
						</div>
						
					</div>
					
					
					<div class="main-single-cotent">
						<div class="room-listing location-section">
							<!-- <p>Test</p> -->
						</div>
					</div>
					
					<div class="main-single-cotent">
							
						<div class="left-content">

<?php
// Get the full response from post meta (it's already an array)
$full_response = get_post_meta(get_the_ID(), '_worldota_full_response', true);

if (!empty($full_response) && is_array($full_response)) {
    $data = $full_response; // Use directly as array
    
    if (isset($data['amenity_groups']) && !empty($data['amenity_groups'])) {
        $amenity_groups = $data['amenity_groups'];
        ?>
        <div class="amenities-container highlights-container">
            <h2>Highlights</h2>
            
            <div class="amenities-preview">
                <?php
                // Show first 3 groups as preview
                $preview_groups = array_slice($amenity_groups, 0, 3);
                foreach ($preview_groups as $group) {
                    if (isset($group['group_name']) && isset($group['amenities']) && !empty($group['amenities'])) {
                        $preview_amenities = array_slice($group['amenities'], 0, 3); // Show first 3 amenities per group
                        ?>
                        <div class="amenity-group-preview">
						<span><img src="https://cdn6.agoda.net/images/property/highlights/like.svg" alt="Great for activities" class="icon" /></span>
                            <strong><?php echo esc_html($group['group_name']); ?>:</strong>
                            <span>
                                <?php
                                $amenity_texts = [];
                                foreach ($preview_amenities as $amenity) {
                                    $is_paid = isset($group['non_free_amenities']) && !empty($group['non_free_amenities']) && in_array($amenity, $group['non_free_amenities']);
                                    $amenity_text = $is_paid ? $amenity . ' (Paid)' : $amenity;
                                    $amenity_texts[] = esc_html($amenity_text);
                                }
                                echo implode(', ', $amenity_texts);
                                if (count($group['amenities']) > 3) {
                                    echo '...';
                                }
                                ?>
                            </span>
							
                        </div>
                        <?php
                    }
                }
                ?>
                <button class="show-all-btn" onclick="openAmenitiesModal()">View All Amenities</button>
            </div>
        </div>

        <!-- Amenities Modal -->
        <div id="amenitiesModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>All Amenities</h2>
                    <span class="close" onclick="closeAmenitiesModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <?php
                    foreach ($amenity_groups as $group) {
                        if (isset($group['group_name']) && isset($group['amenities']) && !empty($group['amenities'])) {
                            ?>
                            <div class="amenity-group">
                                <h3><?php echo esc_html($group['group_name']); ?></h3>
                                <div class="amenities-list">
                                    <?php
                                    foreach ($group['amenities'] as $amenity) {
                                        $is_free = true;
                                        $is_paid = false;
                                        
                                        if (isset($group['non_free_amenities']) && !empty($group['non_free_amenities'])) {
                                            if (in_array($amenity, $group['non_free_amenities'])) {
                                                $is_paid = true;
                                                $is_free = false;
                                            }
                                        }
                                        
                                        $class = $is_paid ? 'amenity-item paid' : 'amenity-item free';
                                        ?>
                                        <div class="<?php echo esc_attr($class); ?>">
                                            <span class="amenity-name"><?php echo esc_html($amenity); ?></span>
                                            <?php if ($is_paid): ?>
                                                <span class="amenity-price">(Paid)</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <script>
        function openAmenitiesModal() {
            document.getElementById('amenitiesModal').style.display = 'block';
        }

        function closeAmenitiesModal() {
            document.getElementById('amenitiesModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('amenitiesModal');
            if (event.target === modal) {
                closeAmenitiesModal();
            }
        }
        </script>

        <style>
		.room-listing.location-section{
			width:100%;
		}
        .amenities-container {
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }

        .amenities-preview {
	
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background: #fafafa;
        }

        .amenity-group-preview {
					    display: flex;
    align-items: center;
    gap: 2px;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e0e0e0;
        }

        .amenity-group-preview:last-child {
            border-bottom: none;
            margin-bottom: 15px;
        }

        .amenity-group-preview strong {
            color: #333;
            font-weight: 600;
        }

        .amenity-group-preview span {
            color: #666;
            font-size: 14px;
        }

        .show-all-btn {
            background: #fbb191;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        .show-all-btn:hover {
            background: #000000;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 2% auto;
            padding: 0;
            border: none;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }

        .close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .amenity-group {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .amenity-group h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
            border-left: 3px solid #007cba;
            padding-left: 10px;
        }

        .amenities-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .amenity-item {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            margin: 2px;
            border: 1px solid #e9ecef;
        }

        .amenity-item.paid {
            background: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .amenity-item.free {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .amenity-price {
            font-size: 11px;
            color: #6c757d;
            margin-left: 5px;
        }
        </style>
        <?php
    }
}
?>

                            <div class="entry-content">
                                <?php the_content(); ?>
                                <?php
                               
                                global $post;

                                // Raw content
                                $content = get_the_content();

                                // HTML hata ke plain text bacha lo
                                $clean_content = wp_strip_all_tags( $content );

                                // Default empty
                                $worldota_id = '';

                                // "Imported from WorldOTA (id: ...)" se id capture karo
                                if ( preg_match('/Imported from WorldOTA\s*\(id:\s*([^)]+)\)/i', $clean_content, $m) ) {
                                    $worldota_id = trim( $m[1] ); // => park_hyatt_los_angeles_at_oceanwide_plaza
                                }

                               // echo 'WorldOTA ID: ' . $worldota_id;
                                ?>

                            </div>
                        </div>

                        <!-- RIGHT: Booking Form -->
                        <div class="right-content">                        
							<?php
$coordinates = get_hotel_coordinates();
if ($coordinates):
?>
<style>
.location-section {
    margin: 30px 0;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.location-header {
    background: #f8f8f8;
    padding: 15px 20px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.location-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.location-subtitle {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.map-section {
    position: relative;
    width: 100%;
    height: 400px;
}

.map-container {
    width: 100%;
    height: 100%;
    border-radius: 0 0 8px 8px;
}

.map-fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: white;
}

.map-fullscreen .map-container {
    height: 100%;
}

.map-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
}

.map-button {
    background: #fff;
    border: 1px solid #ddd;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-size: 14px;
    margin-left: 5px;
    transition: all 0.3s ease;
}

.map-button:hover {
    background: #f0f0f0;
}

.map-fullscreen .map-button {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
}
</style>

<!-- here print the  hotel rooms  -->




<div class="location-section">
    <div class="location-header">
        <div>
            <h3 class="location-title">Location</h3>
            <div class="location-subtitle">
<a href="https://www.google.com/maps/search/<?php echo urlencode($coordinates['name'].' '.$coordinates['address']); ?>/@<?php echo $coordinates['lat']; ?>,<?php echo $coordinates['lng']; ?>,15z" target="_blank" style="">
    <i class="fas fa-map-marker-alt"></i>
    <?php echo esc_html($coordinates['address']); ?>
</a>

			</div>
        </div>
        <button class="map-button" onclick="toggleMapFullscreen()">Full Screen</button>
    </div>
    <div class="map-section">
        <div id="hotel-map" class="map-container"></div>
    </div>
</div>

<script>
function initMap() {
    const coordinates = {
        lat: <?php echo $coordinates['lat']; ?>,
        lng: <?php echo $coordinates['lng']; ?>
    };
    
    const map = new google.maps.Map(document.getElementById('hotel-map'), {
        zoom: 15,
        center: coordinates,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: false,
        zoomControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        }
    });
    
    const marker = new google.maps.Marker({
        position: coordinates,
        map: map,
        title: '<?php echo addslashes($coordinates['name']); ?>',
        animation: google.maps.Animation.DROP
    });
    
    // Add info window
    const infoWindow = new google.maps.InfoWindow({
        content: '<div><strong><?php echo addslashes($coordinates['name']); ?></strong><br><?php echo addslashes($coordinates['address']); ?></div>'
    });
    infoWindow.open(map, marker);
    marker.addListener('click', () => {
        infoWindow.open(map, marker);
    });
}

function toggleMapFullscreen() {
    const locationSection = document.querySelector('.location-section');
    const mapContainer = document.querySelector('.map-container');
    
    if (locationSection.classList.contains('map-fullscreen')) {
        // Exit fullscreen
        locationSection.classList.remove('map-fullscreen');
        document.querySelector('.map-button').textContent = 'Full Screen';
    } else {
        // Enter fullscreen
        locationSection.classList.add('map-fullscreen');
        document.querySelector('.map-button').textContent = 'Exit Full Screen';
    }
}

// Load Google Maps API
function loadGoogleMaps() {
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBMwU9kvAENr9xXm9z7lzdJZt2b0lDw16A&callback=initMap';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}


document.addEventListener('DOMContentLoaded', loadGoogleMaps);
</script>
<?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </main>
    </div>
</div>
<style>

    .icon {
  width: 28px;
  height: 28px;
  margin-bottom: 8px;
}

    .highlights-container {
  border: 1px solid #ddd;
  padding: 8px 8px;
  border-radius: 6px;
  max-width: 900px;
  font-family: Arial, sans-serif;
}

.highlights-container h3 {
  font-weight: bold;
  margin-bottom: 15px;
}

.highlights-list {
  display: flex;
  gap: 30px;
}

.highlight-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 140px;
  text-align: center;
  font-size: 14px;
  cursor: default;
  user-select: none;
}

.icon {
  font-size: 28px;
  margin-bottom: 8px;
}

/* Small info icon styling */
.info {
  font-size: 14px;
  color: #555;
  margin-left: 4px;
  vertical-align: middle;
  cursor: help;
}

/* Responsive */
@media (max-width: 600px) {
  .highlights-list {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .highlight-item {
    width: 100%;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    text-align: left;
    margin-bottom: 12px;
  }
  
  .icon {
    font-size: 22px;
    margin-bottom: 0;
  }
}

.room-listing.location-section .hotel-rooms {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fafafa;
}

.room-listing.location-section .hotel-rooms button{
    background: #fbb191;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
}
.room-listing.location-section p {
    margin: 16px;
    font-size: revert-layer;
}
.mphb-children-ages-wrapper {
    margin-bottom: 15px;
}
</style>
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js" type="text/javascript"></script>
<script>
// ========== GOOGLE MAPS ==========

// PHP se safe data
const MAP_DATA = <?php echo json_encode([
    'lat'     => (float) $coordinates['lat'],
    'lng'     => (float) $coordinates['lng'],
    'name'    => (string) ($coordinates['name'] ?? ''),
    'address' => (string) ($coordinates['address'] ?? ''),
]); ?>;

function initMap() {
    if (!MAP_DATA || !MAP_DATA.lat || !MAP_DATA.lng) {
        console.error('Invalid map data:', MAP_DATA);
        return;
    }

    const coordinates = { lat: MAP_DATA.lat, lng: MAP_DATA.lng };

    const mapEl = document.getElementById('hotel-map');
    if (!mapEl) {
        console.error('#hotel-map element not found');
        return;
    }

    const map = new google.maps.Map(mapEl, {
        zoom: 15,
        center: coordinates,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: false,
        zoomControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        }
    });

    const marker = new google.maps.Marker({
        position: coordinates,
        map: map,
        title: MAP_DATA.name,
        animation: google.maps.Animation.DROP
    });

    const infoWindow = new google.maps.InfoWindow({
        content: '<div><strong>' + MAP_DATA.name + '</strong><br>' +
                 MAP_DATA.address + '</div>'
    });

    infoWindow.open(map, marker);
    marker.addListener('click', function () {
        infoWindow.open(map, marker);
    });
}

function toggleMapFullscreen() {
    const locationSection = document.querySelector('.location-section');
    const btn = document.querySelector('.map-button');
    if (!locationSection || !btn) return;

    if (locationSection.classList.contains('map-fullscreen')) {
        locationSection.classList.remove('map-fullscreen');
        btn.textContent = 'Full Screen';
    } else {
        locationSection.classList.add('map-fullscreen');
        btn.textContent = 'Exit Full Screen';
    }
}

function loadGoogleMaps() {
    if (window.google && window.google.maps) {
        initMap();
        return;
    }

    if (document.getElementById('google-maps-script')) {
        return;
    }

    const script = document.createElement('script');
    script.id = 'google-maps-script';
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBMwU9kvAENr9xXm9z7lzdJZt2b0lDw16A&callback=initMap';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

// ========== BOOKING + HP ROOMS ==========

jQuery(function ($) {
		
		function scrollToResults() {
    const resultsSection = document.querySelector('.room-listing.location-section');
    if (resultsSection) {
        resultsSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}
    // ---- dd/mm/yyyy parse for visible inputs ----
    function parseDate(str) {
        var parts = str.split('/');
        if (parts.length !== 3) return null;

        var d = parseInt(parts[0], 10);
        var m = parseInt(parts[1], 10) - 1; // 0-based
        var y = parseInt(parts[2], 10);

        var date = new Date(y, m, d);
        if (date.getFullYear() !== y || date.getMonth() !== m || date.getDate() !== d) {
            return null;
        }
        return date;
    }

    function showErrors($form, errors) {
        var $errBox = $form.find('.mphb-errors-wrapper');

        if (!errors.length) {
            $errBox.addClass('mphb-hide').html('');
            return;
        }

        var html = "<ul class='mphb-errors-list'>";
        errors.forEach(function (msg) {
            html += "<li>" + msg + "</li>";
        });
        html += "</ul>";

        $errBox.removeClass('mphb-hide').html(html);
    }

    function validateBookingForm($form) {
        var errors = [];

        var $checkInInput  = $form.find('.mphb-check-in-date-wrapper input[type="text"]');
        var $checkOutInput = $form.find('.mphb-check-out-date-wrapper input[type="text"]');
        var $adultsSelect  = $form.find('select[name="mphb_adults"]');
        var $childrenSelect= $form.find('select[name="mphb_children"]');

        var checkIn  = $.trim($checkInInput.val());
        var checkOut = $.trim($checkOutInput.val());
        var adults   = $adultsSelect.val();
        var children = $childrenSelect.val();

        if (!checkIn)  errors.push("Please select a check-in date.");
        if (!checkOut) errors.push("Please select a check-out date.");

        var inDate  = checkIn  ? parseDate(checkIn)  : null;
        var outDate = checkOut ? parseDate(checkOut) : null;

        if (checkIn && !inDate)   errors.push("Invalid check-in date format (dd/mm/yyyy).");
        if (checkOut && !outDate) errors.push("Invalid check-out date format (dd/mm/yyyy).");

        if (inDate && outDate && outDate <= inDate) {
            errors.push("Check-out must be after check-in.");
        }

        if (!adults || parseInt(adults, 10) < 1) {
            errors.push("At least 1 adult is required.");
        }
        if (children !== '' && parseInt(children, 10) < 0) {
            errors.push("Children cannot be negative.");
        }

        // Child age fields validation
        var childCount = parseInt(children || 0, 10);
        if (childCount > 0) {
            var $ageSelects = $form.find('select[name^="mphb_child_age"]');

            if ($ageSelects.length < childCount) {
                errors.push("Please select age for each child.");
            } else {
                var missingAge = false;
                $ageSelects.each(function () {
                    if (!$(this).val()) {
                        missingAge = true;
                        return false; // break
                    }
                });
                if (missingAge) {
                    errors.push("Please select age for each child.");
                }
            }
        }

        console.log('Validation errors:', errors);
        showErrors($form, errors);
        return errors.length === 0;
    }

    // Children age fields
    function updateChildAgeFields($form) {
        var $childrenSelect = $form.find('select[name="mphb_children"]');
        if (!$childrenSelect.length) return;

        var childrenCount = parseInt($childrenSelect.val() || 0, 10);

        var $wrapper = $form.find('.mphb-children-ages-wrapper');

        if (!$wrapper.length) {
            var $ref = $childrenSelect.closest('.mphb_widget_search-children, .mphb-children-wrapper, .mphb-guest-wrapper, p');
            if (!$ref.length) {
                $ref = $childrenSelect;
            }

            $wrapper = $('<div class="mphb-children-ages-wrapper"></div>');
            $wrapper.insertAfter($ref);
        }

        $wrapper.empty();

        if (!childrenCount || childrenCount <= 0) {
            return;
        }

        for (var i = 1; i <= childrenCount; i++) {
            var $field = $('<div class="mphb-child-age-field"></div>');
            var $label = $('<label></label>').text('Child ' + i + ' Age');
            var $select = $('<select required></select>')
                .attr('name', 'mphb_child_age[' + i + ']');

            $select.append('<option value="">Select age</option>');
            for (var age = 0; age <= 17; age++) {
                $select.append(
                    $('<option></option>')
                        .attr('value', age)
                        .text(age + ' yrs')
                );
            }

            $field.append($label).append($select);
            $wrapper.append($field);
        }
    }

    $('form').each(function () {
        var $form = $(this);
        if ($form.find('select[name="mphb_children"]').length) {
            updateChildAgeFields($form);
        }
    });

    $(document).on('change', 'select[name="mphb_children"]', function () {
        var $form = $(this).closest('form');
        updateChildAgeFields($form);
    });

    // ------------ MAIN CLICK HANDLER (Reserve/Search) ------------
    $('.mphb-reserve-btn.button').on('click', function(e) {
        e.preventDefault();

        var $form = $(this).closest('form');

        if (!validateBookingForm($form)) {
            console.log('Validation failed');
            return;
        }

        // FORM DATA
        var check_in  = $.trim($form.find('.mphb-check-in-date-wrapper input[type="text"]').val());
        var check_out = $.trim($form.find('.mphb-check-out-date-wrapper input[type="text"]').val());
        var adults    = $form.find('select[name="mphb_adults"]').val();
        var children  = $form.find('select[name="mphb_children"]').val();
        var room_type_id = $form.find('input[name="mphb_room_type_id"]').val();
		var entry_title = jQuery(".entry-title").text();
        var childAges = [];
        $form.find('select[name^="mphb_child_age"]').each(function () {
            var v = $(this).val();
            if (v !== '') {
                childAges.push(parseInt(v, 10));
            }
        });

        var capacity = (parseInt(adults, 10) || 0) + (parseInt(children, 10) || 0);
        console.log("Calculated capacity:", capacity);
		 console.log("entry_title:", entry_title);

        // 🔹 BOOKING DATA KO LOCALSTORAGE ME SAVE KARO
        var bookingData = {
            check_in: check_in,
            check_out: check_out,
            adults: parseInt(adults, 10) || 0,
            children: parseInt(children, 10) || 0,
            child_ages: childAges,
            capacity: capacity,
            room_type_id: room_type_id,
			hotel_name: entry_title
        };
        
        localStorage.setItem('bookingData', JSON.stringify(bookingData));
        console.log('Booking data saved to localStorage:', bookingData);

        console.log("FORM DATA => ", {
            check_in: check_in,
            check_out: check_out,
            adults: adults,
            children: children,
            room_type_id: room_type_id,
            child_ages: childAges
        });

        $('.room-listing.location-section').html(
            '<img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="Loading..." style="display:block;margin:0 auto;" />'
        );

        var HOTEL_ID = "<?php echo esc_js( $worldota_id ); ?>";

        $.post({
            url: "/wp-json/worldota/v1/hotel-info",
            contentType: "application/json",
            data: JSON.stringify({
                id: HOTEL_ID,
                check_in:  check_in,
                check_out: check_out,
                adults:    adults,
                children:  children,
                child_ages: childAges,
                room_type_id: room_type_id,
				hotel_name: entry_title
            }),
            success: function (response) {
                console.log("Full response:", response);

                const HOTEL_ID      = response.hotel_id || "";
                const allBookedFlag = response.all_rooms_booked === true;

                // 🔹 HP rates from debug.hp_raw
                let hpRates = [];
                try {
                    if (response.debug &&
                        response.debug.hp_raw &&
                        response.debug.hp_raw.data &&
                        Array.isArray(response.debug.hp_raw.data.hotels) &&
                        response.debug.hp_raw.data.hotels.length > 0) {
                        hpRates = response.debug.hp_raw.data.hotels[0].rates || [];
                    }
                } catch (e) {
                    console.error('Error reading hp_raw:', e);
                }

                console.log('hpRates:', hpRates);

                if (!hpRates.length) {
                    $('.room-listing.location-section').html(
                        '<p style="color:#c00;font-weight:bold;">No rates found from HP.</p>'
                    );
					scrollToResults(); 
                    return;
                }

                // Nights from backend (Y-m-d)
                function nightsBetween(ymdStart, ymdEnd) {
                    if (!ymdStart || !ymdEnd) return 1;
                    const parts1 = ymdStart.split('-');
                    const parts2 = ymdEnd.split('-');
                    if (parts1.length !== 3 || parts2.length !== 3) return 1;
                    const d1 = new Date(parseInt(parts1[0],10), parseInt(parts1[1],10)-1, parseInt(parts1[2],10));
                    const d2 = new Date(parseInt(parts2[0],10), parseInt(parts2[1],10)-1, parseInt(parts2[2],10));
                    const diffMs = d2.getTime() - d1.getTime();
                    const diffDays = diffMs / (1000 * 60 * 60 * 24);
                    return diffDays > 0 ? diffDays : 1;
                }

                const nights = nightsBetween(response.checkin, response.checkout);
                console.log("Nights:", nights);

                let html = "<div class='hotel-rooms'>";
                let visibleCount = 0;

                hpRates.forEach(rate => {
                    console.log('Rendering HP rate:', rate);
                    console.log('cancellation:', rate.payment_options.payment_types);
						
                    const roomName =
                        (rate.room_data_trans && rate.room_data_trans.main_name) ||
                        rate.room_name ||
                        'Room';

                    const bookHash = rate.book_hash || '';

                    // DAILY PRICE from daily_prices[0]
                    let dailyPriceRaw = null;
                    if (Array.isArray(rate.daily_prices) && rate.daily_prices.length > 0) {
                        dailyPriceRaw = rate.daily_prices[0];
                    }

                    if (dailyPriceRaw === null || dailyPriceRaw === undefined || bookHash === '') {
                        return;
                    }

                    const pricePerNight = Number(dailyPriceRaw);
                    const totalPrice    = pricePerNight * nights;

                    let imageUrl = "";
                    const defaultImageNoImage =
                        "https://img.freepik.com/free-photo/interior-modern-comfortable-hotel-room_1232-1822.jpg?semt=ais_hybrid&w=740&q=80";
                    const defaultImageBroken =
                        "https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500";

                    // agar rate me images nahi hai to default
                    imageUrl = defaultImageNoImage;
                    var currency_code = rate.no_show.currency_code;
					
					// ---- Prepare cancellation data ----
					let cancellationData = null;

					if (
						rate.payment_options &&
						rate.payment_options.payment_types &&
						Array.isArray(rate.payment_options.payment_types) &&
						rate.payment_options.payment_types.length > 0 &&
						rate.payment_options.payment_types[0].cancellation_penalties
					) {
						const paymentType = rate.payment_options.payment_types[0];
						const penalties   = paymentType.cancellation_penalties;

						cancellationData = {
							free_cancellation_before: penalties.free_cancellation_before || null,
							policies: penalties.policies || [],
							booking_amount: paymentType.amount || "0.00",
							currency: paymentType.currency_code || ""
						};
					}

					const cancellationEncoded = cancellationData
						? encodeURIComponent(JSON.stringify(cancellationData))
						: "";

                    visibleCount++;

                    html += `
                        <div class="room-box row align-items-start"
							 style="padding:15px;border:1px solid #ddd;margin-bottom:10px;border-radius:6px;">

						  <!-- LEFT : IMAGE -->
						  <div class="rom_left col-12 col-md-3 mb-3 mb-md-0">
							<img 
							  src="${imageUrl}" 
							  alt="Room Image" 
							  class="hotel_img img-fluid"
							  style="border-radius:5px;"
							  onerror="
								this.onerror=null;
								this.src='${defaultImageBroken}';
								var btn = this.closest('.room-box').querySelector('.select-room-btn');
								if (btn) { btn.setAttribute('data-image', '${defaultImageBroken}'); }
							  "
							>
						  </div>

						  <!-- CENTER : ROOM DETAILS -->
						  <div class="rom_center col-12 col-md-6">
							<h3 style="margin:0 0 8px 0;">${roomName}</h3>

							<p class="mb-1">
							  <strong>Price per night:</strong> $${pricePerNight.toFixed(2)}
							</p>

							<p class="mb-1">
							  <strong>Total (${nights} night${nights > 1 ? 's' : ''}):</strong>
							  $${totalPrice.toFixed(2)}
							</p>

							<p class="mb-0">
							  <strong>Amenities:</strong>
							  ${Array.isArray(rate.amenities_data) && rate.amenities_data.length > 0
								? rate.amenities_data.join(", ")
								: "No amenities listed"}
							</p>
						  </div>

						  <!-- RIGHT : META + CTA -->
						  <div class="rom_right col-12 col-md-3 mt-3 mt-md-0 text-md-end">
							<p class="mb-1">
							  <strong>Main Name:</strong>
							  ${rate.room_data_trans?.main_name || ""}
							</p>

							<p class="mb-2">
							  <strong>Capacity:</strong>
							  ${rate.rg_ext?.capacity || "N/A"}
							</p>

							<button 
							  class="select-room-btn btn"
							  data-hotel-id="${HOTEL_ID}"
							  data-currency_code="${currency_code}"
							  data-room-id="${rate.match_hash || ''}"
							  data-room-name="${roomName}"
							  data-nights="${nights}"
							  data-price="${totalPrice.toFixed(2)}"
							  data-price-per-night="${pricePerNight.toFixed(2)}"
							  data-capacity="${rate.rg_ext?.capacity || ''}"
							  data-image="${imageUrl}"
							  data-check-in="${check_in}"
							  data-check-out="${check_out}"
							  data-guests="${capacity}"
							  data-book-hash="${bookHash}"
							  data-cancellation="${cancellationEncoded}"
							  style="background:#ed6429;color:white;border:none;padding:8px 16px;border-radius:4px;font-size:14px;">
							  Select Room
							</button>
						  </div>

						</div>

                    `;
                });

                if (visibleCount === 0) {
                    $('.room-listing.location-section').html(
                        '<p style="color:#c00;font-weight:bold;">No rooms available Now due to prices issue.</p>'
                    );
					scrollToResults(); 
                    return;
                } 

                html += "</div>";
                $('.room-listing.location-section').html(html);
				scrollToResults(); 
            },
            error: function(err) {
                console.error("Error:", err);
                $('.room-listing.location-section').html('<p>Something went wrong while loading rooms.</p>');
				scrollToResults(); 
            }
        });
    });

    // SELECT ROOM
    $(document).on('click', '.select-room-btn', function () {
        const $btn = $(this);

        // 🔹 LOCALSTORAGE SE BOOKING DATA RETRIEVE KARO
        var bookingData = {};
        try {
            bookingData = JSON.parse(localStorage.getItem('bookingData')) || {};
        } catch (e) {
            console.error('Error reading bookingData from localStorage:', e);
        }

        const selectedRoom = {
            hotel_id:   $btn.data('hotel-id'),
            room_id:    $btn.data('room-id'),
            room_name:  $btn.data('room-name'),
            nights:  $btn.data('nights'),
            currency_code:  $btn.data('currency_code'),
            price:      parseFloat($btn.data('price')) || 0,
            price_per_night: parseFloat($btn.data('price-per-night')) || 0,
            capacity:   parseInt($btn.data('capacity')) || 0,
            image:      $btn.data('image'),
            check_in:   $btn.data('check-in'),
            check_out:  $btn.data('check-out'),
            guests:     parseInt($btn.data('guests')) || 0,
            book_hash:  $btn.attr('data-book-hash') || '',
            cancellation_option:  $btn.attr('data-cancellation') || '',
            
            // 🔹 ADULTS AUR CHILDREN ADD KARO
            adults:     bookingData.adults || 0,
            children:   bookingData.children || 0,
            child_ages: bookingData.child_ages || [],
			hotel_name:   bookingData.hotel_name || '',
			
        };

        console.log('Selected room payload with adults/children:', selectedRoom);

        localStorage.setItem('selectedRoom', JSON.stringify(selectedRoom));
        window.location.href = '/create-booking/';
        //window.location.href = '/booking-confirmation/';
    });

    // DOM ready ke baad maps & fullscreen button
    loadGoogleMaps();
    const mapBtn = document.querySelector('.map-button');
    if (mapBtn) {
        mapBtn.addEventListener('click', toggleMapFullscreen);
    }
});
</script>




<?php get_footer();  ?>


