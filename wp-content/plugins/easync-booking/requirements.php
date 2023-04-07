<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'init','easyncCssAndJs');

function easyncCssAndJs() {

    wp_enqueue_script('jquery');
    wp_register_style('bootstrap_style', plugins_url('/css/bootstrap.min.css', __FILE__));
    wp_register_script('bootstrap_js', plugins_url('/js/bootstrap.min.js', __FILE__));
    wp_register_style('datepicker_style', plugins_url('/css/datepicker.css', __FILE__));
    wp_register_script('datepicker_js', plugins_url('/js/datepicker.js', __FILE__));
    wp_register_style('timepicker_style', plugins_url('/css/timedropper.css', __FILE__));
    wp_register_script('timepicker_js', plugins_url('/js/timedropper.js', __FILE__));
    wp_register_style('select_style', plugins_url('/css/select.css', __FILE__));
    wp_register_script('select_js', plugins_url('/js/select.js', __FILE__));
    wp_register_script('fontawesome_js', plugins_url('/js/fontawesome-all.min.js', __FILE__));
    wp_register_script('imageupload_js', plugins_url('/js/imageupload.js', __FILE__));
    wp_register_style('fancy_style', plugins_url('/css/jquery.fancybox.min.css', __FILE__));
    wp_register_script('fancy_js', plugins_url('/js/jquery.fancybox.min.js', __FILE__));
    wp_register_style('fullcalendar_style', plugins_url('/css/fullcalendar.css', __FILE__));
    wp_register_script('moment_js', plugins_url('/js/moment.min.js', __FILE__));
    wp_register_script('fullcalendar_js', plugins_url('/js/fullcalendar.js', __FILE__));
    wp_register_style('toggleswitch_style', plugins_url('/css/tinytools.toggleswitch.css', __FILE__));
    wp_register_script('toggleswitch_js', plugins_url('/js/tinytools.toggleswitch.min.js', __FILE__));
    wp_register_script('moneyformat_js', plugins_url('/js/simple.money.format.js', __FILE__));
    wp_register_style('toolipster_style', plugins_url('/css/tooltipster.bundle.min.css', __FILE__));
    wp_register_script('toolipster_js', plugins_url('/js/tooltipster.bundle.min.js', __FILE__));
    wp_register_style('loading_style', plugins_url('/css/jquery.loading.min.css', __FILE__));
    wp_register_script('loading_js', plugins_url('/js/jquery.loading.min.js', __FILE__));
    wp_register_script('sweet_js', plugins_url('/js/sweetalert.js', __FILE__));
    wp_register_script('jquery-slider-ui_js', plugins_url('/js/jquery-ui.min.js', __FILE__));
    wp_register_script( 'bootstrap_datepicker_js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js', null, null, true );
    wp_register_style( 'bootstrap_datepicker_css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css', false, '1.9.0' );
    wp_register_style('jquery-datepicker-ui_style', plugins_url('/css/jquery-ui.datepicker.min.css', __FILE__));
    wp_register_style('stripe_checkout', plugins_url('/css/checkout_stripe.css', __FILE__));
    wp_register_style('form_style', plugins_url('/css/form_style.css', __FILE__));
    wp_register_style('authorize_css', plugins_url('/css/authorize.css', __FILE__));
    wp_register_style('backend_style', plugins_url('/css/backend.css', __FILE__));
    wp_register_style('form_style_resp', plugins_url('/css/responsive.css', __FILE__));
    wp_register_script( 'checkout_js', 'https://www.paypalobjects.com/api/checkout.js', null, null, true );
    wp_register_script('date-range-slider_js', plugins_url('/js/date-range-slider.js', __FILE__));
    wp_register_script('form_js', plugins_url('/js/custom.js', __FILE__));
    wp_register_script('chart_js', plugins_url('/js/chart.js', __FILE__));
    wp_register_script( 'qrCode', 'https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js', null, null, true );
    wp_localize_script('form_js', 'easync_admin_ajax_directory', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ) )
    );

    wp_localize_script('form_js', 'easync_admin_check_login', array( 
        'login' => is_user_logged_in() )
    );

    wp_localize_script('form_js', 'easync_admin_check_page', array( 
                'pageIs' => 'no' )
    );
    
}

// As you are dealing with plugin settings,
// I assume you are in admin side

