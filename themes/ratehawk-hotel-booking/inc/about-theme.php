<?php
/**
 * Destination Hotel Booking Theme Page
 *
 * @package Destination Hotel Booking
 */

function destination_hotel_booking_admin_scripts() {
	wp_dequeue_script('destination-hotel-booking-custom-scripts');
}
add_action( 'admin_enqueue_scripts', 'destination_hotel_booking_admin_scripts' );

if ( ! defined( 'DESTINATION_HOTEL_BOOKING_FREE_THEME_URL' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_FREE_THEME_URL', 'https://www.themespride.com/products/destination-hotel-booking' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_URL' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_URL', 'https://www.themespride.com/products/hotel-wordpress-theme' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_DEMO_THEME_URL' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_DEMO_THEME_URL', 'https://page.themespride.com/destination-hotel-booking/' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_DOCS_THEME_URL' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_DOCS_THEME_URL', 'https://page.themespride.com/demo/docs/destination-hotel-booking-lite/' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_RATE_THEME_URL' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_RATE_THEME_URL', 'https://wordpress.org/support/theme/destination-hotel-booking/reviews/#new-post' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_CHANGELOG_THEME_URL' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_CHANGELOG_THEME_URL', get_template_directory() . '/readme.txt' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_SUPPORT_THEME_URL' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/destination-hotel-booking/' );
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_THEME_BUNDLE' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_THEME_BUNDLE', 'https://www.themespride.com/products/wordpress-theme-bundle' );
}

/**
 * Add theme page
 */
function destination_hotel_booking_menu() {
	add_theme_page( esc_html__( 'About Theme', 'destination-hotel-booking' ), esc_html__( 'Begin Installation - Import Demo', 'destination-hotel-booking' ), 'edit_theme_options', 'destination-hotel-booking-about', 'destination_hotel_booking_about_display' );
}
add_action( 'admin_menu', 'destination_hotel_booking_menu' );

/**
 * Display About page
 */
function destination_hotel_booking_about_display() {
	$destination_hotel_booking_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $destination_hotel_booking_theme ); ?></h1>
		


		<?php
			destination_hotel_booking_demo_import();

			destination_hotel_booking_main_screen();

			destination_hotel_booking_changelog_screen();

			destination_hotel_booking_free_vs_pro();

			destination_hotel_booking_get_bundle();

		?>
	</div>

	<?php
}


/**
 * Output the Demo Import screen.
 */

function destination_hotel_booking_demo_import() {
    if ( isset( $_GET['page'] ) && 'destination-hotel-booking-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {

         // Path to whizzie.php in child theme
	    $child_whizzie_path = get_stylesheet_directory() . '/inc/whizzie.php';
	    
	    // Path to whizzie.php in parent theme
	    $parent_whizzie_path = get_template_directory() . '/inc/whizzie.php';

	    // Check if the child theme is active and if whizzie.php exists in the child theme
	    if ( file_exists( $child_whizzie_path ) ) {
	        require_once $child_whizzie_path;
	    } else {
	        // Fallback to parent theme if child theme does not have whizzie.php
	        require_once $parent_whizzie_path;
	    }

        if ( isset( $_GET['import-demo'] ) && $_GET['import-demo'] == true ) { ?>
            <div class="col card success-demo" style="text-align: center;">
                <p class="imp-success"><?php echo esc_html__('Imported Successfully', 'destination-hotel-booking'); ?></p><br>
                <a class="button" href="<?php echo esc_url(home_url('/')); ?>" target="_blank">
                    <?php echo esc_html__('View Site', 'destination-hotel-booking'); ?>
                </a>
            </div>

            <!-- Modal Popup -->
            <div id="demo-success-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
                <div style="background: #fff; padding:3em; max-width: 500px; margin: 15% auto; text-align: center;">
                	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/demo-icon.png" alt="icon" />
                    <h2 style="margin-bottom: 3em; margin-top: 15px">
					    <?php echo esc_html__('Logistic Provider Is Successfully Installed.', 'destination-hotel-booking'); ?>
					</h2>
                    <button onclick="document.getElementById('demo-success-modal').style.display='none'">
                       <a class="view-demo-btn" href="<?php echo esc_url(home_url('/')); ?>" target="_blank">
                    		<?php echo esc_html__('View Site', 'destination-hotel-booking'); ?>
                	</a>
                    </button>
                    <!-- Get Started button -->
					<button onclick="document.getElementById('demo-success-modal').style.display='none'">
					    <a class="view-dashboard" href="<?php echo esc_url( admin_url( 'themes.php?page=destination-hotel-booking-about' ) ); ?>">
					        <?php echo esc_html__( 'Return To Dashboard', 'destination-hotel-booking' ); ?>
					    </a>
					</button>

                </div>
            </div>

            <script type="text/javascript">
                window.onload = function () {
                    // Show the popup modal after load
                    document.getElementById('demo-success-modal').style.display = 'block';
                };
            </script>
        <?php } else { ?>
        	<div class="content-row">
	            <div class="col card demo-btn text-center">
	                <form id="demo-importer-form" action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php" method="POST">
	                    <p class="demo-title"><?php echo esc_html__('Demo Importer', 'destination-hotel-booking'); ?></p>
	                    <p class="demo-des"><?php echo esc_html__('This theme supports importing demo content with a single click. Use the button below to quickly set up your site. You can easily customize or deactivate the imported content later through the Customizer.', 'destination-hotel-booking'); ?></p>
	                    <i class="fas fa-long-arrow-alt-down"></i>

	                    <button type="submit" class="button with-icon" id="begin-install-btn">
	                        <?php echo esc_html__('Begin Installation - Import Demo', 'destination-hotel-booking'); ?>
	                    </button>

	                    <!-- Loader area shown in page content -->
	                    <div id="page-loader" style="display:none; margin-top: 20px; text-align: center;">
	                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/loader.png" alt="Loading..." width="40" height="40" />
	                        <p style="margin-top:10px;"><?php echo esc_html__('Importing demo, please wait...', 'destination-hotel-booking'); ?></p>
	                    </div>
	                </form>
	            </div>
	        
						<div class="price-img">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="theme-img" />
						</div>
					</div>
			
				</div>
	        </div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#demo-importer-form').on('submit', function(e) {
                        e.preventDefault();

                        if (confirm("Are you sure you want to proceed with the demo import?")) {
                            $('#page-loader').show(); // Show loader
                            
                            // Redirect to same page with import-demo param
                            var url = new URL(window.location.href);
                            url.searchParams.append('import-demo', 'true');
                            window.location.href = url;
                        } else {
                            return false;
                        }
                    });
                });
            </script>
        <?php }
    }
}

