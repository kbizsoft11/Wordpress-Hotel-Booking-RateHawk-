<?php 
 
$order = wc_get_order( $order_id );

// Fetch order meta
$check_in  = $order->get_meta( 'check_in' );
$hotel_name = $order->get_meta( '_hotel_name' );
$room_name = $order->get_meta( '_room_name' );
$check_out = $order->get_meta( 'check_out' );
$currency  = $order->get_meta( 'currency_code' );
$email     = $order->get_meta( 'email' );
$cancellation_option    = $order->get_meta( 'cancellation_option' );
$mobile    = $order->get_meta( 'mobile' );
$partner_id = $order->get_meta( 'ratehawk_partner_order_id' );
$total_nights = $order->get_meta( 'nights' );
$total_no_guests = $order->get_meta( 'guests' );
$check_in_date = DateTime::createFromFormat('d/m/Y', $check_in);
$cancel_deadline = clone $check_in_date;
$cancel_deadline->modify('-1 day');
?>

<?php
// Get cancellation JSON saved on order meta
$cancellation_option = $order->get_meta( 'cancellation_option' );

/* echo"<pre>";
print_r($cancellation_option);
die; */

// Decode cancellation data
$cancellation = [];
if ( ! empty( $cancellation_option ) ) {
	
    $decoded = json_decode( $cancellation_option, true );
	
    if ( is_array( $decoded ) ) {
        $cancellation = $decoded;
    }
}

// Default: cannot cancel
$can_cancel = false;

// Check free cancellation date
if (
    ! empty( $cancellation ) &&
    ! empty( $cancellation['free_cancellation_before'] )
) {
    $free_cancel_ts = strtotime( $cancellation['free_cancellation_before'] );
    $now_ts         = current_time( 'timestamp' ); // WP-safe time
	
    if ( $now_ts < $free_cancel_ts ) {
        $can_cancel = true;
    }
}
/* echo"<pre>";
echo"";
print_r($cancellation);
die;  */
?>


<!-- Hotel Booking Information -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Hotel Booking Details</h5>
    </div>

    <div class="card-body">

        <!-- Hotel Name -->
        <div class="mb-3">
            <h4 class="fw-bold mb-1"><?php echo $hotel_name; ?></h4>
            <p class="text-muted mb-0"><?php echo $room_name; ?></p>
        </div>

        <hr>
 
        <!-- Booking Info Grid -->
        <div class="row g-3">

            <div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Check-in</small>
                    <div class="fw-semibold"><?php echo $check_in; ?></div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Check-out</small>
                    <div class="fw-semibold"><?php echo $check_out; ?></div>
                </div>
            </div>
			
			<div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Email</small>
                    <div class="fw-semibold"><?php echo $email; ?></div>
                </div>
            </div>
			
			<div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Mobile</small>
                    <div class="fw-semibold"><?php echo $mobile; ?></div>
                </div>
            </div>
			
			<div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Partner Order</small>
                    <div class="fw-semibold"><?php echo $partner_id; ?></div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Nights</small>
                    <div class="fw-semibold"><?php echo $total_no_guests; ?></div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted">Total Guests</small>
                    <div class="fw-semibold"><?php echo $total_no_guests; ?></div>
                </div>
            </div>
			
			
			<div class="col-md-3 col-sm-6">
				 <div class="border rounded p-3 h-100">
					<small class="text-muted">Price</small>
					<div class="fw-semibold"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></div>
				</div>
			</div>
			
			<div class="col-md-3 col-sm-6">
				<div class="border rounded p-3 h-100">
				
					<small class="text-muted">Status</small>
					<div class="fw-semibold"><?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></div>
				</div>
			</div>
			
			<div class="col-md-5 col-sm-6">
				<div class="border rounded p-3 h-100">
				
					<div class="fw-semibold">
					<?php
						
						/* if (
							$today < $cancel_deadline &&
							$order->get_total_refunded() == 0  &&
							$order->get_meta('_refund_requested') !== 'yes'  
						) {
							
							$base_url = wc_get_account_endpoint_url('my-bookings');

							$refund_url = wp_nonce_url(
								$base_url . '?refund_request=' . $order_id,
								'ratehawk_refund_' . $order_id
							);
			

							echo '<a href="' . esc_url($refund_url) . '" class="button refund-request">
									Request Refund
								  </a>';
							
							
							
						} else {
							
							echo '<span class="booking-non-cancellable">Cancellation not allowed or Refund request raise already</span>';

						} */
						
						
						
						?>
						<div class="ratehawk-cancellation-box" style="margin-top:20px;">
							
							<?php if ( $can_cancel ) : ?>
								<?php if($order->get_meta('_refund_completed') !== 'complete' ){ ?>
									<?php
									$refund_url = wp_nonce_url(
										$base_url . '?refund_request=' . $order_id,
										'ratehawk_refund_' . $order_id
									);
									?>

									<a href="<?php echo esc_url($refund_url);?>'"
										class="button cancel-booking-btn"
										data-order-id="<?php echo esc_attr( $order->get_id() ); ?>">
										Cancel Booking
									</a>

									<p class="text-muted" style="margin-top:6px;">
										Free cancellation available until
										<strong>
											<?php echo esc_html( date_i18n( 'd M Y, H:i', strtotime( $cancellation['free_cancellation_before'] ) ) ); ?>
										</strong>
									</p>
								<?php } ?>

								<?php else : ?>

									<span class="text-muted">
										Cancellation period expired. This booking is non-refundable.
									</span>

								<?php endif; ?>
							
							

						</div>
					</div>
				</div>
			</div>
			
			

        </div>

        <hr>
        </div>

   </div>
