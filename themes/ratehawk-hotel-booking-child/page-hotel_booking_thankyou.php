<?php
/*
Template Name: RateHawk Thank You Page
*/
get_header();

/**
 * Example dynamic values
 * Replace these with:
 * - $_GET
 * - $_SESSION
 * - RateHawk API response
 */  

$booking_id   = $_GET['booking_id'] ?? 'RH-ORD-123456';
$hotel_name   = $_GET['hotel'] ?? 'Clermont Hotel London';
$room_name    = $_GET['room'] ?? 'Deluxe Double Room';
$check_in     = $_GET['check_in'] ?? '2026-02-15';
$check_out    = $_GET['check_out'] ?? '2026-02-18';
$nights       = $_GET['nights'] ?? 3;
$guests       = $_GET['guests'] ?? '2 Adults';
$total_price = $_GET['amount'] ?? '495.00';
$currency_code = $_GET['currency'] ?? '';

?>

<style>
body { 
  background: #f5f7fa;
}

.confirmation-box {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}

.success-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: #28a745;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  margin: 0 auto 15px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
  border-bottom: 1px solid #eee;
  padding-bottom: 8px;
  margin-bottom: 15px;
}

.info-label {
  color: #6c757d;
  font-size: 13px;
}

.info-value {
  font-weight: 600;
}

.price-box {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 15px;
}

.total-price {
  font-size: 22px;
  font-weight: 700;
  color: #ed6429;
}
</style>

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

<section class="hero-banner w-100">
    <div class="hero-overlay"></div>
    <div class="container h-100 d-flex align-items-center">
        <div class="hero-content">
            <h1 class="display-5 fw-bold">Booking Confirmed</h1>
           
        </div>
    </div>
</section>

<section class="py-5 bg-light" id="booking-summary">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="confirmation-box p-4 p-md-5">

        <!-- SUCCESS -->
        <div class="text-center mb-4">
          
          <p class="text-muted mb-0">
            Thank you for your booking! Your reservation has been successfully confirmed.
          </p>
        </div>

        <!-- BOOKING ID -->
        <div class="text-center mb-4">
          <span class="badge bg-light text-dark px-3 py-2">
            Booking ID: <strong><?php echo esc_html($booking_id); ?></strong>
          </span>
        </div>

        <!-- HOTEL DETAILS -->
        <div class="mb-4">
          <div class="section-title">Hotel & Room Details</div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="info-label">Hotel Name</div>
              <div class="info-value"><?php echo esc_html($hotel_name); ?></div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="info-label">Room Type</div>
              <div class="info-value"><?php echo esc_html($room_name); ?></div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="info-label">Guests</div>
              <div class="info-value"><?php echo esc_html($guests); ?></div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="info-label">Board Type</div>
              <div class="info-value">Room Only</div>
            </div>
          </div>
        </div>

        <!-- STAY DETAILS -->
        <div class="mb-4">
          <div class="section-title">Stay Details</div>

          <div class="row text-center">
            <div class="col-6 col-md-3 mb-3">
              <div class="info-label">Check-in</div>
              <div class="info-value"><?php echo esc_html($check_in); ?></div>
            </div>

            <div class="col-6 col-md-3 mb-3">
              <div class="info-label">Check-out</div>
              <div class="info-value"><?php echo esc_html($check_out); ?></div>
            </div>

            <div class="col-6 col-md-3 mb-3">
              <div class="info-label">Nights</div>
              <div class="info-value"><?php echo esc_html($nights); ?></div>
            </div>

            <div class="col-6 col-md-3 mb-3">
              <div class="info-label">Rooms</div>
              <div class="info-value">1</div>
            </div>
          </div>
        </div>

        <!-- PRICE -->
        <div class="mb-4">
          <div class="section-title">Payment Summary</div>

          <div class="price-box">
         
            <div class="d-flex justify-content-between align-items-center">
              <span>Total Paid</span>
              <span class="total-price"><?php echo $currency_code; ?> <?php echo esc_html($total_price); ?></span>
            </div>
          </div>
        </div>

        <!-- NEXT STEPS -->
        <div class="mb-4">
          <div class="section-title">What Happens Next?</div>
          <ul class="mb-0">
            <li>You will receive a confirmation email shortly.</li>
            <li>Please carry a valid photo ID at check-in.</li>
          </ul>
        </div>

        <!-- ACTIONS -->
        <div class="text-center mt-4">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline-secondary me-2">
            Back to Home
          </a>
          <button onclick="window.print()" class="btn btn-primary">
            Print Booking
          </button>
        </div>

      </div>

    </div>
  </div>
</div>
</section>

<script>
localStorage.removeItem('selectedRoom');
localStorage.removeItem('bookingData');
</script>
<?php get_footer(); ?>