function easyncLoadPageSettings( $page ) {
  // change to the $page where you want to enqueue the script
  if( $page == 'easync-booking_page_easync-settings' ) {
    // Enqueue WordPress media scripts
    wp_enqueue_media();
    wp_enqueue_style('toggleswitch_style');
    wp_enqueue_script('toggleswitch_js');
    wp_enqueue_script('imageupload_js');
    wp_enqueue_script('sweet_js');
    wp_enqueue_style('fullcalendar_style');
    wp_enqueue_script('moment_js');

    // Enqueue custom script that will interact with wp.media
    wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
  }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageSettings' );

function easyncLoadPageCoupons( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-coupons' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_style('fullcalendar_style');
        wp_enqueue_script('moment_js');

        // Enqueue custom script that will interact with wp.media
        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageCoupons' );

function easyncLoadPageRentedCars( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-rented-car-details' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_script('moment_js'); 

        // Enqueue custom script that will interact with wp.media 
        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageRentedCars' );

function easyncLoadPageHotelReports( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-hotel-reports' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_script('moment_js');
        wp_enqueue_script('chart_js');

        // Enqueue custom script that will interact with wp.media
        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageHotelReports' );

function easyncLoadPageCarReports( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-car-reports' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_script('moment_js');
        wp_enqueue_script('chart_js');

        // Enqueue custom script that will interact with wp.media
        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageCarReports' );

function easyncLoadPageRestauReports( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-restau-reports' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_script('moment_js');
        wp_enqueue_script('chart_js');

        // Enqueue custom script that will interact with wp.media
        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageRestauReports' );

function easyncLoadPageCancelRequests( $page ) {
    // change to the $page where you want to enqueue the script
    if( $page == 'easync-booking_page_easync-cancellation-requests' ) {
        // Enqueue WordPress media scripts
        wp_enqueue_media();
        wp_enqueue_style('toggleswitch_style');
        wp_enqueue_script('toggleswitch_js');
        wp_enqueue_script('imageupload_js');
        wp_enqueue_script('sweet_js');
        wp_enqueue_script('moment_js');

        wp_enqueue_script( 'myprefix_script', plugins_url( '/js/myscript.js' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageCancelRequests' );

function easyncLoadPageBooking( $page ) {
    if( $page == 'easync-booking_page_easync-entries' ) {
       wp_enqueue_style('fullcalendar_style');
       wp_enqueue_script('moment_js');
       wp_enqueue_script('fullcalendar_js');
       wp_enqueue_script('sweet_js');
   }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageBooking' ); 

function easyncLoadPagePremium( $page ) {
     if( $page == 'easync-booking_page_easync-premium' ) {
        wp_enqueue_style('fullcalendar_style');
        wp_enqueue_script('moment_js');
        wp_enqueue_script('fullcalendar_js');
        wp_enqueue_script('sweet_js');
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPagePremium' ); 

function easyncLoadPageHome($page) {
    if( $page == 'toplevel_page_easync-booking' ) {
        // wp_enqueue_style('jquery-slider-ui_style');
        wp_enqueue_script('jquery-slider-ui_js');
        wp_enqueue_style('jquery-datepicker-ui_style');
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-keycode' );
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-slide-effect' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script('date-range-slider_js'); 
        wp_enqueue_style('bootstrap_datepicker_css');
        wp_enqueue_script('bootstrap_datepicker_js');
    }
}
add_action( 'admin_enqueue_scripts', 'easyncLoadPageHome' );

function easyncMyprefixGetImage() {
    if(isset($_GET['id']) ){
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
        $data = array(
            'image'    => $image,
        );
        wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}
add_action( 'wp_ajax_myprefix_get_image', 'easyncMyprefixGetImage'   );

function easyncCheckForShortcode($posts) {
    global $has_shortcode_page;
    if ( empty($posts) )
        return $posts;

    foreach ($posts as $key => $post) {
        if ( stripos($post->post_content, '[sync_hotel_code]') || stripos($post->post_content, '[sync_car_code]') || stripos($post->post_content, '[sync_restau_code]')) {
            $has_shortcode_page[$key] = $post->post_name;
        }
    }
 
    return $posts;
}
add_action('the_posts', 'easyncCheckForShortcode');

function easyncConditionallyEnqueueMyStylesheet() {
    global $has_shortcode_page;
    if ( is_page( $has_shortcode_page )) {
        easyncEnqueue();
    }
}

add_action( 'wp_enqueue_scripts', 'easyncConditionallyEnqueueMyStylesheet' );
function easyncLoadCustomWpAdminStyle($hook) {
    if(($hook != 'easync-booking_page_easync-entries') && ($hook != 'easync-booking_page_easync-premium') && ($hook != 'easync-booking_page_easync-settings') && ($hook != 'toplevel_page_easync-booking') && ($hook != 'easync-booking_page_easync-coupons') && ($hook != 'easync-booking_page_easync-rented-car-details') && ($hook != 'easync-booking_page_easync-hotel-reports') && ($hook != 'easync-booking_page_easync-car-reports') && ($hook != 'easync-booking_page_easync-cancellation-requests') && ($hook != 'easync-booking_page_easync-restau-reports') )  {
            return;
    }
    easyncEnqueue();
}

add_action( 'admin_enqueue_scripts', 'easyncLoadCustomWpAdminStyle' );
function easyncCheckPage($hook) {
        if(($hook == 'easync-booking_page_easync-entries') ) {
            wp_localize_script('form_js', 'easync_admin_check_page', array( 
                'pageIs' => 'load' )
            );
        }
    }

add_action( 'admin_enqueue_scripts', 'easyncCheckPage' );
function easyncEnqueue() {
    
    wp_enqueue_style('bootstrap_style');
    wp_enqueue_script('bootstrap_js');
    wp_enqueue_script('qrCode');
    wp_enqueue_style('bootstrap_datepicker_css');
    wp_enqueue_script('bootstrap_datepicker_js');
    wp_enqueue_style('timepicker_style');
    wp_enqueue_script('timepicker_js');
    wp_enqueue_style('select_style');
    wp_enqueue_script('select_js');
   if (!wp_style_is( 'fontawesome', 'enqueued' )) {
        wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', false, '4.6.1' );
        wp_enqueue_style( 'fontawesome' );
    } 
    wp_enqueue_style('fancy_style');
    wp_enqueue_script('fancy_js');
    wp_enqueue_script('moneyformat_js');
    wp_enqueue_style('toolipster_style');
    wp_enqueue_script('toolipster_js');
    wp_enqueue_style('loading_style');
    wp_enqueue_script('loading_js');
    wp_enqueue_style('jquery-datepicker-ui_style');
    wp_enqueue_script('jquery-slider-ui_js');
    wp_enqueue_style('datepicker_style');
    wp_enqueue_script('datepicker_js');
    wp_enqueue_script('checkout_js');
    wp_enqueue_style('authorize_css');
    wp_enqueue_style('form_style');
    wp_enqueue_style('stripe_checkout');
    wp_enqueue_style('backend_style');
    wp_enqueue_style('form_style_resp');
    wp_enqueue_script('form_js');
}
