<?php

/**
 *
 * @since 4.2.0
 */
/*
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $user->ID ) {

	$userDisplayName = $user->data->display_name;
	$bookingsUrl     = mphb_create_url( 'bookings', '', $permalink );
	$detailsUrl      = mphb_create_url( 'account-details', '', $permalink );

	$allowed_html = array(
		'a' => array(
			'href' => array(),
		),
	);

	?>
	<p>
	<?php
		printf(
			wp_kses(
				__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>).', 'motopress-hotel-booking' ),
				$allowed_html
			),
			'<strong>' . esc_html( $userDisplayName ) . '</strong>',
			esc_url( wp_logout_url() )
		);
	?>
	</p>
	<p>
	<?php
		printf(
			wp_kses(
				__( 'From your account dashboard you can view <a href="%1$s">your recent bookings</a> or edit your <a href="%2$s">password and account details</a>.', 'motopress-hotel-booking' ),
				$allowed_html
			),
			esc_url( $bookingsUrl ),
			esc_url( $detailsUrl )
		);
	?>
	</p>
	<?php
}
*/?>
<?php
/**
 * Modern Dashboard Template
 *
 * @since 4.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( $user->ID ) {

    $userDisplayName = $user->data->display_name;
    $bookingsUrl     = mphb_create_url( 'bookings', '', $permalink );
    $detailsUrl      = mphb_create_url( 'account-details', '', $permalink );

    $allowed_html = array(
        'a' => array(
            'href' => array(),
        ),
    );

    // Enqueue or output CSS/JS if needed. Better to enqueue via functions.php.
    ?>
    <div class="mphb-container mphb-dashboard">
        <div class="mphb-card mphb-dashboard-card">
            <div class="mphb-dashboard-header">
                <div class="mphb-dashboard-title">
                    <h2><?php echo esc_html( $userDisplayName ); ?></h2>
                    <p class="mphb-subtle">
                        <?php
                        printf(
                            wp_kses(
                                __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>).', 'motopress-hotel-booking' ),
                                $allowed_html
                            ),
                            '<strong>' . esc_html( $userDisplayName ) . '</strong>',
                            esc_url( wp_logout_url() )
                        );
                        ?>
                    </p>
                </div>
            </div>

            <div class="mphb-dashboard-body">
                <p>
                    <?php
                    printf(
                        wp_kses(
                            __( 'From your account dashboard you can view <a href="%1$s">your recent bookings</a> or edit your <a href="%2$s">password and account details</a>.', 'motopress-hotel-booking' ),
                            $allowed_html
                        ),
                        esc_url( $bookingsUrl ),
                        esc_url( $detailsUrl )
                    );
                    ?>
                </p>

                <div class="mphb-actions">
                    <a class="mphb-btn" href="<?php echo esc_url( $bookingsUrl ); ?>"><?php esc_html_e( 'View Bookings', 'motopress-hotel-booking' ); ?></a>
                    <a class="mphb-btn mphb-btn-outline" href="<?php echo esc_url( $detailsUrl ); ?>"><?php esc_html_e( 'Account Details', 'motopress-hotel-booking' ); ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
