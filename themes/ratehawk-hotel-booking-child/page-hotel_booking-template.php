<?php
/**
 * Template Name: Hotel Booking Template
 */
get_header();
?>

<style>
	/* Banner Styling */
	.hero-banner {
		background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945') center/cover no-repeat;
		height: 420px;
		position: relative;
		color: #fff;
	}
	.hero-overlay {
		background: rgba(0,0,0,0.55);
		position: absolute;
		inset: 0;
	}
	.hero-content {
		position: relative;
		z-index: 1;
	}
</style>

<!-- ===== FULL WIDTH BANNER ===== -->
 
<section class="hero-banner w-100">
    <div class="hero-overlay"></div>
    <div class="container h-100 d-flex align-items-center">
        <div class="hero-content">
            <h1 class="display-5 fw-bold">Booking information</h1>
            <p class="lead mb-4">
                Best prices • Free cancellation • Instant confirmation
            </p>
           
        </div>
    </div>
</section>

<form id="booking-form">
<section class="py-5 bg-light" id="booking-summary">
<div class="container my-5">
	<div class="row g-4">
		<div class="col-lg-12">
			<div class="card mb-4 shadow-sm">
				<div class="card-body">
					<h5 class="mb-3">Your Stay</h5>

						<div class="row">
							<div class="col-md-3">
								<small class="text-muted">Check-in</small>
								<p class="fw-semibold mb-0 checkin-date" id="checkin-date">-</p>
							</div>

							<div class="col-md-3">
								<small class="text-muted">Check-out</small>
								<p class="fw-semibold mb-0 checkout-date" id="checkout-date">-</p>
							</div>
							
							<div class="col-md-3">
								<small class="text-muted">Guests</small>
								<p class="fw-semibold mb-0 total_guests" id="total_guests">-</p>
								
							</div>
							
							<div class="col-md-3">
								<small class="text-muted">Adults</small>
								<p class="fw-semibold mb-0 total_adults" id="total_adults">-</p>
							</div>
							
							<div class="col-md-3">
								<small class="text-muted">Child</small>
								<p class="fw-semibold mb-0 total_child" id="total_child">-</p>
							</div>

							<div class="col-md-3">
								<small class="text-muted">Nights</small>
								<p class="fw-semibold mb-0 total-nights" id="total-nights">-</p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- Guest Details -->
            <div class="card mb-4">
                <div class="card-header">Primary Guest Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <select class="form-select">
                                <option>Mr</option>
                                <option>Ms</option>
                                <option>Mrs</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile" required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" rows="2" placeholder="Special Requests (Optional)"></textarea>
                        </div>
                    </div>
                </div>
				
				
            </div>
			
						<!-- Additional Guests -->
			<div class="card mb-4" id="additional-guests-card" style="display:none;">
				<div class="card-header">Additional Guests</div>
				<div class="card-body" id="additional-guests-container">
					<!-- Dynamic guest fields will be injected here -->
				</div>
			</div>
			
			<!-- Children Details -->
			<div class="card mb-4" id="children-card" style="display:none;">
				<div class="card-header">Children Details</div>
				<div class="card-body" id="children-container">
					<!-- Child age fields injected here -->
				</div>
			</div>

            <!-- Cancellation Policy -->
            <div class="card mb-4">
                <div class="card-header">Cancellation Policy</div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Free cancellation before <strong>24 hours</strong> of check-in</li>
                        <li>1 night charge applies after cancellation window</li>
                        <li>No-show will be fully charged</li>
                    </ul>
                </div>
            </div>

            <!-- Coupon Code -->
            <!--<div class="card mb-4">
                <div class="card-header">Apply Coupon</div>
                <div class="card-body d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Enter coupon code">
                    <button class="btn btn-outline-primary">Apply</button>
                </div>
            </div>-->

            <!-- Payment Method -->
            <!--<div style="display:none;" class="card mb-4">
                <div class="card-header">Payment Method</div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" checked>
                        <label class="form-check-label">Pay at Hotel</label>
                    </div>
                </div>
            </div>-->

            <!-- Confirm -->
            <div class="card">
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" required>
                        <label class="form-check-label">
                            I agree to the cancellation policy & hotel rules
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Continue to Payment
                    </button>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
            <div class="card position-sticky top-0">

                <div class="card-header"><strong>Booking Summary</strong></div>
                <div class="card-body">
                    <h6 class="fw-bold mb-1" id="hotel_name">-</h6>
                    <p class="mb-1" id="room_name">-</p>
                  
                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Room Price / Night</span>
                        <span id="room_price">-</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between price-total">
                        <span>Total Payable</span>
                        <span id='price_total'>-</span>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
