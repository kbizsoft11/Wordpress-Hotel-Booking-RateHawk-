<?php

if ( ! session_id() ) {
@session_start();
}

get_header(); ?>

<?php if ( have_posts() ) : ?>
<?php
the_archive_title( '<h2 class="page-title">', '</h2>' );
the_archive_description( '<div class="taxonomy-description">', '</div>' );
?>
<?php endif; ?>

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
                            <img src="https://ratehawk.scalon.in/wp-content/themes/destination-hotel-booking/assets/images/sliderimage.png"
                                alt="Default Image" />
                        </span>
                        <?php endif; ?>

                        <span class="room-price"><?php mphb_tmpl_the_room_type_default_price(); ?></span>
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
                                    <span><img src="https://cdn6.agoda.net/images/property/highlights/like.svg"
                                            alt="Great for activities" class="icon" /></span>
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
                        <?php
}
}
?>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- RIGHT: Booking Form -->
                    <div class="right-content">
                        <span class="room-booking-form">
                            <?php echo do_shortcode( '[mphb_availability id="' . get_the_ID() . '"]' ); ?>
                        </span>
                        <?php
                            $coordinates = get_hotel_coordinates();
                            if ($coordinates):
                        ?>

                        <!-- here print the  hotel rooms  -->

                        <div class="room-listing location-section">
                            <!-- <p>Test</p> -->
                        </div>


                        <div class="location-section">
                            <div class="location-header">
                                <div>
                                    <h3 class="location-title">Location</h3>
                                    <div class="location-subtitle">
                                        <a href="https://www.google.com/maps/search/<?php echo urlencode($coordinates['name'].' '.$coordinates['address']); ?>/@<?php echo $coordinates['lat']; ?>,<?php echo $coordinates['lng']; ?>,15z"
                                            target="_blank" style="">
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

                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </main>
    </div>
</div>
<style>
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
    background-color: rgba(0, 0, 0, 0.5);
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

.location-section {
    margin: 30px 0;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    max-height: 500px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fafafa;
    scroll-behavior: smooth;
}

.room-listing.location-section .hotel-rooms button {
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
</style>
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js" type="text/javascript"></script>
<script>

// let selectedAdults = null;

// // capture when user selects it
// $(document).on('change', 'select[name="mphb_adults"]', function () {
//     selectedAdults = $(this).val();
// });

// // read on button click
// $('#checkBtn').on('click', function () {
//     alert(selectedAdults);
// });


$(document).ready(function() {
    $('.mphb-reserve-btn.button').on('click', function(e) {
        e.preventDefault();
        $('.room-listing.location-section').html(
            '<img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="Loading..." style="display:block;margin:0 auto;" />'
        );

        // let totalPerson = $('select[name="mphb_adults"]').val();
        // alert(totalPerson);



        // return false;
        $.post({
            url: "/wp-json/worldota/v1/hotel-info",
            contentType: "application/json",
            data: JSON.stringify({
                id: "sofitel_la_at_beverly_hills"
            }),

            success: function(response) {

                let html = "<div class='hotel-rooms'>";

                response.forEach(room => {
                    if (!room.rg_ext || !room.rg_ext.capacity || room.rg_ext
                        .capacity == 0) {
                        return; 
                    }
                    html += `
                        <div class="room-box" style="padding:15px;border:1px solid #ddd;margin-bottom:10px;border-radius:6px;">
                            <h3 style="margin:0 0 8px 0;">${room.name}</h3>
                            <p><strong>Room Group ID:</strong> ${room.room_group_id}</p>
                            <p>
                                <strong>Amenities:</strong> 
                                ${room.room_amenities && room.room_amenities.length > 0 
                                ? room.room_amenities.join(", ") 
                                : "No amenities listed"}
                            </p>
                            <p><strong>Main Name:</strong> ${room.name_struct?.main_name || ""}</p>
                            <p><strong>Quality Level:</strong> ${room.rg_ext?.quality || "0"}</p>
                            <p><strong>Bathroom:</strong> ${room.rg_ext?.bathroom || "0"}</p>
                            <p><strong>Capacity:</strong> ${room.rg_ext?.capacity || "N/A"}</p>
                            <button onclick='window.location.href="booking-confirmation"' style="background:#ed6429;color:white;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;font-size:14px;">Select Room</button>
                        </div>
                        `;
                });

                html += "</div>";

                $('.room-listing.location-section').html(html);

                console.log("Hotel Info:", response);
            },

            error: function(err) {
                console.error("Error:", err);
            }
        });
    });


});

function initMap() {
    const coordinates = {
        lat: <?php echo $coordinates['lat']; ?>
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




<?php get_footer(); 