/**
 * Output the main about screen.
 */
function destination_hotel_booking_main_screen() {
	if ( isset( $_GET['tab'] ) && 'about_theme' === $_GET['tab'] ) {
	?>
	<div class="content-row">
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'destination-hotel-booking' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'destination-hotel-booking' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'destination-hotel-booking' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'destination-hotel-booking' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'destination-hotel-booking' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( DESTINATION_HOTEL_BOOKING_SUPPORT_THEME_URL ); ?>" class="button button-primary"><?php esc_html_e( 'Support Forum', 'destination-hotel-booking' ); ?></a></p>
			</div>
		</div>
		<div class="theme-price col card">
			<div class="price-flex">
				<div class="price-content">
					<h3><?php esc_html_e( 'Destination Hotel Booking WordPress Theme', 'destination-hotel-booking' ); ?></h3>
					<p class="main-flash"><?php 
					  printf(
					    /* translators: 1: bold FLASH DEAL text, 2: discount code */
					    esc_html__( '%1$s - Get 20%% Discount on All Themes, Use code %2$s', 'destination-hotel-booking' ),
					    '<strong class="bold-text">' . esc_html__( 'FLASH DEAL', 'destination-hotel-booking' ) . '</strong>',
					    '<strong class="bold-text">' . esc_html__( 'QBSALE20', 'destination-hotel-booking' ) . '</strong>'
					  ); 
					  ?></p>
					 <p>
					  <del><?php echo esc_html__( '$59', 'destination-hotel-booking' ); ?></del>
					  <strong class="bold-price"><?php echo esc_html__( '$39', 'destination-hotel-booking' ); ?></strong>
					</p>
				</div>
				<div class="price-img">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/theme-img.png" alt="theme-img" />
				</div>
			</div>
	
		</div>
	</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function destination_hotel_booking_changelog_screen() {
	if ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) {
		global $wp_filesystem;
	?>
	<div class="content-row">
		<div class="wrap about-wrap change-log">
			<?php
				$changelog_file = apply_filters( 'destination_hotel_booking_changelog_file', DESTINATION_HOTEL_BOOKING_CHANGELOG_THEME_URL );
				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = destination_hotel_booking_parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<div class="theme-price col card">
				<div class="price-flex">
					<div class="price-content">
						<h3><?php esc_html_e( 'Destination Hotel Booking WordPress Theme', 'destination-hotel-booking' ); ?></h3>
						<p class="main-flash"><?php 
						  printf(
						    /* translators: 1: bold FLASH DEAL text, 2: discount code */
						    esc_html__( '%1$s - Get 20%% Discount on All Themes, Use code %2$s', 'destination-hotel-booking' ),
						    '<strong class="bold-text">' . esc_html__( 'FLASH DEAL', 'destination-hotel-booking' ) . '</strong>',
						    '<strong class="bold-text">' . esc_html__( 'QBSALE20', 'destination-hotel-booking' ) . '</strong>'
						  ); 
						  ?></p>
						 <p>
						  <del><?php echo esc_html__( '$59', 'destination-hotel-booking' ); ?></del>
						  <strong class="bold-price"><?php echo esc_html__( '$39', 'destination-hotel-booking' ); ?></strong>
						</p>
					</div>
					<div class="price-img">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/theme-img.png" alt="theme-img" />
					</div>
				</div>
			
			</div>
	</div>
	<?php
	}
}

/**
 * Parse changelog from readme file.
 * @param  string $content
 * @return string
 */
function destination_hotel_booking_parse_changelog( $content ) {
	// Explode content with ==  to juse separate main content to array of headings.
	$content = explode ( '== ', $content );

	$changelog_isolated = '';

	// Get element with 'Changelog ==' as starting string, i.e isolate changelog.
	foreach ( $content as $key => $value ) {
		if (strpos( $value, 'Changelog ==') === 0) {
	    	$changelog_isolated = str_replace( 'Changelog ==', '', $value );
	    }
	}

	// Now Explode $changelog_isolated to manupulate it to add html elements.
	$changelog_array = explode( '= ', $changelog_isolated );

	// Unset first element as it is empty.
	unset( $changelog_array[0] );

	$changelog = '<pre class="changelog">';

	foreach ( $changelog_array as $value) {
		// Replace all enter (\n) elements with </span><span> , opening and closing span will be added in next process.
		$value = preg_replace( '/\n+/', '</span><span>', $value );

		// Add openinf and closing div and span, only first span element will have heading class.
		$value = '<div class="block"><span class="heading">= ' . $value . '</span></div>';

		// Remove empty <span></span> element which newr formed at the end.
		$changelog .= str_replace( '<span></span>', '', $value );
	}

	$changelog .= '</pre>';

	return wp_kses_post( $changelog );
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function destination_hotel_booking_free_vs_pro() {
	if ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) {
	?>
	<div class="content-row">
		<div class="wrap about-wrap change-log">
			<p class="about-description"><?php esc_html_e( 'View Free vs Pro Table below:', 'destination-hotel-booking' ); ?></p>
			<div class="vs-theme-table">
				<table>
					<thead>
						<tr><th scope="col"></th>
							<th class="head" scope="col"><?php esc_html_e( 'Free Theme', 'destination-hotel-booking' ); ?></th>
							<th class="head" scope="col"><?php esc_html_e( 'Pro Theme', 'destination-hotel-booking' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><span><?php esc_html_e( 'Theme Demo Set Up', 'destination-hotel-booking' ); ?></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Templates, Color options and Fonts', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Included Demo Content', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Section Ordering', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Multiple Sections', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Plugins', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Premium Technical Support', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Access to Support Forums', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Free updates', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Unlimited Domains', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Responsive Design', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Live Customizer', 'destination-hotel-booking' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td class="feature feature--empty"></td>
							<td class="feature feature--empty"></td>
							<td headers="comp-2" class="td-btn-2"><a class="sidebar-button single-btn" href="<?php echo esc_url(DESTINATION_HOTEL_BOOKING_PRO_THEME_URL);?>" target="_blank"><?php esc_html_e( 'Go For Premium', 'destination-hotel-booking' ); ?></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="theme-price col card">
			<div class="price-flex">
				<div class="price-content">
					<h3><?php esc_html_e( 'Destination Hotel Booking WordPress Theme', 'destination-hotel-booking' ); ?></h3>
					<p class="main-flash"><?php 
					  printf(
					    /* translators: 1: bold FLASH DEAL text, 2: discount code */
					    esc_html__( '%1$s - Get 20%% Discount on All Themes, Use code %2$s', 'destination-hotel-booking' ),
					    '<strong class="bold-text">' . esc_html__( 'FLASH DEAL', 'destination-hotel-booking' ) . '</strong>',
					    '<strong class="bold-text">' . esc_html__( 'QBSALE20', 'destination-hotel-booking' ) . '</strong>'
					  ); 
					  ?></p>
					 <p>
					  <del><?php echo esc_html__( '$59', 'destination-hotel-booking' ); ?></del>
					  <strong class="bold-price"><?php echo esc_html__( '$39', 'destination-hotel-booking' ); ?></strong>
					</p>
				</div>
				<div class="price-img">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/theme-img.png" alt="theme-img" />
				</div>
			</div>
		
		</div>
	</div>
	<?php
	}
}

function destination_hotel_booking_get_bundle() {
	if ( isset( $_GET['tab'] ) && 'get_bundle' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap theme-main-bundle">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/theme-bundle.png" alt="theme-bundle" width="300" height="300" />
			<p class="bundle-link"><a target="_blank" href="<?php echo esc_url( DESTINATION_HOTEL_BOOKING_THEME_BUNDLE ); ?>" class="button button-primary bundle-btn"><?php esc_html_e( 'Buy WordPress Theme Bundle (120+ Themes)', 'destination-hotel-booking' ); ?></a></p>
		</div>
	<?php
	}
}