</section>
<?php
	$creds    = worldota_get_creds();
    $mode = $creds['mode'] ?? '';
?>
<input type="hidden" id="room_id" name="room_id" />
<input type="hidden" id="hotel_id" name="hotel_id" />
<input type="hidden" id="book_hash" name="book_hash" />
<input type="hidden" id="final_payment" name="final_payment" />
<input type="hidden" id="currency_code" name="currency_code" />
<input type="hidden" id="check_in" name="check_in" />
<input type="hidden" id="check_out" name="room_id" />
<input type="hidden" id="hotel_name_id" name="hotel_name" />
<input type="hidden" id="room_name_id" name="room_name" />
<input type="hidden" id="total_nights" name="total_nights" />
<input type="hidden" id="total_no_guests" name="total_no_guests" />
<input type="hidden" id="cancellation_option" name="cancellation_option" />

</form>

<!----Fill out the booking information to page----->
<script>
jQuery(document).ready(function ($) {

    // Get localStorage item
    let selectedRoom = localStorage.getItem('selectedRoom');
    let bookingData = localStorage.getItem('bookingData');
	
	var bookingMode = "<?php echo esc_js($mode); ?>";
	//console.log(bookingMode);
    if (selectedRoom) {
        let roomData = JSON.parse(selectedRoom);
		let cancellationOption = null;

		if (roomData.cancellation_option) {
			cancellationOption = JSON.parse(
				decodeURIComponent(roomData.cancellation_option)
			);
			 $('#cancellation_option').val(
				JSON.stringify(cancellationOption)
			);
			
		}
		 

		//console.log("roomData"+JSON.stringify(roomData)); 
		// Stay details
		jQuery('#checkin-date').text(roomData.check_in);
		jQuery('#check_in').val(roomData.check_in);
		
		jQuery('#checkout-date').text(roomData.check_out);
		jQuery('#check_out').val(roomData.check_out);
		$('#total-nights').text(roomData.nights);
		$('#total_nights').val(roomData.nights);

		// Guest details
		//$('#adult-count').text(room.guests);
		//$('#child-count').text(room.children);
		jQuery('#total_guests').text(roomData.guests);
		jQuery('#total_no_guests').val(roomData.guests);
		
		jQuery('#total_adults').text(roomData.adults);
		jQuery('#total_child').text(roomData.children);
		jQuery('#child_ages').text(roomData.child_ages);
		
		/****load for additional guests*****/
		
		renderAdditionalGuests(
			parseInt(roomData.adults),
			parseInt(roomData.children),
			roomData.child_ages || []
		);

		// Price summary
		jQuery('#room-name').text(roomData.room_name);
		jQuery('#price_total').text(roomData.currency_code+" "+roomData.price);
		jQuery('#currency_code').val(roomData.currency_code);
		jQuery('#final_payment').val(roomData.price);
		jQuery('#room_price').text(roomData.currency_code+" "+roomData.price_per_night);
		jQuery('#hotel_name').text(roomData.hotel_name);
		jQuery('#hotel_name_id').val(roomData.hotel_name);
		jQuery('#room_name').text(roomData.room_name);
		jQuery('#room_name_id').val(roomData.room_name);
		jQuery('#room_id').val(roomData.room_id);
		
		if (bookingMode === 'live') {
			jQuery('#hotel_id').val(roomData.hotel_id);
		} else {
			jQuery('#hotel_id').val("test_hotel_do_not_book");
		}
		 
		jQuery('#book_hash').val(roomData.book_hash);

    } 
});
</script>

<!---send data for booking---->
<script>
jQuery(document).ready(function ($) {

  $('#booking-form').on('submit', function (e) {
    e.preventDefault();
	
	const additionalAdults = collectAdditionalAdults();
	const childrenGuests   = collectChildren();

	// Primary guest (always first)
	let guests = [
		{
			first_name: $('input[name="first_name"]').val(),
			last_name: $('input[name="last_name"]').val()
		}
	];

	// Add additional adults
	guests = guests.concat(additionalAdults);

	// Add children
	guests = guests.concat(childrenGuests);
	 

    // Collect form + hidden values
    let payload = {
      first_name: $('input[name="first_name"]').val(),
      last_name: $('input[name="last_name"]').val(),
      email: $('input[name="email"]').val(),
      mobile: $('input[name="mobile"]').val(),

      room_id: $('#room_id').val(),
      hotel_id: $('#hotel_id').val(),
      hotel_name: $('#hotel_name_id').val(),
      room_name: $('#room_name_id').val(),
      book_hash: $('#book_hash').val(),
      total_no_guests: $('#total_no_guests').val(),
      total_nights: $('#total_nights').val(),

      final_payment: $('#final_payment').val(),
      currency_code: $('#currency_code').val(),

      check_in: $('#check_in').val(),
      check_out: $('#check_out').val(),
      cancellation_option: $('#cancellation_option').val(),
      guests: $('#total_guests').text(),
	  rooms: [
		{
		  guests: guests
		}
	  ]
    };

    // ?? CREATE WOO ORDER (NOT BOOKING)
    $.ajax({
      url: '/wp-json/worldota/v1/create-wc-order',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(payload),
      beforeSend: function () {
        $('button[type="submit"]').prop('disabled', true).text('Redirecting...');
      },
      success: function (res) {
        if (res.success && res.checkout_url) {
          window.location.href = res.checkout_url;
        } else {
          alert(res.message);
        }
      },
      error: function () {
        alert('Something went wrong.');
      }
    });

  });

});
</script>
<!-----code if having multiple guests---->

<script>
function renderAdditionalGuests(adults, children, childAges = []) {

    /* ================= ADULTS ================= */
    const adultContainer = jQuery('#additional-guests-container');
    adultContainer.empty();

    if (adults > 1) {
        jQuery('#additional-guests-card').show();

        for (let i = 2; i <= adults; i++) {
            adultContainer.append(`
                <div class="row g-3 mb-3 guest-row adult-row">
                    <div class="col-md-6">
                        <input type="text"
                            class="form-control adult-first-name"
                            placeholder="Adult ${i} First Name"
                            required>
                    </div>
                    <div class="col-md-6">
                        <input type="text"
                            class="form-control adult-last-name"
                            placeholder="Adult ${i} Last Name"
                            required>
                    </div>
                </div>
            `);
        }
    } else {
        jQuery('#additional-guests-card').hide();
    }

    /* ================= CHILDREN ================= */
    const childContainer = jQuery('#children-container');
    childContainer.empty();

    if (children > 0) {
        jQuery('#children-card').show();

        for (let i = 1; i <= children; i++) {
            const ageValue = childAges[i - 1] || '';

            childContainer.append(`
                <div class="row g-3 mb-3 child-row">
                    <div class="col-md-4">
                        <input type="text"
                            class="form-control child-first-name"
                            placeholder="Child ${i} First Name">
                    </div>
                    <div class="col-md-4">
                        <input type="text"
                            class="form-control child-last-name"
                            placeholder="Child ${i} Last Name">
                    </div>
                    <div class="col-md-4">
                        <input type="number"
                            class="form-control child-age"
                            placeholder="Age"
                            min="0"
                            max="17"
                            value="${ageValue}"
                            required>
                    </div>
                </div>
            `);
        }
    } else {
        jQuery('#children-card').hide();
    }
}


//collection for adults and Child

function collectAdditionalAdults() {
    let adults = [];

    jQuery('.adult-row').each(function () {
        const first = jQuery(this).find('.adult-first-name').val();
        const last  = jQuery(this).find('.adult-last-name').val();

        if (first && last) {
            adults.push({
                first_name: first,
                last_name: last
            });
        }
    });

    return adults;
}

function collectChildren() {
    let children = [];

    jQuery('.child-row').each(function () {
        const first = jQuery(this).find('.child-first-name').val();
        const last  = jQuery(this).find('.child-last-name').val();
        const age   = jQuery(this).find('.child-age').val();

        if (age) {
            children.push({
                first_name: first || '',
                last_name: last || '',
                age: parseInt(age, 10),
                is_child: true
            });
        }
    });

    return children;
}

</script>

<?php get_footer(); ?>
