<?php 

    /*
    Plugin Name: EaSync Booking
    Description: Plugin for Booking modules (hotel booking, car rental and restaurant reservation)
    Author: Syntactics, Inc.
    Version: 1.3.2
    Author URI: http://www.syntacticsinc.com 
    */

/**************************generates tables*************************/
if( ! defined( 'ABSPATH' ) ) exit;


global $jal_db_version, $wp_query, $wpdb, $sync_hotel_enable, $sync_captcha_enable, $sync_driver_enable, $sync_paypal_enable, $sync_car_enable, $sync_restau_enable, $paypalURL, $paypalID, $paypal_sandbox, $paypal_production, $paypal_method, $sync_default_rate, $sync_currency, $sync_currency_set, $geoPlugin_array, $sync_product_currency, $sync_emailtemplate_image, $sync_hotel_privacy, $sync_hotel_terms, $sync_car_privacy, $sync_car_terms, $sync_restau_privacy, $sync_restau_terms, $has_shortcode_page, $errors_config_hotel, $errors_config_car, $errors_config_restau;
session_start();

    $errors_config_hotel   = array(); 
    $errors_config_car     = array();
    $errors_config_restau  = array();
    $has_shortcode_page    = array();
    $sync_product_currency = 'USD';
    $sync_currency_set     = array();
    // $geoPlugin_array       = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
    $sync_currency         = array (
        'AUD' => 'Australian Dollar', 
        'BRL' => 'Brazilian Real ', 
        'CAD' => 'Canadian Dollar', 
        'CNY' => 'Chinese Renmenbi', 
        'CZK' => 'Czech Koruna', 
        'DKK' => 'Danish Krone', 
        'EUR' => 'Euro', 
        'HKD' => 'Hong Kong Dollar', 
        'HUF' => 'Hungarian Forint', 
        'ILS' => 'Israeli New Shekel', 
        'JPY' => 'Japanese Yen', 
        'MYR' => 'Malaysian Ringgit', 
        'MXN' => 'Mexican Peso', 
        'TWD' => 'New Taiwan Dollar', 
        'NZD' => 'New Zealand Dollar', 
        'NOK' => 'Norwegian Krone', 
        'PHP' => 'Philippine Peso', 
        'PLN' => 'Polish Złoty', 
        'GBP' => 'Pound Sterling', 
        'RUB' => 'Russian Ruble', 
        'SGD' => 'Singapore Dollar', 
        'SEK' => 'Swedish Krona', 
        'CHF' => 'Swiss Franc', 
        'THB' => 'Thai Baht', 
        'USD' => 'United States Dollar'
    );
    $jal_db_version = '1.0';

function easyncActivationRedirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=easync-booking' ) ) );
    }
}
add_action( 'activated_plugin', 'easyncActivationRedirect' );  

function easyncInstall() {
    global $wpdb;
    global $jal_db_version;

    $table_hotel_entries     = $wpdb->prefix . 'sync_hotel_entries';
    $table_rent_car_entries  = $wpdb->prefix . 'sync_rent_car_entries';
    $table_restau_entries    = $wpdb->prefix . 'sync_restau_entries';
    $table_options           = $wpdb->prefix . 'sync_options';
    $table_payments          = $wpdb->prefix . 'sync_payments';
    $table_currency_exchange = $wpdb->prefix . 'currency_exchange';
    $table_cancel_requests   = $wpdb->prefix . 'sync_cancel_requests';
    $table_restau_table      = $wpdb->prefix . 'sync_restau_tables';
    $table_rate_bridge       = $wpdb->prefix . 'sync_rate_bridge';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_hotel_entries (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        reference_number varchar(55) NOT NULL,
        firstname varchar(55) NOT NULL,
        lastname varchar(55) NOT NULL,
        phone varchar(25) NOT NULL,
        email varchar(55) NOT NULL,
        room_id mediumint(9) NOT NULL,
        arrival_date text NOT NULL,
        departure_date text NOT NULL,
        night_number varchar(55) NOT NULL,
        guest_number varchar(55) NOT NULL,
        room_number varchar(55) NOT NULL,
        facility_request text NOT NULL,
        other_req text NOT NULL,
        address_1 text NOT NULL,
        address_2 text NOT NULL,
        city text NOT NULL,
        province text NOT NULL,
        postal_code varchar(25) NOT NULL,
        status varchar(25) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_rent_car_entries (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        reference_number varchar(55) NOT NULL,
        firstname varchar(55) NOT NULL,
        lastname varchar(55) NOT NULL,
        phone varchar(25) NOT NULL,
        email varchar(55) NOT NULL,
        with_driver varchar(55) NOT NULL,
        d_name varchar(55) NOT NULL,
        d_phone varchar(25) NOT NULL,
        d_license_image text NOT NULL,
        car_id mediumint(9) NOT NULL,
        pick_date text NOT NULL,
        pick_time text NOT NULL,
        return_date text NOT NULL,
        return_time text NOT NULL,
        pick_location text NOT NULL,
        number_days varchar(55) NOT NULL,
        facility_request text NOT NULL,
        other_req text NOT NULL,
        address_1 text NOT NULL,
        address_2 text NOT NULL,
        city text NOT NULL,
        province text NOT NULL,
        postal_code varchar(25) NOT NULL,
        status varchar(25) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_restau_entries (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(55) NOT NULL,
        phone varchar(25) NOT NULL,
        email varchar(55) NOT NULL,
        branch text NOT NULL,
        guest_no varchar(55) NOT NULL,
        table_no varchar(55) NOT NULL,
        timeslot text NOT NULL,
        pick_date text NOT NULL,
        table_id varchar (9), NOT NULL,
        address_1 text NOT NULL,
        address_2 text NOT NULL,
        city text NOT NULL,
        province text NOT NULL,
        postal_code varchar(25) NOT NULL,
        reference_number varchar(55) NOT NULL,
        status varchar(25) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_options (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        option_name text NOT NULL,
        option_value text NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_payments (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        item_belongsto varchar(25) NOT NULL,
        item_cat varchar(25) NOT NULL,
        item_number varchar(25) NOT NULL,
        txn_id varchar(25) NOT NULL,
        payment_gross varchar(25) NOT NULL,
        currency_code varchar(25) NOT NULL,
        payment_status varchar(25) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_cancel_requests (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        reference_num varchar(55) NOT NULL,
        name varchar(55) NOT NULL,
        phone_number varchar(25) NOT NULL,
        email_add varchar(55) NOT NULL,
        request_type varchar(55) NOT NULL,
        status varchar(25) NOT NUll,
        UNIQUE KEY id (id)
    ) $charset_collate;
    CREATE TABLE $table_restau_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        entry_id mediumint(9) NOT NULL,
        table_id mediumint(9) NOT NULL,
        menu_ids text NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'jal_db_version', $jal_db_version );
    $table    = $wpdb->prefix . "sync_options";

    $temp_val = 'none<>none<>sandbox';
    $row      = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_paypal_setting'");
    if(empty($row)) {
        $entries = array(
             'option_name'    =>   'sync_paypal_setting',
             'option_value'   =>   $temp_val,
        );
        $wpdb->insert($table, $entries);
    }

    $temp_val = 'none<>none';
    $row      = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_stripe_setting'");
    if(empty($row)) {
        $entries = array(
             'option_name'    =>   'sync_stripe_setting',
             'option_value'   =>   $temp_val,
        );
        $wpdb->insert($table, $entries);
    }

    $temp_val = '07:00 am-8:00 pm';
    $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_car_default_time'");
    if(empty($row)) {
        $entries = array(
            'option_name'    =>   'sync_car_default_time',
            'option_value'   =>   $temp_val,
        );
        $wpdb->insert($table, $entries); 
    }  

    if ( ! wp_next_scheduled( 'bl_cron_7day_email' ) ) {
        wp_schedule_event( strtotime('16:30:00'), 'daily', 'bl_cron_7day_email' ); 
    }
    if ( ! wp_next_scheduled( 'bl_cron_3day_email' ) ) {
        wp_schedule_event( strtotime('17:00:00'), 'daily', 'bl_cron_3day_email' ); 
    }
    if ( ! wp_next_scheduled( 'bl_cron_1day_email' ) ) {
        wp_schedule_event( strtotime('17:30:00'), 'daily', 'bl_cron_1day_email' ); 
    }
    if ( ! wp_next_scheduled( 'bl_cron_check_subscription_expiration' ) ) {
        wp_schedule_event( strtotime('17:00:00'), 'daily', 'bl_cron_check_subscription_expiration' ); 
    }

}

function easyncInstallData() {
    global $wpdb;   
    $welcome_name = 'Mr. WordPress';
    $welcome_text = 'Congratulations, you just completed the installation!';
    $table_name = $wpdb->prefix . 'liveshoutbox';
    $wpdb->insert( 
        $table_name, 
        array( 
            'time' => current_time( 'mysql' ), 
            'name' => $welcome_name, 
            'text' => $welcome_text, 
        ) 
    );
}

register_activation_hook( __FILE__, 'easyncInstall' );
register_activation_hook( __FILE__, 'easyncInstallData' );
register_activation_hook( __FILE__, 'easyncAddRole' );
register_deactivation_hook( __FILE__, 'easyncRemoveRole' );

/**************************END of generates tables*******/

/***************detecting plugins active*****************/
$table_name = $wpdb->prefix . "sync_options";
$sync_paypal_enable = true;
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
    $sync_hotel_enable = false;
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_switch_hotel'));
    if ($entries && $entries[0]->option_value=='on') {
        $sync_hotel_enable = true;
    }
    $sync_captcha_enable = false;
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_captcha_switch'));
    if ($entries && $entries[0]->option_value=='on') {
        $sync_captcha_enable = true;
    }
    $sync_driver_enable = false;
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_driver_switch'));
    if ($entries && $entries[0]->option_value=='on') {
        $sync_driver_enable = true;
    }
    $sync_car_enable = false;
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_switch_car'));
    if ($entries && $entries[0]->option_value=='on') {
        $sync_car_enable = true;
    }
    $sync_restau_enable = false;
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_switch_restau'));
    if ($entries && $entries[0]->option_value=='on') {
        $sync_restau_enable = true;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_paypal_setting'));
    if ($entries) {
        $paypal_sandbox = explode("<>", $entries[0]->option_value, 2)[0];
        $paypal_production  = explode("<>", $entries[0]->option_value, 3)[1];
        $paypal_method = explode("<>", $entries[0]->option_value, 4)[2];
        if($paypal_method=='sandbox') {
            $paypalID = $paypal_sandbox;
        }
        if($paypal_method=='production') {
            $paypalID =  $paypal_live;
        }
        if(($paypal_method=='sandbox' && $paypal_sandbox=='none') || ($paypal_method=='production' && $paypal_production=='none') ) {
             $paypalURL = 'error';
             $temp_error = 'Paypal credentials';
             $errors_config_hotel['paypal_error'] = $temp_error;
             $errors_config_car['paypal_error'] = $temp_error;
             $errors_config_restau['paypal_error'] = $temp_error;
        }
    }else{
        $paypalURL = 'error';
        $temp_error = 'Paypal credentials';
        $errors_config_hotel['paypal_error'] = $temp_error;
        $errors_config_car['paypal_error'] = $temp_error;
        $errors_config_restau['paypal_error'] = $temp_error;
    }

    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_currency'));
    if ($entries) {
        foreach ($entries as $key => $value) {
            $sync_currency_set[$key] = $value->option_value;
        }
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_product_currency_code'));
    if ($entries) {
        $sync_product_currency = $entries[0]->option_value;
    }else{
        $temp_error = 'Product currency';
        $errors_config_hotel['product_currency_error']  = $temp_error;
        $errors_config_car['product_currency_error']    = $temp_error;
        $errors_config_restau['product_currency_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_user_email_image'));
    if ($entries) {
        $sync_emailtemplate_image = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_hotel_page_privacy'));
    if ($entries) {
        $sync_hotel_privacy = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_hotel_page_terms'));
    if ($entries) {
        $sync_hotel_terms = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_page_privacy'));
    if ($entries) {
        $sync_car_privacy = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_page_terms'));
    if ($entries) {
        $sync_car_terms = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_restau_page_privacy'));
    if ($entries) {
        $sync_restau_privacy = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_restau_page_terms'));
    if ($entries) {
        $sync_restau_terms = $entries[0]->option_value;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_pickup'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide atleast one pick up location';
        $errors_config_car['car_pick_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_types'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide atleast one car type';
        $errors_config_car['car_type_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_model'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide atleast one car model';
        $errors_config_car['car_model_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_default_time'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide default pickup and return time';
        $errors_config_car['car_default_time_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_branch_locations'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide atleast one branch location';
        $errors_config_restau['restau_branch_location_error'] = $temp_error;
    }
    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_restau_banner_image'));
    if (count($entries) <= 0) {
        $temp_error = 'Please provide menu banner image';
        $errors_config_restau['restau_menu_banner_error'] = $temp_error;
    }

    $timeslots_error = false;
    $entries = $wpdb->get_results("SELECT * FROM $table_name WHERE option_name LIKE '%sync_timeslot%';"); 
    if (count($entries) <= 0) {
         $timeslots_error = true;
    }
    
    if ($timeslots_error == true) {
        $temp_error = 'Please provide timeslots';
        $errors_config_restau['restau_timeslots_error'] = $temp_error;
    }
}

// if (in_array($geoPlugin_array['geoplugin_currencyCode'], $sync_currency_set)) {
    // $sync_default_rate = $geoPlugin_array['geoplugin_currencyCode'];
// }else{
    $sync_default_rate = $sync_product_currency;
// }

/***************END plugins active*****************/

function easync_cron_remove() {
    wp_clear_scheduled_hook( 'bl_cron_7day_email' );
    wp_clear_scheduled_hook( 'bl_cron_3day_email' );
    wp_clear_scheduled_hook( 'bl_cron_1day_email' );
    wp_clear_scheduled_hook( 'bl_cron_check_subscription_expiration' );
}


add_action( 'bl_cron_7day_email', 'send_email_7Day' );
function send_email_7Day() {
    global $wpdb;
    $email_entry   = array();
    $table_entries = $wpdb->prefix . "sync_hotel_entries";
    $qry           = $wpdb->get_results("select firstname, email, arrival_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $content       = $wpdb->get_results("SELECT option_value from $option where option_name IN ('book_reminder7_email_head', 'book_reminder7_email_body', 'book_reminder7_email_footer', 'sync_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->arrival_date);
        $user_email  = $value->email;
        $days        = date_diff($arrival, $now);
        $send_status = explode("-", $content[3]->option_value);
        if ($send_status[0] == 'true') {
            if ( $days == "7" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_3day_email', 'send_email_3Day' );
function send_email_3Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_hotel_entries";
    $qry           = $wpdb->get_results("select firstname, arrival_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $content       = $wpdb->get_results("SELECT option_value from $option where option_name IN ('book_reminder3_email_head', 'book_reminder3_email_body', 'book_reminder3_email_footer', 'sync_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->arrival_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);
        if ($send_status[1] == 'true') {
            if ( $days == "3" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($value[0]->firstname);
                    $user_email         = $value[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_1day_email', 'send_email_1Day' );
function send_email_1Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_hotel_entries";
    $qry           = $wpdb->get_results("select firstname, arrival_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $query         = $wpdb->get_results("SELECT option_value from $option where option_name IN ('book_reminder1_email_head', 'book_reminder1_email_body', 'book_reminder1_email_footer', 'sync_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_emai     = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->arrival_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);
        if ($send_status[2] == 'true') {
            if ( $days == "1" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_7day_email', 'car_send_email_7Day' );
function car_send_email_7Day() {
    global $wpdb;
    $email_entry   = array();
    $table_entries = $wpdb->prefix . "sync_rent_car_entries";
    $qry           = $wpdb->get_results("select firstname, email, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $content       = $wpdb->get_results("SELECT option_value from $option where option_name IN ('rent_reminder7_car_email_head', 'rent_reminder7_car_email_body', 'rent_reminder7_car_email_footer', 'sync_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";
    
    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $user_email  = $value->email;
        $days        = date_diff($arrival, $now);
        $send_status = explode("-", $content[3]->option_value);
        if ($send_status[0] == 'true') {
            if ( $days == "7" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_3day_email', 'car_send_email_3Day' );
function car_send_email_3Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_rent_car_entries";
    $qry           = $wpdb->get_results("select firstname, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $content       = $wpdb->get_results("SELECT option_value from $option where option_name IN ('rent_reminder3_car_email_head', 'rent_reminder3_car_email_body', 'rent_reminder3_car_email_footer', 'sync_car_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);

        if ($send_status[1] == 'true') {
            if ( $days == "3" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name = ucfirst($qry[0]->firstname);
                    $user_email = $qry[0]->email;
                    $data['header_msg']       = $content[0]->option_value;
                    $data['footer_msg']       = $content[2]->option_value; 
                    $data['body_msg']         = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_1day_email', 'car_send_email_1Day' );
function car_send_email_1Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_rent_car_entries";
    $qry           = $wpdb->get_results("select firstname, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $query         = $wpdb->get_results("SELECT option_value from $option where option_name IN ('book_reminder1_car_email_head', 'book_reminder1_car_email_body', 'book_reminder1_car_email_footer', 'sync_car_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);

        if ($send_status[2] == 'true') {
            if ( $days == "1" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_3day_email', 'restau_send_email_3Day' );
function restau_send_email_3Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_restau_entries";
    $qry           = $wpdb->get_results("select firstname, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $query         = $wpdb->get_results("SELECT option_value from $option where option_name IN ('reserve_reminder3_restau_email_head', 'reserve_reminder3_restau_email_body', 'reserve_reminder3_restau_email_footer', 'sync_car_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);

        if ($send_status[2] == 'true') {
            if ( $days == "3" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_7day_email', 'restau_send_email_7Day' );
function restau_send_email_7Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_restau_entries";
    $qry           = $wpdb->get_results("select firstname, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $query         = $wpdb->get_results("SELECT option_value from $option where option_name IN ('reserve_reminder7_restau_email_head', 'reserve_reminder7_restau_email_body', 'reserve_reminder7_restau_email_footer', 'sync_car_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);

        if ($send_status[2] == 'true') {
            if ( $days == "7" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name = ucfirst($qry[0]->firstname);
                    $user_email = $qry[0]->email;
                    $data['header_msg']       = $content[0]->option_value;
                    $data['footer_msg']       = $content[2]->option_value; 
                    $data['body_msg']         = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

add_action( 'bl_cron_1day_email', 'restau_send_email_1Day' );
function restau_send_email_1Day() {
    global $wpdb;
    $table_entries = $wpdb->prefix . "sync_restau_entries";
    $qry           = $wpdb->get_results("select firstname, pick_date, email from $table_entries where status = 'pending';");
    $option        = $wpdb->prefix . 'sync_options';
    $query         = $wpdb->get_results("SELECT option_value from $option where option_name IN ('reserve_reminder1_restau_email_head', 'reserve_reminder1_restau_email_body', 'reserve_reminder1_restau_email_footer', 'sync_car_selected_reminders') ;");
    $now           = date_create(date("m/d/Y"));
    $send          = "no";
    $user_email    = "";

    foreach ( $qry as $key => $value ) {
        $arrival     = date_create($value->pick_date);
        $days        = date_diff($arrival, $now);
        $user_email  = $value->email;
        $send_status = explode("-", $content[3]->option_value);

        if ($send_status[2] == 'true') {
            if ( $days == "1" ) {
                $send = "yes";
                if ( $send == "yes" ) {
                    $greet_name         = ucfirst($qry[0]->firstname);
                    $user_email         = $qry[0]->email;
                    $data['header_msg'] = $content[0]->option_value;
                    $data['footer_msg'] = $content[2]->option_value; 
                    $data['body_msg']   = $content[1]->option_value;
                    require_once("email-templates/cancel-request-email-template.php");
                    $to         = $user_email; // this is your Email address
                    $from       = get_option('admin_email'); // this is the sender's Email address
                    $headers    = "MIME-Version: 1.0" . "\r\n";
                    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
                    $subject    = 'eaSYNC-Booking Reservation Reminder';
                    $message    = $htmlContent;
                    $name       = get_bloginfo( 'name' );
                    mail($to,$subject,$message,$headers);
                } 
            }
        }
    }
}

function easyncRemoveRole() {
    remove_role( 'sync_booking' );
}

function easyncAddRole() {
    $customCaps = array(
        'edit_others_contacts'      => true,
        'delete_others_contacts'    => true,
        'delete_private_contacts'   => true,
        'edit_private_contacts'     => true,
        'read_private_contacts'     => true,
        'edit_published_contacts'   => true,
        'publish_contacts'          => true,
        'delete_published_contacts' => true,
        'edit_contacts'             => true,
        'delete_contacts'           => true,
        'edit_contact'              => true,
        'read_contact'              => true,
        'delete_contact'            => true,
        'read'                      => true,
    );
     
    add_role( 'sync_booking', __( 'Sync book keeper', 'sync_privilage'), $customCaps );
    $role = get_role('sync_booking');
    $role->add_cap('upload_files');
    unset( $role );
}

/**************************pages*************************/
add_action('admin_menu', 'easyncAdminActions');
function easyncAdminActions(){
    $role = 'manage_options';
    if(!is_super_admin())
        $role = 'sync_booking';
    
    add_menu_page('eaSYNC Booking', 'eaSYNC Booking', $role, 'easync-booking', 'easyncBookingHomePage', plugins_url('/easync-booking/images/icon.png',__DIR__));
    add_submenu_page('easync-booking', 'Bookings', 'Bookings', $role, '/easync-entries', 'easyncBookingEntriesPage', 1);
    add_submenu_page('easync-booking', 'Cancellation Requests', 'Cancellation Requests', $role, '/easync-cancellation-requests', 'easyncBookingCancellationRequestsPage', 2);
    add_submenu_page('easync-booking', 'Settings', 'Settings', $role, '/easync-settings', 'easyncBookingSettingsPage', 8);
    add_submenu_page('easync-booking', 'Premium', '<span class="premium_menu_style">Premium <i class="fa fa-star"></i></span>', $role, '/easync-premium', 'easyncBookingPremiumPage', 9);

}

add_action('wp_ajax_easync_get_dates', 'easync_get_dates');
add_action('wp_ajax_nopriv_easync_get_dates', 'easync_get_dates');
function easync_get_dates() {
    global $wpdb;
    $values    = array();
    $days_list = array();
    $option    = $wpdb->prefix . 'sync_options';
    $qry       = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_date_set'");
    $qry_days  = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_selected_days';");

    foreach ($qry as $value) {
        $values[] = $value->option_value;
    }
    $list = explode("-", $qry_days[0]->option_value);
    foreach ($list as $each) {
        $days_list[] = $each;
    }
    array_push($values, $days_list);
    echo json_encode($values);
    wp_die();
}

function easyncBookingHomePage() {
include('modules/home.php');
}

function easyncBookingEntriesPage(){
include('modules/entries.php');
}

function easyncBookingSettingsPage(){
include('modules/settings.php');
}

function easyncBookingAboutPage(){
include('modules/about.php');
}

function easyncBookingCancellationRequestsPage(){
include('modules/cancellation_request.php');
}

function easyncBookingPremiumPage(){
include('modules/premium_settings.php');
}

/**************************END of backend pages*************************/
session_start();
require_once('requirements.php');

/**********fronted forms*****************/
if ($sync_hotel_enable==true) {
 require_once('hotel_posttype.php');
    /**********hotel forms*****************/
    add_shortcode('easync_hotel_code', 'easyncHotelCode');
    function easyncHotelCode() {
        return do_shortcode( '[easync_booking_room]' );
    }

    add_shortcode('easync_booking_room', 'easyncFormRoomCreation');
    function easyncFormRoomCreation(){
        ob_start();
        include('forms/hotel/search-room.php');
        return ob_get_clean();
    }
}
    /**********END of hotel forms*****************/
if ($sync_car_enable==true) {
 require_once('car_posttype.php');
    /**********car forms*****************/
    add_shortcode('easync_car_code', 'easyncCarCode');
    function easyncCarCode() {
        return do_shortcode( '[easync_booking_car]' );
    }

    add_shortcode('easync_booking_car', 'easyncFormCarCreation');
    function easyncFormCarCreation(){
        ob_start();
        include('forms/car-rental/search-car.php');
        return ob_get_clean();
    }
}        
    /**********END of car forms*****************/
if ($sync_restau_enable==true) {
    require_once('restaurant_posttype.php');
    require_once('restau_table_posttype.php');
    /**********restau forms*****************/
    add_shortcode('easync_restau_code', 'easyncRestauCode');
    function easyncRestauCode() {
        return do_shortcode( '[easync_booking_restau]' );
    }

    add_shortcode('easync_booking_restau', 'easyncFormRestauCreation');
    function easyncFormRestauCreation(){
        ob_start();
        include('forms/restaurant/select-date.php');
        return ob_get_clean();
    }
}
    /**********END of restau forms*****************/

/**********END of fronted forms*****************/

function easyncStringLimitWords($string, $word_limit) {
   $words = explode(' ', $string, ($word_limit + 1));
   if(count($words) > $word_limit) {
       array_pop($words);
       //add a ... at last article when more than limit word count
       echo implode(' ', $words)."..."; 
    } else {
       //otherwise
       echo implode(' ', $words); 
    }
}

function easyncExchangeRate($amount,$from_currency,$to_currency){
  $from_Currency = urlencode($from_currency);
  $to_Currency   = urlencode($to_currency);
  $query         =  "{$from_Currency}_{$to_Currency}";
  $json          = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
  $obj           = json_decode($json, true);
  $val           = floatval($obj["$query"]);
  $total         = $val * $amount;
  return number_format($total, 2, '.', ',');
}

function easyncPrice($price) {
    global $sync_default_rate, $sync_product_currency;
    $final_price = 0;
    if(!empty($price)) {
        if($sync_default_rate!=$sync_product_currency)
            $final_price = easyncExchangeRate($price, $sync_product_currency, $sync_default_rate);
        else
            $final_price = $price;
    }
    return $final_price;
}

function easyncCurrency() {
    global $sync_default_rate;
    return $sync_default_rate; 
}

add_action("wp_ajax_easync_calendar_query", "easync_calendar_query");
function easync_calendar_query() {
    global $wpdb, $post;
    session_start();
    $data             = array(); 
    $errors           = array();       
    $data['success']  = false;
    $data['message']  = 'failed!';
    $event            = array();
    $type             = '';
    $sani_type        = sanitize_text_field($_GET['type']);

    if(isset($sani_type)) {
        $type = $sani_type;
    }
    switch ($type) {
        case 'restau':
            $restau_table  = $wpdb->prefix . "sync_options";
            $currCode      = $wpdb->get_results( "SELECT option_value FROM $restau_table WHERE option_name='sync_product_currency_code'" );
            $table_name    = $wpdb->prefix . "sync_restau_entries";
            $qry_menus     = $wpdb->prefix . 'sync_restau_tables';
            $payments      = $wpdb->prefix . 'sync_payments';
            $entries       = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
            $data['count'] = $wpdb->num_rows;
            $menus         = $wpdb->get_results( "SELECT * FROM $qry_menus where entry_id = '".$entries[0]->id."';" );
            $amount        = $wpdb->get_results( "SELECT payment_gross, payment_status FROM $payments where item_cat = 'restau' and item_belongsto = '".$entries[0]->id."';");
            $payment_stat  = "NOT YET PAID";
            
            if ( ! $entries ) {
                $wpdb->print_error(); 
            }else {
                $yourCurrCode;
                foreach ($menus as $each) {
                    $temp_title = "";
                    $temp_array = explode(', ', $each->menu_ids);
                    $itemprice  = 0;
                    foreach ($temp_array as $key2 => $value) {
                        $metaID = get_post($value)->ID;
                        $meta   = get_post_meta( $metaID, 'sync_restau', true ); 
                        preg_match('#\((.*?)\)#', $value, $match);
                        $temp_title .= '> '.get_post($value)->post_title .' (Quantity: '.trim($match[1], ' QTY ').')</br>';   
                    }
                    $all_menus .= $temp_title;
                    $overallprice = $amount[0]->payment_gross;
                }
                $store_menu = $all_menus;
                foreach ($entries as $key => $item) {
                    if ($currCode[$key]->option_value != NULL) {
                        $yourCurrCode = $currCode[$key]->option_value;
                    }

                    if ($amount[0]->payment_status == 'paid') {
                        $payment_stat = "PAID";
                    }

                    $temp_data  = ucfirst($item->status). '<>' .$store_menu. '<>' .$item->name. '<>' .$item->phone. '<>' .$item->email. '<>' .ucfirst($item->branch). '<>' .$item->guest_no. '<>' .$item->table_no. '<>' .$item->timeslot. '<>' .$item->pick_date. '<>' .$yourCurrCode. ' ' .$overallprice. '<>' .$payment_stat;
                    $temp_label = 'Status<>Menu Order<>Name<>Phone<>Email<>Branch<>Number of Guests<>Number of Tables<>Time Slot<>Picked Date<>Price<>Payment Status';
                    $bgcolor    = '';

                    if($item->status=='active') {
                        $bgcolor = 'rgb(15, 169, 21)';
                    } else if ($item->status=='inactive') {
                        $bgcolor = '#c7c7c7';
                    } else if ($item->status=='trash') {
                        $bgcolor = 'red';
                    } else if ($item->status=='cancelled') {
                        $bgcolor = 'grey';
                    } else {
                        $bgcolor = '#FF562D';
                    }
                    $data['event'][$key] = array(
                        array(
                            'start'             => $item->pick_date,
                            'name'              => $item->name,
                            'description'       => $temp_data .'+'.$temp_label.'+'.$item->id, 
                            'backgroundColor'   => $bgcolor
                        )
                    );
                }
            }   
            $data['success'] = true;
            $data['message'] = 'success';
            $data['typeee']  = sanitize_text_field($_GET['type']);
            unset($payment_stat);
            break;

        case 'car':
            $car_table     = $wpdb->prefix . "sync_options";
            $payment       = $wpdb->prefix . 'sync_payments';
            $currCode      = $wpdb->get_results( "SELECT option_value FROM $car_table WHERE option_name='sync_product_currency_code'" );
            $table_name    = $wpdb->prefix . "sync_rent_car_entries";
            $entries       = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
            $data['count'] = $wpdb->num_rows;
            $payment_stat  = "NOT YET PAID";
            if ( ! $entries ) {
                $wpdb->print_error(); 
            }else {
                $yourCurrCode;
                foreach ($entries as $key => $item) {
                    if($currCode[$key]->option_value != NULL){
                        $yourCurrCode = $currCode[$key]->option_value;
                    }
                    $temp_array = explode(',',$item->facility_request);
                    $temp_request= '';
                    foreach ($temp_array as $key2 => $value) {
                        preg_match('#\((.*?)\)#', $value, $match);
                        $temp_request .= ' > '.$value .'</br>';
                    }

                    $amount       = $wpdb->get_results("SELECT payment_gross, payment_status from $payment where item_cat = 'car' and item_belongsto = '".$item->id."';");
                    $driver_label = 'Driver';
                    $driver_info  = $item->with_driver; 
                    if($item->with_driver=='self-driven') {
                        $driver_label = 'Driver<>Driver\'s Name<>Driver\'s Phone No.<>Driver\'s License';
                        $driver_info  = ucfirst($item->with_driver).'<>'.$item->d_name.'<>'.$item->d_phone.'<>'.$item->d_license_image;
                    }

                    if ($amount[0]->payment_status == 'paid') {
                        $payment_stat = "PAID";
                    }

                    $date_start = new DateTime($item->pick_date);
                    $date_end   = new DateTime($item->return_date);
                    $number_days = $date_end->diff($date_start)->format("%a");
                    $meta = get_post_meta( $item->car_id, 'easync_car', true ); 
                    $temp_data = ucfirst($item->status).'<>'.get_post($item->car_id)->post_title.'<>'.$meta['type'].'<>'.$meta['model'].'<>'.$item->firstname.'<>'.$item->lastname.'<>'.$item->phone.'<>'.$item->email.'<>'.$driver_info.'<>'.$item->pick_date.'<>'.$item->pick_time.'<>'.$item->return_date.'<>'.$item->return_time.'<>'.$item->pick_location.'<>'.$number_days.'<>'.$yourCurrCode. ' '.$amount[0]->payment_gross.'<>'.$payment_stat;
                    $temp_label = 'Status<>Car Name<>Car Type<>Car Model<>First Name<>Last Name<>Phone No.<>Email Address<>'.$driver_label.'<>Pick Date<>Pick Time<>Return Date<>Return Time<>Pick Location<>Days<>Price<>Payment Status';
                    $bgcolor = '';
                    if($item->status=='active') {
                        $bgcolor = 'rgb(15, 169, 21)';
                    } else if ($item->status=='inactive') {
                        $bgcolor = '#c7c7c7';
                    } else if ($item->status=='trash') {
                        $bgcolor = 'red';
                    } else if ($item->status=='cancelled') {
                        $bgcolor = 'grey';
                    } else {
                        $bgcolor = '#FF562D';
                    }
                    $data['event'][$key] = array(
                        array(
                            'start'           => $item->pick_date,
                            'end'             => $item->return_date,
                            'firstname'       => $item->firstname,
                            'lastname'        => $item->lastname,
                            'description'     => $temp_data .'+'.$temp_label.'+'.$item->id,
                            'backgroundColor' => $bgcolor 
                        )
                    );
                }
            }   
            $data['success'] = true;
            $data['message'] = 'success';
            $data['typeee']  = sanitize_text_field($_GET['type']);
            unset($payment_stat);
        break;

        case 'hotel':
            session_start();
            $hotel_table   = $wpdb->prefix . "sync_options";
            $payment       = $wpdb->prefix . 'sync_payments';
            $currCode      = $wpdb->get_results( "SELECT option_value FROM $hotel_table WHERE option_name='sync_product_currency_code'" );
            $table_name    = $wpdb->prefix . "sync_hotel_entries";
            $entries       = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
            $data['count'] = $wpdb->num_rows;
            $payment_stat  = "NOT YET PAID";

            if ( ! $entries ) {
                $wpdb->print_error(); 
            } else {
                $yourCurrCode;
                foreach ($entries as $key => $item) {
                    if($currCode[$key]->option_value != NULL){
                        $yourCurrCode = $currCode[$key]->option_value;
                    }

                    $temp_array   = explode(',',$item->facility_request);
                    $temp_request = '';
                    $meta         = get_post_meta( $item->room_id, 'easync_hotel', true ); 
                    foreach ($temp_array as $key2 => $value) {
                        preg_match('#\((.*?)\)#', $value, $match);
                        $temp_request .= ' '.$value .'</br>';
                    }
                    $amount = $wpdb->get_results("SELECT payment_gross, payment_status from $payment where item_cat = 'hotel' and item_belongsto = '".$item->id."';");

                    if ($amount[0]->payment_status == 'paid') {
                        $payment_stat = "PAID";
                    }

                    $temp_data  = ucfirst($item->status).'<>'.get_post($item->room_id)->post_title.'<>'.$item->firstname.'<>'.$item->lastname.'<>'.$item->phone.'<>'.$item->email.'<>'.$item->arrival_date.'<>'.$item->departure_date.'<>'.$item->night_number.'<>'.$item->guest_number.'<>'.$item->room_number.'<>'.$temp_request.'<>'.$item->other_req.'<>'.$yourCurrCode . ' ' .$amount[0]->payment_gross. '<>' .$payment_stat ;
                    $temp_label = 'Status<>Room Type<>First Name<>Last Name<>Phone No.<>Email Address<>Check-in<>Check-out<>Number of Nights<>Number of Guests<>Total Room<>Facility request<>Other request<>Price<>Payment Status';
                    $bgcolor = '';
                    if($item->status=='active') {
                        $bgcolor = 'rgb(15, 169, 21)';
                    } else if ($item->status=='inactive') {
                        $bgcolor = '#c7c7c7';
                    } else if ($item->status=='trash'){
                        $bgcolor = 'red';
                    } else if ($item->status=='cancelled') {
                        $bgcolor = 'grey';
                    } else {
                        $bgcolor = '#FF562D';
                    }
                    $data['event'][$key] = array(
                        array(
                            'start'           => $item->arrival_date,
                            'end'             => $item->departure_date,
                            'firstname'       => $item->firstname,
                            'lastname'        => $item->lastname,
                            'description'     => $temp_data .'+'.$temp_label.'+'.$item->id,
                            'backgroundColor' => $bgcolor
                        )
                    );
                }
            }
            $data['success'] = true;
            $data['message'] = 'success';
            $data['typeee']  = sanitize_text_field($_GET['type']);
            unset($payment_stat);
        break;
        
        default:
            echo "error";
        break;
    }   
    echo json_encode($data);
    die();
}

add_action("wp_ajax_nopriv_easync_validation", "easync_validation");
add_action("wp_ajax_easync_validation", "easync_validation");
function easync_validation() {
    session_start();
    global $post, $wpdb;
    $errors      = array();      
    $data        = array();
    $menu        = array();
    $item        = array();
    $item_qty    = array();
    $item_price  = array();
    $is_required = array();
    $file1       = $_REQUEST['file1'];
    $file2       = $_REQUEST['file2'];
    $type        = '';
    $sani_type   = sanitize_text_field($_POST['type']);
    $option      = $wpdb->prefix . 'sync_options';

    if(isset($sani_type)) {
        $type = $sani_type;
    }
    switch ($type) {
        case 'hotel':
            if(!wp_verify_nonce($_POST['easync_hotel_nonce'], 'easync_hotel_to_pay')){
                return 'Not Allowed!';
            }

            $qry    = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_hotel_form_settings';");
            $values = $qry[0]->option_value;
            $tmp    = explode("-", $values);
            $fields = array("firstname", "lastname", "phone", "email");

            for ($i = 0; $i < count($tmp); $i+=2) {
                $is_required[] = $tmp[$i];
            }

            if ($is_required[0] == 'true') {
                if (empty(sanitize_text_field($_POST['firstname'])))
                $errors['firstname'] = 'This field is required.';
            }

            if ($is_required[1] == 'true') {
                if (empty(sanitize_text_field($_POST['lastname'])))
                $errors['lastname'] = 'This field is required.';
            }

            if ($is_required[2] == 'true') {
                if (empty($_POST['phone']))
                $errors['phone'] = 'This field is required.';
            }

            if ($is_required[3] == 'true') {
                if (empty(sanitize_email($_POST['email'])))
                $errors['email'] = 'This field is required.';
            }

            if (!empty($_POST['request_facilities']))
            $data['facility_request'] = implode(',', $_POST['request_facilities']);
            else
                $data['facility_request'] = '';

            if (!empty(sanitize_text_field($_POST['other_req'])))
                $data['other_req'] = sanitize_text_field($_POST['other_req']);
            else
                $data['other_req'] = '';

            if(!intval($_POST['hotel_guest_number']))
                die();

            if ( ! empty($errors)) {
                $data['success'] = false;
                $data['errors']  = $errors;
            }else{
                $data['success']          = true;
                $data['message']          = 'Success!';
                $data['firstname']        = sanitize_text_field($_POST['firstname']);
                $data['lastname']         = sanitize_text_field($_POST['lastname']);
                $data['phone']            = sanitize_text_field($_POST['phone']);
                $data['email']            = sanitize_email($_POST['email']);
                $data['date_arrive']      = sanitize_text_field($_POST['hotel_arrival_date']);
                $data['date_departure']   = sanitize_text_field($_POST['hotel_departure_date']);
                $data['night_number']     = intval($_POST['hotel_night_number']);
                $data['number_guest']     = sanitize_text_field($_POST['hotel_guest_number']);                      
                $data['number_room']      = sanitize_text_field($_POST['hotel_number_room']);
                $data['amount_to_pay']    = $_POST['amount_to_pay'];
                $data['reference_number'] = $_POST['reference_number'];
            }
        break;

        case 'car':
            if(!wp_verify_nonce($_POST['easync_car_nonce'], 'easync_car_to_pay')){
                return 'Not Allowed!';
            }
            $check_is_require = $_REQUEST['is_required'];
            $qry    = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_car_form_settings';");
            $values = $qry[0]->option_value;
            $tmp    = explode("-", $values);
            $fields = array("firstname", "lastname", "phone", "email");

            for ($i = 0; $i < count($tmp); $i+=2) {
                $is_required[] = $tmp[$i];
            }

            if ($is_required[0] == 'true') {
                if (empty(sanitize_text_field($_POST['firstname'])))
                $errors['firstname'] = 'This field is required.';
            }

            if ($is_required[1] == 'true') {
                if (empty(sanitize_text_field($_POST['lastname'])))
                $errors['lastname'] = 'This field is required.';
            }

            if ($is_required[2] == 'true') {
                if (empty($_POST['phone']))
                $errors['phone'] = 'This field is required.';
            }

            if ($is_required[3] == 'true') {
                if (empty(sanitize_email($_POST['email'])))
                $errors['email'] = 'This field is required.';
            }

            if ($check_is_require == 'on') {
                if (empty(sanitize_text_field($_POST['driver_name'])))
                    $errors['driver_name'] = 'This field is required.';

                if (empty(sanitize_text_field($_POST['driver_phone'])))
                    $errors['driver_phone'] = 'This field is required.';
                
                $fileInfo = wp_check_filetype( sanitize_text_field($file1) ); //Checking the uploaded file’s extension 
                if (!empty($fileInfo)) {
                    if(!empty(sanitize_text_field($_POST['file_empty1'])) && sanitize_text_field($_POST['file_empty1']) =='no-file')
                        $errors['file1'] = 'Image required.';

                    if ( ($fileInfo['ext'] == 'png') || ($fileInfo['ext'] == 'jpg') || ($fileInfo['ext'] == 'jpeg') ) {
                    }
                    else {
                        if(!empty(sanitize_text_field($_POST['file_empty1'])) && sanitize_text_field($_POST['file_empty1']) =='no-file') {
                            $errors['file1'] = 'Image required.';
                        }else {
                            $errors['file1'] = 'Invalid image.';
                        }
                    }
                }

                $fileInfo = wp_check_filetype( sanitize_text_field($file2) ); //Checking the uploaded file’s extension 
                if (!empty($fileInfo)) {

                    if ( ($fileInfo['ext'] == 'png') || ($fileInfo['ext'] == 'jpg') || ($fileInfo['ext'] == 'jpeg') ) {
                    }
                    else {
                        if(!empty(sanitize_text_field($_POST['file_empty2'])) && sanitize_text_field($_POST['file_empty2']) =='no-file') {
                            $errors['file2'] = 'Image required.';
                        }else {
                            $errors['file2'] = 'Invalid image.';
                        }
                    }
                }
            }

            if (!empty($_POST['request_facilities']))
                $data['facility_request'] = implode(',', $_POST['request_facilities']);
            else
                $data['facility_request'] = '';

            if (!empty(sanitize_text_field($_POST['other_req'])))
                $data['other_req'] = sanitize_text_field($_POST['other_req']);
            else
                $data['other_req'] = '';

            if(!intval($_POST['car_number_day']))
                die();
                
            if ( ! empty($errors)) {
                $data['success'] = false;
                $data['errors']  = $errors;
            }else{

                $meta = get_post_meta( get_the_ID(), 'easync_car', true ); 
                $data['success']            = true;
                $data['message']            = 'Success!';
                $data['firstname']          = sanitize_text_field($_POST['firstname']);
                $data['lastname']           = sanitize_text_field($_POST['lastname']);
                $data['phone']              = sanitize_text_field($_POST['phone']);
                $data['email']              = sanitize_email($_POST['email']);

                if ($check_is_require == "on") {
                    $data['driver_name']        = sanitize_text_field($_POST['driver_name']);
                    $data['driver_phone']       = sanitize_text_field($_POST['driver_phone']);
                }

                $data['date_pick']          = sanitize_text_field($_POST['car_pick_date']);
                $data['pick_time']          = sanitize_text_field($_POST['car_pick_time']);
                $data['pick_location']      = sanitize_text_field($_POST['car_pick_location']);
                $data['date_return']        = sanitize_text_field($_POST['car_return_date']);
                $data['return_time']        = sanitize_text_field($_POST['car_return_time']);
                $data['number_days']        = intval($_POST['car_number_day']);
                $data['with_or_out_driver'] = sanitize_text_field($_POST['with_or_out_driver']);
                $data['amount_to_pay_car']  = $_POST['amount_to_pay_car'];
                $data['reference_number']   = $_POST['reference_number'];
                $data['car_post_id']        = get_the_ID();
                $data['check_require']      = $check_is_require;
                                    
            }
        break;

        case 'restau':
            if(!wp_verify_nonce($_POST['easync_restau_nonce'], 'easync_restau_to_pay')){
                return 'Not Allowed!';
            }
            $temp_data   = "";
            $total_items = "";
            $temp_data2  = array();
            $temp_data3  = array();
            $item_arr    = array();
            $item_id     = array();
            $item_each   = array();
            $qty         = array();

            if (empty($_POST['check_dish']) || empty($_POST['qty'])){
                $errors['menu_ids'] = 'Please select at least one item.';
            }else{
                $check_dish = $_POST['check_dish'];
                $qnty       = $_POST['qty'];
                $qty_       = $_POST['item_size'];
                if (!empty($qty_)) {
                    $qty = explode(",", $qty_);
                }

                if($qnty){
                    foreach($check_dish as $key => $value){
                        $temp_data       .= $value." ( QTY ".$qnty[$key]."),";
                        $item[$key]       = get_post($value)->post_title." ( QTY ".$_POST['qty'][$key].")";
                        $item_qty[$key]   = $qty[$key];
                        $item_price[$key] = (get_post_meta($value, 'sync_restau', true)['price'] * $qnty[$key]);
                        array_push($qty, $qnty[$key]);
                    }  
                    $total_items = array_sum($qty);
                    $reserved_items = $_REQUEST['reserved_items'];

                    if (!empty($reserved_items)) {
                        $filter = explode("],[", $reserved_items);
                        for ($i = 0; $i < count($filter); $i++) {
                            $item_arr[] = str_replace(array('[',']'), '',$filter[$i]);
                        }
                    }
                    array_push($item_arr, rtrim($temp_data,','));

                    for ($j = 0; $j < count($item_arr); $j++) {
                        $item_each[] = explode(",", $item_arr[$j]);
                        for ($k = 0; $k < count($item_each[$j]); $k++) {
                            $item_id[] = explode(" ( ", $item_each[$j][$k], 2);
                        }
                    }

                    for ($i = 0; $i < count($item_id); $i++) {
                        $temp_data2[] = rtrim((get_post($item_id[$i][0])->post_title),',');
                        $temp_data3[] = (get_post_meta($item_id[$i][0], 'sync_restau', true)['price'] * $qty[$i]);
                    }
                }
                $data['item_arr'] = $item_arr;
                
                $_SESSION['items_ordered'] = $temp_data2;
                $data['name']              = $_POST['c_name'];
                $data['email_add']         = $_POST['email_add'];
                $data['phone_no']          = $_POST['phone_no'];
                $data['guest_no']          = $_POST['guest_no'];
                $data['table_no']          = $_POST['table_no'];
                $data['branch']            = $_POST['branch'];
                $data['picked_date']       = $_POST['picked_date'];
                $data['timeslot']          = $_POST['timeslot'];
                $data['items']             = $item_id;
                $data['item_qtys']         = $item_qty;
                $data['item_prices']       = $item_price;
                $data['reserved']          = $item_each;
                $data['item_qty']          = $total_items;
                $data['table_ids']         = $_POST['table_id'];                    
            }
            if ( ! empty($errors)) {
                $data['success'] = false;
                $data['errors']  = $errors;
            } else {
                $data['success']          = true;
                $data['message']          = 'Success!'; 
                $data['menu_ids']         = rtrim($temp_data,',');
                $data['paypal_dis']       = $temp_data2;
                $data['paypal_dis_price'] = $temp_data3;
                $data['amount_to_pay']    = $_POST['amount_to_pay_restau'];
                $data['reference_num']    = $_POST['reference_number'];
            }
        break;

        case 'restau-second':
            $date_chosen    = sanitize_text_field($_POST['picked_date']);
            $timeslot_range = explode('-', sanitize_text_field($_POST['timeslot']));
            $from           = date_create($timeslot_range[0]);
            $to             = date_create($timeslot_range[1]);
            $from_format = date_format($from, 'h:i a');
            $to_format      = date_format($to, 'h:i a');
            $cur_date       = date('m/d/Y');
            $cur_time       = date("h:i a");

            if ($cur_date == $date_chosen) 
                if ( ($cur_time > $from_format) && ($cur_time > $to_format) ) {
                    $errors['timeslot'] = 'Selected timeslot is already past the current time.';
                }

            if (empty(sanitize_text_field($_POST['full_name'])))
                $errors['namee']     = 'This field is required.';

            if (empty(sanitize_email($_POST['email_add'])))
                $errors['email']    = 'This field is required.';

            if (empty(sanitize_text_field($_POST['phone_no'])))
                $errors['phone_no'] = 'This field is required.';

            if (empty(sanitize_text_field($_POST['branch'])))
                $errors['branch']   = 'This field is required.';

            if (empty(sanitize_text_field($_POST['table_no'])))
                $errors['table_no'] = 'This field is required.';

            if (empty(sanitize_text_field($_POST['guest_no'])))
                $errors['guest_no'] = 'This field is required.';

            if (empty(sanitize_text_field($_POST['timeslot'])))
                $errors['timeslot'] = 'This field is required.';

            if (empty(sanitize_text_field($_POST['picked_date'])))
                $errors['picked_date'] = 'This field is required.';

            if(!intval($_POST['guest_no']))
                die();

            if(!intval($_POST['table_no']))
                die();   

            if ( ! empty($errors)) {
                $data['success'] = false;
                $data['errors']  = $errors;
            } else {
                $data['success']     = true;
                $data['message']     = 'Success!';
                $data['name']        =  sanitize_text_field($_POST['full_name']);
                $data['email']       =  sanitize_email($_POST['email_add']);
                $data['phone_no']    =  sanitize_text_field($_POST['phone_no']);
                $data['branch']      =  sanitize_text_field($_POST['branch']);
                $data['guest_no']    =  intval($_POST['guest_no']);
                $data['table_no']    =  intval($_POST['table_no']);
                $data['timeslot']    =  sanitize_text_field($_POST['timeslot']);
                $data['picked_date'] =  sanitize_text_field($_POST['picked_date']);
            }
            $_SESSION['n4me']         = sanitize_text_field($_POST['full_name']);
            $_SESSION['em4il']        = sanitize_text_field($_POST['email_add']);
            $_SESSION['number']       = sanitize_text_field($_POST['phone_no']);
            $_SESSION['br4nch']       = sanitize_text_field($_POST['branch']);
            $_SESSION['guest_number'] = sanitize_text_field($_POST['guest_no']);
            $_SESSION['table_number'] = sanitize_text_field($_POST['table_no']);
            $_SESSION['time']         = sanitize_text_field($_POST['timeslot']);
            $_SESSION['p1cked_date']  = sanitize_text_field($_POST['picked_date']);
            $_SESSION['reserved']     = $item_arr;
        break;

        case 'car-payment':
        case 'hotel-payment':
        case 'restau-payment':
            if(!wp_verify_nonce($_POST['easync_payment_nonce'], 'easync_payment')){
                return 'Not Allowed!';
            }
            if (empty(sanitize_text_field($_POST['address_1'])))
                $errors['address_1']     = 'The address 1 field is required.';

            if (empty(sanitize_text_field($_POST['address_2'])))
                $errors['address_2']    = 'The address 2 field  is required.';

            if (empty(sanitize_text_field($_POST['city'])))
                $errors['city'] = 'The city field  is required.';

            if (empty(sanitize_text_field($_POST['province'])))
                $errors['province']   = 'The province field is required.';

            if (empty(sanitize_text_field($_POST['postal_code'])))
                $errors['postal_code'] = 'The postal_code field is required.';

            if ( ! empty($errors)) {
                $data['success'] = false;
                $data['errors']  = $errors;
            } else {
                $data['success'] = true;
            }
        break;

        default:
            echo "error";
        break;
    }    
   echo json_encode($data);
   die();
}

add_action("wp_ajax_nopriv_easync_session_store", "easync_session_store");
add_action("wp_ajax_easync_session_store", "easync_session_store");
function easync_session_store() {
    global $wpdb;
    session_start();
    $data              = array(); 
    $errors            = array();       
    $entries           = array();
    $trigger_on        = 'save';
    $table             = $wpdb->prefix . "sync_options";
    $data['success']   = false;
    $data['message']   = 'failed!';
    $type              = '';
    $sani_type         = sanitize_text_field($_POST['type']);
    if(isset($sani_type)) {
        $type = $sani_type;
    }
    switch ($type) {
        case 'hotel':
            $meta                      = get_post_meta( sanitize_text_field($_POST['room_id']), 'sync_hotel', true );
            $data['subtotal']          = ($_POST['amount'] * (sanitize_text_field($_POST['room_number']) * sanitize_text_field($_POST['night_number'])));
            $data['total']             = $data['subtotal'];
            $data['success']           = true;
            $data['message']           = 'Success!';
            $_SESSION['amount_to_pay'] = $_POST['amount_to_pay'];
            $table                     = $wpdb->prefix . "sync_hotel_entries";
            $entries = array(
                'firstname'        =>   sanitize_text_field($_POST['firstname']),
                'lastname'         =>   sanitize_text_field($_POST['lastname']),
                'phone'            =>   sanitize_text_field($_POST['phone']),
                'email'            =>   sanitize_email($_POST['email']),
                'room_id'          =>   sanitize_text_field($_POST['room_id']),
                'arrival_date'     =>   sanitize_text_field($_POST['arrival_date']),       
                'departure_date'   =>   sanitize_text_field($_POST['departure_date']),
                'night_number'     =>   intval($_POST['night_number']),
                'guest_number'     =>   intval($_POST['guest_number']),
                'room_number'      =>   intval($_POST['room_number']),
                'facility_request' =>   sanitize_text_field($_POST['facility_request']), //bug here
                'other_req'        =>   sanitize_text_field($_POST['other_req']),
                'address_1'        =>   sanitize_text_field($_POST['address_1']),
                'address_2'        =>   sanitize_text_field($_POST['address_2']),
                'city'             =>   sanitize_text_field($_POST['city']),
                'province'         =>   sanitize_text_field($_POST['province']),
                'postal_code'      =>   sanitize_text_field($_POST['postal_code']),
                'status'           =>   'pending',
                'reference_number' =>   $_POST['reference_number'],
            );
            $_SESSION['sync_entries'] = $entries;
        break;

        case 'car':
            // $meta                       = get_post_meta( sanitize_text_field($_POST['car_id']), 'sync_car', true );
            // $data['subtotal']           = ($meta['price'] * sanitize_text_field($_POST['number_days']));
            // $data['total']              = $data['subtotal'];
            $require_check                 = $_REQUEST['is_required'];
            $data['success']            = true;
            $data['message']            = 'Success!';
            $_SESSION['amount_to_pay_car'] = $_POST['amount_to_pay_car'];
            $_SESSION['require']           = $require_check;

            if ($require_check == 'on') {
                $image_path = '';
                if(sanitize_text_field($_POST['with_or_out_driver'])=='self-driven') {
                    $uploads = wp_upload_dir();
                    $driver_license_image = array('driver_license_image1', 'driver_license_image2');
                    $validextensions = array("jpeg", "jpg", "png");
    
                    foreach ($driver_license_image as $key => $value) {
    
                        $unique_name = md5(uniqid());      
                        $ext = wp_check_filetype( sanitize_text_field($_FILES[$value]['name']) );
    
                        foreach ($validextensions as $extn => $extn_val ) {
                            if ($ext == $extn_val) {
                                $target_path = esc_url($uploads['basedir'].'/') . $unique_name . "." . $ext['ext'];
                                if (move_uploaded_file($_FILES[$value]['tmp_name'], $target_path)) { 
                                    $image_path .= esc_url($uploads['baseurl'].'/').$unique_name . "." . $ext['ext'] .'|';
                                }else{
                                    $image_path = 'error';
                                    $data['message']  = 'please try again!.';
                                }
                            }
                        }
    
                    }   
    
                    $image_path = rtrim($image_path,'|');
                }

                $table = $wpdb->prefix . "sync_rent_car_entries";
                $entries = array(
                    'firstname'         =>   sanitize_text_field($_POST['firstname']),
                    'lastname'          =>   sanitize_text_field($_POST['lastname']),
                    'phone'             =>   sanitize_text_field($_POST['phone']),
                    'email'             =>   sanitize_email($_POST['email']),
                    'with_driver'       =>   sanitize_text_field($_POST['with_or_out_driver']),
                    'd_name'            =>   sanitize_text_field($_POST['driver_name']),
                    'd_phone'           =>   sanitize_text_field($_POST['driver_phone']),
                    'd_license_image'   =>   $image_path,
                    'car_id'            =>   sanitize_text_field($_POST['car_id']),
                    'pick_date'         =>   sanitize_text_field($_POST['date_pick']),       
                    'pick_time'         =>   sanitize_text_field($_POST['pick_time']),
                    'return_date'       =>   sanitize_text_field($_POST['date_return']),
                    'return_time'       =>   sanitize_text_field($_POST['return_time']),
                    'pick_location'     =>   sanitize_text_field($_POST['pick_location']),
                    'number_days'       =>   intval($_POST['number_days']),
                    'facility_request'  =>   sanitize_text_field($_POST['facility_request']), //bug here
                    'other_req'         =>   sanitize_text_field($_POST['other_req']),
                    'address_1'         =>   sanitize_text_field($_POST['address_1']),
                    'address_2'         =>   sanitize_text_field($_POST['address_2']),
                    'city'              =>   sanitize_text_field($_POST['city']),
                    'province'          =>   sanitize_text_field($_POST['province']),
                    'postal_code'       =>   sanitize_text_field($_POST['postal_code']),
                    'status'            =>   'pending',
                    'reference_number'  =>   $_POST['reference_number'],
                );
            } else {
                $entries = array(
                    'firstname'         =>   sanitize_text_field($_POST['firstname']),
                    'lastname'          =>   sanitize_text_field($_POST['lastname']),
                    'phone'             =>   sanitize_text_field($_POST['phone']),
                    'email'             =>   sanitize_email($_POST['email']),
                    'with_driver'       =>   sanitize_text_field($_POST['with_or_out_driver']),
                    'car_id'            =>   sanitize_text_field($_POST['car_id']),
                    'pick_date'         =>   sanitize_text_field($_POST['date_pick']),       
                    'pick_time'         =>   sanitize_text_field($_POST['pick_time']),
                    'return_date'       =>   sanitize_text_field($_POST['date_return']),
                    'return_time'       =>   sanitize_text_field($_POST['return_time']),
                    'pick_location'     =>   sanitize_text_field($_POST['pick_location']),
                    'number_days'       =>   intval($_POST['number_days']),
                    'facility_request'  =>   sanitize_text_field($_POST['facility_request']), //bug here
                    'other_req'         =>   sanitize_text_field($_POST['other_req']),
                    'address_1'         =>   sanitize_text_field($_POST['address_1']),
                    'address_2'         =>   sanitize_text_field($_POST['address_2']),
                    'city'              =>   sanitize_text_field($_POST['city']),
                    'province'          =>   sanitize_text_field($_POST['province']),
                    'postal_code'       =>   sanitize_text_field($_POST['postal_code']),
                    'status'            =>   'pending',
                    'reference_number'  =>   $_POST['reference_number'],

                );
            }
            

            //$_SESSION['sries'] =ync_ent $entries;
            $_SESSION['sync_entries'] = $entries;
            break;

        case 'restau':
            $table                            = $wpdb->prefix . "sync_restau_entries";
            $data['total']                    = $_POST['amount_to_pay_restau'];
            $data['success']                  = true;
            $data['message']                  = 'Success!';
            $_SESSION['amount_to_pay_restau'] = $_POST['amount_to_pay_restau'];
            $_SESSION['menu_reserved']        = $_POST['menu_reserved'];
            $_SESSION['item_prices']          = $_POST['item_prices'];
            $_SESSION['menu_ids']             = $_POST['menu_ids'];
            $_SESSION['item_qty']             = $_POST['item_qty_each'];
            $_SESSION['table_ids']            = $_POST['table_ids'];
            
            $entries = array(
                    'name'             =>  sanitize_text_field($_POST['name']),
                    'phone'            =>  sanitize_text_field($_POST['phone_no']),
                    'email'            =>  sanitize_email($_POST['email']),
                    'branch'           =>  sanitize_text_field($_POST['branch']),
                    'guest_no'         =>  intval($_POST['guest_no']),
                    'table_no'         =>  intval($_POST['table_no']),       
                    'timeslot'         =>  sanitize_text_field($_POST['timeslot']),
                    'pick_date'        =>  sanitize_text_field($_POST['picked_date']),
                    'address_1'        =>  sanitize_text_field($_POST['address_1']),
                    'address_2'        =>  sanitize_text_field($_POST['address_2']),
                    'city'             =>  sanitize_text_field($_POST['city']),
                    'province'         =>  sanitize_text_field($_POST['province']),
                    'postal_code'      =>  sanitize_text_field($_POST['postal_code']),
                    'status'           =>  'pending',
                    'reference_number' =>  $_POST['reference_number'],
            );
            $_SESSION['sync_entries'] = $entries;
        break;
        
        default:
            echo "error";       
            break;
    }
    echo json_encode($_SESSION['menu_ids']);
    die();
}

add_action("wp_ajax_easync_cancellation_settings", "easync_cancellation_settings");
function easync_cancellation_settings() {
    global $wpdb;
    $data            = array(); 
    $data['success'] = false;
    $data['message'] = 'failed!';
    $policy_page     = sanitize_text_field($_POST['sync_hotel_cancellation']);
    $grace_period    = sanitize_text_field($_POST['cancel_day']);
    $refund_rate     = sanitize_text_field($_POST['refund_rate']);
    $table_check     = $wpdb->prefix . "sync_options"; 
    $check_page      = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_page_cancellation'));
    if(count($check_page) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_hotel_page_cancellation','".$policy_page."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $policy_page, "sync_hotel_page_cancellation"));
    }

    $check_graceP = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_grace_period'));
    if(count($check_graceP) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_hotel_grace_period','".$grace_period."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $grace_period, "sync_hotel_grace_period"));
    }

    $refund_rte = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_refund_rate'));
    if(count($refund_rte) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_hotel_refund_rate','".$refund_rate."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $refund_rate, "sync_hotel_refund_rate"));
    }
    $data['success']  = true;
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_easync_cancellation_settings_car", "easync_cancellation_settings_car");
function easync_cancellation_settings_car() {
    global $wpdb;
    $data            = array(); 
    $data['success'] = false;
    $data['message'] = 'failed!';
    $policy_page     = sanitize_text_field($_POST['sync_car_cancellation']);
    $grace_period    = sanitize_text_field($_POST['cancel_day']);
    $refund_rate     = sanitize_text_field($_POST['refund_rate']);
    $table_check     = $wpdb->prefix . "sync_options"; 
    $check_page      = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_page_cancellation'));
    if(count($check_page) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_car_page_cancellation','".$policy_page."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $policy_page, "sync_car_page_cancellation"));
    }

    $check_graceP = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_grace_period'));
    if(count($check_graceP) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_car_grace_period','".$grace_period."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $grace_period, "sync_car_grace_period"));
    }

    $refund_rte = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_refund_rate'));
    if(count($refund_rte) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_car_refund_rate','".$refund_rate."')");
    } else{
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $refund_rate, "sync_car_refund_rate"));
    }
    $data['success']  = true;
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_easync_cancellation_settings_restau", "easync_cancellation_settings_restau");
function easync_cancellation_settings_restau() {
    global $wpdb;
    $data         = array(); 
    $policy_page  = sanitize_text_field($_REQUEST['sync_restau_cancel']);
    $grace_period = sanitize_text_field($_REQUEST['cancel_day']);
    $refund_rate  = sanitize_text_field($_REQUEST['refund_rate']);
    $table_check  = $wpdb->prefix . "sync_options"; 
    $check_page   = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_page_cancellation'));
    if(count($check_page) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_restau_page_cancellation','".$policy_page."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $policy_page, "sync_restau_page_cancellation"));
    }

    $check_graceP = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_grace_period'));
    if(count($check_graceP) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_restau_grace_period','".$grace_period."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $grace_period, "sync_restau_grace_period"));
    }

    $refund_rte = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_refund_rate'));
    if(count($refund_rte) == 0) {
        $insert = $wpdb->query("INSERT INTO $table_check(option_name, option_value) VALUES('sync_restau_refund_rate','".$refund_rate."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $refund_rate, "sync_restau_refund_rate"));
    }
    $data['success']  = true;
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_easync_setting_save", "easync_setting_save");
function easync_setting_save() {
    global $wpdb;
    $data            = array(); 
    $errors          = array();       
    $entries         = array();
    $trigger_on      = 'save';
    $option          = '';
    $table           = $wpdb->prefix . "sync_options"; 
    $data['success'] = false;
    $data['message'] = 'failed!';
    $type            = '';
    $sani_type       = sanitize_text_field($_POST['type']);
    if(isset($sani_type)) {
        $type = $sani_type;
    }
    switch ($type) {
        case 'option_paypal_set':
            $temp_val = sanitize_text_field($_POST['sync_paypal_sandbox']).'<>'.sanitize_text_field($_POST['sync_paypal_production']).'<>'.sanitize_text_field($_POST['sync_paypal_use']);
            
            if(empty(sanitize_text_field($_POST['sync_paypal_production'])) ) {

                $temp_val = sanitize_text_field($_POST['sync_paypal_sandbox']).'<>none<>'.sanitize_text_field($_POST['sync_paypal_use']);
            }
            if(empty(sanitize_text_field($_POST['sync_paypal_sandbox'])) ) {

                $temp_val = 'none<>'.sanitize_text_field($_POST['sync_paypal_production']).'<>'.sanitize_text_field($_POST['sync_paypal_use']);
            }
            if(empty(sanitize_text_field($_POST['sync_paypal_use'])) ) {

                $temp_val = 'none<>'.sanitize_text_field($_POST['sync_paypal_production']).'<>sandbox';
            }     
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_paypal_setting'");
            if(empty($row)) {
                $entries_pay = array(
                     'option_name'    =>   'sync_paypal_setting',
                     'option_value'   =>   $temp_val,
                );
                $wpdb->insert($table, $entries_pay);
            } else {     
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_paypal_setting' ));
            }
            
            $data['success']  = true;
            $data['message']   = 'success!';
        break;

        case 'option_default_car_time':
            $temp_val = sanitize_text_field($_POST['sync_default_pickup']).'-'.sanitize_text_field($_POST['sync_default_return']);
            if(!empty(sanitize_text_field($_POST['sync_default_return'])) && !empty(sanitize_text_field($_POST['sync_default_pickup'])) && wp_verify_nonce($_POST['easync_car_default_time_nonce'], 'easync_car_default_time')) {
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_car_default_time' ));
                $trigger_on = 'update';
                $data['success']  = true;
                $data['message']   = 'success!';
            }
        break;

        case 'option_product_currency':
            $temp_val = sanitize_text_field($_POST['sync_currency_name']);
            $row = $wpdb->get_results(  "SELECT * FROM $table
                WHERE option_name = 'sync_product_currency_code'");
            if(!empty(sanitize_text_field($_POST['sync_currency_name']))) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_product_currency_code',
                        'option_value'   =>   $temp_val,
                    );
                }else{
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_product_currency_code' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
                $data['message']   = 'success!';
            }
        break;

        case 'option_switch_hotel':
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_switch_hotel'");
            $on = '';
            if(!empty(sanitize_text_field($_POST['sync_switch']))) {
                $on = sanitize_text_field($_POST['sync_switch']);
            }else{
                $on = 'off';
            }
            if(empty($row)) {
                $entries = array(
                    'option_name'    =>   'sync_switch_hotel',
                    'option_value'   =>   $on,
                );
            }else{
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $on, 'sync_switch_hotel' ));
                $trigger_on = 'update';
            }
            $data['success']        = true;
            $data['message']        = 'Success!';
        break;

        case 'option_switch_captcha':
            $row = $wpdb->get_results("SELECT * FROM $table WHERE option_name = 'sync_captcha_switch';");
            $on = '';
            if(!empty(sanitize_text_field($_POST['sync_switch']))) {
                $on = sanitize_text_field($_POST['sync_switch']);
            }else{
                $on = 'off';
            }
            if(empty($row)) {
                $entries = array(
                    'option_name'    =>   'sync_captcha_switch',
                    'option_value'   =>   $on,
                );
            }else{
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $on, 'sync_captcha_switch' ));
                $trigger_on = 'update';
            }
            $data['success']        = true;
            $data['message']        = 'Success!';
        break;

        case 'option_switch_driver':
            $row = $wpdb->get_results(  "SELECT * FROM $table
            WHERE option_name = 'sync_driver_switch'");
            $on = '';
            if(!empty(sanitize_text_field($_POST['sync_switch']))) {
                $on = sanitize_text_field($_POST['sync_switch']);
            }else{
                $on = 'off';
            }
            if(empty($row)) {
                $entries = array(
                    'option_name'    =>   'sync_driver_switch',
                    'option_value'   =>   $on,
                );
            }else{
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $on, 'sync_driver_switch' ));
                $trigger_on = 'update';
            }
            $data['success']        = true;
            $data['message']        = 'Success!';
        break;

        case 'option_switch_car':
            $row = $wpdb->get_results(  "SELECT * FROM $table  WHERE option_name = 'sync_switch_car'");
            $on  = '';
            if(!empty(sanitize_text_field($_POST['sync_switch']))) {
                $on = sanitize_text_field($_POST['sync_switch']);
            }else{
                $on = 'off';
            }
            if(empty($row)) {
                $entries = array(
                    'option_name'    =>   'sync_switch_car',
                    'option_value'   =>   $on,
                );
            }else{
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $on, 'sync_switch_car' ));
                $trigger_on = 'update';
            }
            $data['success'] = true;
            $data['message'] = 'Success!';
        break;

        case 'option_switch_restau':
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_switch_restau'");
            $on = '';
            if(!empty(sanitize_text_field($_POST['sync_switch']))) {
                $on = sanitize_text_field($_POST['sync_switch']);
            }else{
                $on = 'off';
            }
            if(empty($row)) {
                $entries = array(
                    'option_name'    =>   'sync_switch_restau',
                    'option_value'   =>   $on,
                );
            } else { 
                $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $on, 'sync_switch_restau' ));
                $trigger_on = 'update';
            }
            $data['success']        = true;
            $data['message']        = 'Success!'; 
        break;
                
        case 'option_branch':
            if(!empty(sanitize_text_field($_POST['branch_name'])) && wp_verify_nonce($_POST['easync_restau_branch_nonce'], 'easync_restau_branch')) {
                $temp_id   = sanitize_text_field($_POST['branch_id']);
                $temp_name = sanitize_text_field($_POST['branch_name']);
                if ($_POST['trig']=='save') {
                    $entries = array(
                    'option_name'    =>   'sync_branch_locations',
                    'option_value'   =>   $temp_name,
                    );
                } else if ($_POST['trig']=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                } else if ($_POST['trig']=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $option = 'sync_branch_locations';
                $data['success']  = true;
            }else{
                $data['success']  = false;
            }
        break;

        case 'option_currency':
            if(!empty(sanitize_text_field($_POST['sync_currency_name']))) {
                $temp_id   = sanitize_text_field($_POST['sync_currency_id']);
                $temp_name = sanitize_text_field($_POST['sync_currency_name']);
                if ($_POST['trig']=='save') {
                    $entries = array(
                        'option_name'    =>   'sync_currency',
                        'option_value'   =>   $temp_name,
                    );
                } else if (sanitize_text_field($_POST['trig'])=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                } else if ($_POST['trig']=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $option          = 'sync_currency';
                $data['success']  = true;
            }else{
                $data['success']  = false;
            }
        break;

        case 'option_pickup_location':
            if(!empty(sanitize_text_field($_POST['location_name'])) && wp_verify_nonce($_POST['easync_car_pickup_nonce'], 'easync_car_pickup')) {
                $temp_id   = sanitize_text_field($_POST['pickup_id']);
                $temp_name =sanitize_text_field($_POST['location_name']);  
                if($_POST['trig']=='save') {
                    $entries = array(
                        'option_name'    =>   'sync_car_pickup',
                        'option_value'   =>   $temp_name,
                    );
                } else if (sanitize_text_field($_POST['trig'])=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                } else if (sanitize_text_field($_POST['trig'])=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $option = 'sync_car_pickup';
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_car_types':
            if(!empty(sanitize_text_field($_POST['type_name'])) && wp_verify_nonce($_POST['easync_car_types_nonce'], 'easync_car_types')) {
                $temp_id   = sanitize_text_field($_POST['type_id']);
                $temp_name = sanitize_text_field($_POST['type_name']); 
                if(sanitize_text_field($_POST['trig'])=='save') {
                    $entries = array(
                        'option_name'    =>   'sync_car_types',
                        'option_value'   =>   $temp_name,
                    );
                } else if (sanitize_text_field($_POST['trig'])=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                }else if(sanitize_text_field($_POST['trig'])=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $option           = 'sync_car_types';
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_car_thanks':
            if(!empty(sanitize_text_field($_POST['sync_car_thank_you'])) && wp_verify_nonce($_POST['easync_car_thank_u_nonce'], 'easync_car_thank_u')) {
                $temp_name = sanitize_text_field($_POST['sync_car_thank_you']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_page_thank_u'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_car_page_thank_u',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_car_page_thank_u"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_car_privacy':
            if(!empty(sanitize_text_field($_POST['sync_car_privacy'])) && wp_verify_nonce($_POST['easync_car_privacy_nonce'], 'easync_car_privacy')) {
                $temp_name = sanitize_text_field($_POST['sync_car_privacy']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_page_privacy'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_car_page_privacy',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_car_page_privacy"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_car_terms':
            if(!empty(sanitize_text_field($_POST['sync_car_terms'])) && wp_verify_nonce($_POST['easync_car_terms_nonce'], 'easync_car_terms')) {
                $temp_name = sanitize_text_field($_POST['sync_car_terms']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_car_page_terms'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_car_page_terms',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_car_page_terms"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            }else{
                $data['success']  = false;
            }
        break;    

        case 'option_hotel_thanks':
            if(!empty($_POST['sync_hotel_thank_you']) && wp_verify_nonce($_POST['easync_hotel_thank_you_nonce'], 'easync_hotel_thank_you')) {
                $temp_name = sanitize_text_field($_POST['sync_hotel_thank_you']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_page_thank_u'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_hotel_page_thank_u',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_hotel_page_thank_u"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_hotel_privacy':
            if(!empty(sanitize_text_field($_POST['sync_hotel_privacy'])) && wp_verify_nonce($_POST['easync_hotel_privacy_nonce'], 'easync_hotel_privacy')) {
                $temp_name = sanitize_text_field($_POST['sync_hotel_privacy']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_page_privacy'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_hotel_page_privacy',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_hotel_page_privacy"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;
        
        case 'option_hotel_terms':
            if(!empty(sanitize_text_field($_POST['sync_hotel_terms'])) && wp_verify_nonce($_POST['easync_hotel_terms_nonce'], 'easync_hotel_terms')) {
                $temp_name = sanitize_text_field($_POST['sync_hotel_terms']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_hotel_page_terms'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_hotel_page_terms',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table_check SET option_value = %s WHERE option_name = %s", $temp_name, "sync_hotel_page_terms"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_restau_thanks':
            if(!empty(sanitize_text_field($_POST['sync_restau_thank_you'])) && wp_verify_nonce($_POST['easync_restau_thank_u_nonce'], 'easync_restau_thank_u')) {
                $temp_name = sanitize_text_field($_POST['sync_restau_thank_you']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_page_thank_u'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_page_thank_u',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_page_thank_u"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_restau_privacy':
            if(!empty(sanitize_text_field($_POST['sync_restau_privacy'])) && wp_verify_nonce($_POST['easync_restau_privacy_nonce'], 'easync_restau_privacy')) {
                $temp_name = sanitize_text_field($_POST['sync_restau_privacy']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_page_privacy'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_page_privacy',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_page_privacy"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_restau_terms':
            if(!empty(sanitize_text_field($_POST['sync_restau_terms'])) && wp_verify_nonce($_POST['easync_restau_terms_nonce'], 'easync_restau_terms')) {
                $temp_name = sanitize_text_field($_POST['sync_restau_terms']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_page_terms'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_page_terms',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_page_terms"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;  

        case 'option_banner_image':
            if(!empty(sanitize_text_field($_POST['myprefix_image_id'])) && wp_verify_nonce($_POST['easync_restau_banner_image_nonce'], 'easync_restau_banner_image')) {
                $temp_name = sanitize_text_field($_POST['myprefix_image_id']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_banner_image'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_banner_image',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_banner_image"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;

        case 'option_email_image':
            if(!empty(sanitize_text_field($_POST['myprefix_image_id']))) {
                $temp_name =sanitize_text_field($_POST['myprefix_image_id']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_user_email_image'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_user_email_image',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_user_email_image"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;          

        case 'option_car_model':
            if(!empty(sanitize_text_field($_POST['model_name']))  && wp_verify_nonce($_POST['easync_car_model_nonce'], 'easync_car_model')) {
                $temp_id   = sanitize_text_field($_POST['model_id']);
                $temp_name = sanitize_text_field($_POST['model_name']);    
                if(sanitize_text_field($_POST['trig'])=='save') {
                    $entries = array(
                        'option_name'    =>   'sync_car_model',
                        'option_value'   =>   $temp_name,
                    );
                } else if (sanitize_text_field($_POST['trig'])=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                } else if (sanitize_text_field($_POST['trig'])=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $option = 'sync_car_model';
                $data['success']  = true;
            } else {
                $data['success']  = false;
            }
        break;    

        case 'option_billing_province':
            if(!empty(sanitize_text_field($_POST['province_name']))) {
                $temp_id   = sanitize_text_field($_POST['province_id']);
                $temp_name = sanitize_text_field($_POST['province_name']); 
                if(sanitize_text_field($_POST['trig'])=='save') {
                    $entries = array(
                        'option_name'    =>   'sync_billing_province',
                        'option_value'   =>   $temp_name,
                    );
                } else if (sanitize_text_field($_POST['trig'])=='update') {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE id = %d", $temp_name, $temp_id));
                    $trigger_on = 'update';
                } else if (sanitize_text_field($_POST['trig'])=='delete') {
                    $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $temp_id));
                    $trigger_on = 'delete';
                }
                $data['success']  = true;
            }else{
                $data['success']  = false;
            }
        break;

        case 'option_timeslot1':
            $temp_val = sanitize_text_field($_POST['timeslot1']).'-'.sanitize_text_field($_POST['timeslot1_1']);
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_timeslot1'");
            if(!empty(sanitize_text_field($_POST['timeslot1'])) && !empty(sanitize_text_field($_POST['timeslot1_1'])) && wp_verify_nonce($_POST['easync_restau_timeslot_1_nonce'], 'easync_restau_timeslot_1')) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_timeslot1',
                        'option_value'   =>   $temp_val,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %sWHERE option_name = %s", $temp_val, 'sync_timeslot1' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {  
                $data['success']  = false;
            }
        break;

        case 'option_timeslot2':
            $temp_val = sanitize_text_field($_POST['timeslot2']).'-'.sanitize_text_field($_POST['timeslot1_2']);
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_timeslot2'");
            if(!empty(sanitize_text_field($_POST['timeslot2'])) && !empty(sanitize_text_field($_POST['timeslot1_2'])) && wp_verify_nonce($_POST['easync_restau_timeslot_2_nonce'], 'easync_restau_timeslot_2')) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_timeslot2',
                        'option_value'   =>   $temp_val,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_timeslot2' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {  
                $data['success']  = false;
            }
        break;

        case 'option_timeslot3':
            $temp_val = sanitize_text_field($_POST['timeslot3']).'-'.sanitize_text_field($_POST['timeslot1_3']);
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_timeslot3'");
            if(!empty(sanitize_text_field($_POST['timeslot3'])) && !empty(sanitize_text_field($_POST['timeslot1_3'])) && wp_verify_nonce($_POST['easync_restau_timeslot_3_nonce'], 'easync_restau_timeslot_3')) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_timeslot3',
                        'option_value'   =>   $temp_val,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_timeslot3' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {  
                $data['success']  = false;
            }
        break;

        case 'option_timeslot4':
            $temp_val = sanitize_text_field($_POST['timeslot4']).'-'.sanitize_text_field($_POST['timeslot1_4']);
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_timeslot4'");
            if(!empty(sanitize_text_field($_POST['timeslot4'])) && !empty(sanitize_text_field($_POST['timeslot1_4'])) && wp_verify_nonce($_POST['easync_restau_timeslot_4_nonce'], 'easync_restau_timeslot_4')) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_timeslot4',
                        'option_value'   =>   $temp_val,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_timeslot4' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {  
                $data['success']  = false;
            }
        break;

        case 'option_timeslot5':
            $temp_val = sanitize_text_field($_POST['timeslot5']).'-'.sanitize_text_field($_POST['timeslot1_5']);
            $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_timeslot5'");
            if(!empty(sanitize_text_field($_POST['timeslot5'])) && !empty(sanitize_text_field($_POST['timeslot1_5'])) && wp_verify_nonce($_POST['easync_restau_timeslot_5_nonce'], 'easync_restau_timeslot_5')) {
                if(empty($row)) {
                    $entries = array(
                        'option_name'    =>   'sync_timeslot5',
                        'option_value'   =>   $temp_val,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_val, 'sync_timeslot5' ));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            } else {  
                $data['success']  = false;
            }
        break;

        case 'option_restau_email_head_notify':
            if(wp_verify_nonce($_POST['easync_restau_email_head_notify_nonce'], 'easync_restau_email_head_notify')) {
                $temp_name = sanitize_text_field($_POST['email-header-text']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_email_head_notify'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_email_head_notify',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_email_head_notify"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            }
        break;

        case 'option_restau_email_foot_notify':
            if(wp_verify_nonce($_POST['easync_restau_email_foot_notify_nonce'], 'easync_restau_email_foot_notify')) {
                $temp_name = sanitize_text_field($_POST['email-footer-text']);
                $table_check = $wpdb->prefix . "sync_options"; 
                $check = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", 'sync_restau_email_foot_notify'));
                if(count($check) == 0) {
                    $entries = array(
                        'option_name'    =>   'sync_restau_email_foot_notify',
                        'option_value'   =>   $temp_name,
                    );
                } else {
                    $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", $temp_name, "sync_restau_email_foot_notify"));
                    $trigger_on = 'update';
                }
                $data['success']  = true;
            }
        break;
        
        default:
            echo "error";
        break;
    }

    if ($data['success']==true && $trigger_on == 'save') 
        $wpdb->insert($table, $entries);
        $data['entries']  = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE option_name = %s ORDER BY id DESC", $option)); 
        echo json_encode($data);
        die();
}

add_action("wp_ajax_easync_reserved_event", "easync_reserved_event");
function easync_reserved_event() {
    global $wpdb, $sync_default_rate, $sync_emailtemplate_image, $smtpuser;
    $data             = array(); 
    $errors           = array();       
    $entries          = array();
    $data['success']  = false;
    $data['message']  = 'failed!';
    $email_entry = array(); 
    $user_email = '';
    $noti_for   = '';
    $greet_name = '';
    $type = '';
    $sani_type = sanitize_text_field($_POST['type']);
    if(isset($sani_type)) {
        $type = $sani_type;
    }
    switch ($type) {
        case 'hotel':
            $table = $wpdb->prefix . "sync_hotel_entries";
            $table2 = $wpdb->prefix . "sync_payments";
            $table3 = $wpdb->prefix . "sync_options";
            $price_to_pay = $_SESSION['amount_to_pay'];
            if(!empty(sanitize_text_field($_POST['reserve_event_id'])) && !empty(sanitize_text_field($_POST['reserve_event_option']))) {
                $wpdb->query($wpdb->prepare("UPDATE $table SET status = %s WHERE id = %s", sanitize_text_field($_POST['reserve_event_option']), sanitize_text_field($_POST['reserve_event_id'] )));
                $entries =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE id = %s", sanitize_text_field($_POST['reserve_event_id'])));
                
                if(count($entries) > 0) {
                    $amount =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table2 WHERE item_belongsto = %s AND item_cat = %s", sanitize_text_field($_POST['reserve_event_id']), 'hotel'));
                    $price = '';
                    if(count($amount) > 0) {
                        $price = $amount[0]->currency_code.' '.$amount[0]->payment_gross;
                    }

                    $greet_name = ucfirst($entries[0]->firstname);
                    $user_email = $entries[0]->email;
                    $email_entry['Room Type']          = ucfirst(get_post($entries[0]->room_id)->post_title);
                    $email_entry['First Name']         = ucfirst($entries[0]->firstname);
                    $email_entry['Last Name']          = ucfirst($entries[0]->lastname);
                    $email_entry['Phone']              = $entries[0]->phone;
                    $email_entry['Email']              = $entries[0]->email;
                    $email_entry['Check-in']           = $entries[0]->arrival_date;
                    $email_entry['Check-out']          = $entries[0]->departure_date;
                    $email_entry['Night(s)']           = $entries[0]->night_number;
                    $email_entry['Number of Guest(s)'] = $entries[0]->guest_number;
                    $email_entry['Total Room(s)']      = $entries[0]->room_number;
                    $email_entry['Facility Requested'] = $entries[0]->facility_request;
                    $email_entry['Other Request(s)']   = (($entries[0]->number_days!='') ? $entries[0]->number_days : 'N/A');
                    $email_entry['Address 1']          = ucfirst($entries[0]->address_1);
                    $email_entry['Address 2']          = ucfirst($entries[0]->address_2);
                    $email_entry['City']               = ucfirst($entries[0]->city);
                    $email_entry['Province']           = ucfirst($entries[0]->province);
                    $email_entry['Postal Code']        = $entries[0]->postal_code;
                    $email_entry['Status']             = 'Approved';
                    $email_entry['Amount Paid']        = $price;
                    $noti_for                          = 'Room Booking Notification';
                }

                $data['success']          = true;
                $data['message']          = 'success!';
                $data['typee']            = sanitize_text_field($_POST['type']);
                $data['header_msg']       = 'Your reservation request has been confirmed, please see and review your booking information below.';
                $data['footer_msg']       = 'Remember cleanliness is part of our daily routine, thank you for choosing us as your second home.';

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_hotel_email_head_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['header_msg'] = $entries[0]->option_value;
                }

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_hotel_email_foot_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['footer_msg'] = $entries[0]->option_value;
                }
            }   
        break;

        case 'car':
            $table = $wpdb->prefix . "sync_rent_car_entries";
            $table2 = $wpdb->prefix . "sync_payments";
            $table3 = $wpdb->prefix . "sync_options";
            if(!empty(sanitize_text_field($_POST['reserve_event_id'])) && !empty(sanitize_text_field($_POST['reserve_event_option']))) {
                $wpdb->query($wpdb->prepare("UPDATE $table SET status = %s WHERE id = %s", sanitize_text_field($_POST['reserve_event_option']), sanitize_text_field($_POST['reserve_event_id'] )));
                $entries =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE id = %s", sanitize_text_field($_POST['reserve_event_id'])));
                if(count($entries) > 0) {
                    $meta = get_post_meta( $entries[0]->car_id, 'easync_car', true );
                    $amount =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table2 WHERE item_belongsto = %s AND item_cat = %s", sanitize_text_field($_POST['reserve_event_id']), 'car'));
                    $price = '';
                    
                    if(count($amount) > 0) {
                        $price = $amount[0]->currency_code.' '.$amount[0]->payment_gross;
                    }
                    $date_start = new DateTime($entries[0]->pick_date);
                    $date_end   = new DateTime($entries[0]->return_date);
                    $number_days = $date_end->diff($date_start)->format("%a");

                    $greet_name = ucfirst($entries[0]->firstname);
                    $user_email = $entries[0]->email;
                    $email_entry['Car']            = get_post($entries[0]->car_id)->post_title;
                    $email_entry['Car Type']       = $meta['type'];
                    $email_entry['Car Model']      = $meta['model'];
                    $email_entry['First Name']     = ucfirst($entries[0]->firstname);
                    $email_entry['Last Name']      = ucfirst($entries[0]->lastname);
                    $email_entry['Phone']          = $entries[0]->phone;
                    $email_entry['Email']          = $entries[0]->email;
                    $email_entry['Driver']         = ucfirst($entries[0]->with_driver);
                    $email_entry['Pick Date']      = $entries[0]->pick_date;
                    $email_entry['Pick Time']      = $entries[0]->pick_time;
                    $email_entry['Return Date']    = $entries[0]->return_date;
                    $email_entry['Return Time']    = $entries[0]->return_time;
                    $email_entry['Pick Location']  = ucfirst($entries[0]->pick_location);
                    $email_entry['Number of Days'] = $number_days;
                    $email_entry['Address 1']      = ucfirst($entries[0]->address_1);
                    $email_entry['Address 2']      = ucfirst($entries[0]->address_2);
                    $email_entry['City']           = ucfirst($entries[0]->city);
                    $email_entry['Province']       = ucfirst($entries[0]->province);
                    $email_entry['Postal Code']    = $entries[0]->postal_code;
                    $email_entry['Status']         = 'Approved';
                    $email_entry['Amount Paid']    = $price;
                    $noti_for   = 'Car Booking Notification';
                }

                $data['success']          = true;
                $data['message']          = 'success!';
                $data['typee']            = sanitize_text_field($_POST['type']);
                $data['header_msg']       = 'Your booking request has been confirmed, please see and review your booking information below.';
                $data['footer_msg']       = 'Remember always check your safety, pray before your travel and God bless your trip, thank you for choosing us as your rental provider.';

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_car_email_head_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['header_msg'] = $entries[0]->option_value;
                }

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_car_email_foot_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['footer_msg'] = $entries[0]->option_value;
                }
            }   
        break;

        case 'restau':
            $table = $wpdb->prefix . "sync_restau_entries";
            $table2 = $wpdb->prefix . "sync_payments";
            $table3 = $wpdb->prefix . "sync_options";
            if(!empty(sanitize_text_field($_POST['reserve_event_id'])) && !empty(sanitize_text_field($_POST['reserve_event_option']))) {
                $wpdb->query($wpdb->prepare("UPDATE $table SET status = %s WHERE id = %s", sanitize_text_field($_POST['reserve_event_option']), sanitize_text_field($_POST['reserve_event_id'] )));
                $entries =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE id = %s", sanitize_text_field($_POST['reserve_event_id'])));
                
                if(count($entries) > 0) {
                    $amount =  $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table2 WHERE item_belongsto = %s AND item_cat = %s", sanitize_text_field($_POST['reserve_event_id']), 'restau'));
                    $price = '';
                    if(count($amount) > 0) {
                         $price = $amount[0]->currency_code.' '.$amount[0]->payment_gross;
                    }

                    $greet_name = ucfirst($entries[0]->name);
                    $user_email = $entries[0]->email;
                    $menu_list = explode(',', $entries[0]->menu_ids);
                    foreach ($menu_list as $key => $value) {
                        preg_match('#\((.*?)\)#', $value, $match);
                        $meta = get_post_meta( (int)$value, 'sync_restau', true );
                        $sub = $amount[0]->currency_code.' '.((int)trim($match[1],' QTY ') * floatval($meta['price']));
                    }
                    $email_entry['Time Slot']        = $entries[0]->timeslot;
                    $email_entry['Total Guest(s)']   = $entries[0]->guest_no;
                    $email_entry['Total Table(s)']   = $entries[0]->table_no;
                    $email_entry['Branch']           = ucfirst($entries[0]->branch);
                    $email_entry['Name']             = ucfirst($entries[0]->name);
                    $email_entry['Picked Date']      = $entries[0]->pick_date;
                    $email_entry['Phone']            = $entries[0]->phone;
                    $email_entry['Email']            = $entries[0]->email;
                    $email_entry['Address 1']        = ucfirst($entries[0]->address_1);
                    $email_entry['Address 2']        = ucfirst($entries[0]->address_2);
                    $email_entry['City']             = ucfirst($entries[0]->city);
                    $email_entry['Province']         = ucfirst($entries[0]->province);
                    $email_entry['Postal Code']      = $entries[0]->postal_code;
                    $email_entry['Status']           = 'Approved';
                    $email_entry['Amount Paid']      = $price;
                    $noti_for                        = 'Restaurant Reservation Notification';
                }

                $data['success']          = true;
                $data['message']          = 'success!';
                $data['typee']            = sanitize_text_field($_POST['type']);
                $data['header_msg']       = 'Your reservation request has been confirmed, please see and review your booking information below.';
                $data['footer_msg']       = 'Remember don\'t waste every single food you eat, it\'s a blessing from God, thank you.';

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_restau_email_head_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['header_msg'] = $entries[0]->option_value;
                }

                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table3 WHERE option_name = %s ORDER BY id DESC",'sync_restau_email_foot_notify' ) );
                if ( $entries && $entries[0]->option_value!='') {
                    $data['footer_msg'] = $entries[0]->option_value;
                }
            }   
        break;

        case 'currency_symbol':
            if(!empty(sanitize_text_field($_POST['sync_currency_to'])) && !empty(sanitize_text_field($_POST['sync_currency_from'])) && !empty(sanitize_text_field($_POST['sync_prices']))) {
                $sync_default_rate = sanitize_text_field($_POST['sync_currency_to']);
                $data['newsymbol'] = sanitize_text_field($_POST['sync_currency_to']);
                $temp_price = array();
                foreach (sanitize_text_field($_POST['sync_prices']) as $key => $value) {
                    $temp_price[$key] = easyncExchangeRate($value, sanitize_text_field($_POST['sync_currency_from']), sanitize_text_field($_POST['sync_currency_to'])) ;
                }
                $data['test'] = $sync_default_rate;
                $data['newprice']  = $temp_price;
                $data['success']   = true;
                $data['message']   = 'success!';    
            }
        break;
        
        default:
            echo "error";
        break;
    }
    $send = 'no';

    if($data['typee']=='car' || $data['typee']=='hotel' || $data['typee']=='restau') {
        if($data['success']==true && !empty(sanitize_text_field($_POST['reserve_event_option'])) && strtolower($_POST['reserve_event_option']) == 'active') {
            $send = 'yes';
        }
    }
    
    if($send=='yes') {
        require_once("user-email-template.php");

        $to        = $user_email; // this is your Email address
        $from      = get_option('admin_email'); // this is the sender's Email address
        $headers   = "MIME-Version: 1.0" . "\r\n";
        $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
        $subject   = 'eaSYNC-Booking Reservation';
        $message   = $htmlContent;
        $headers2  = "MIME-Version: 1.0" . "\r\n";
        $headers2  .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers2  .= 'From: '.$noti_for.'<'.$from .'>' . "\r\n";
        $subject2  = get_bloginfo( 'name' ).' reservation (admin copy)';
        $message2  = $htmlContent;
        $name = get_bloginfo( 'name' );

        mail($to,$subject,$message,$headers);
        mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    }
    echo json_encode($data);
    die();
}

add_action("wp_ajax_nopriv_easync_success_and_save", "easync_success_and_save");
add_action("wp_ajax_easync_success_and_save", "easync_success_and_save");
function easync_success_and_save() {
    global $wpdb;
    session_start();
    $table          = $wpdb->prefix . "sync_options";
    $cat            = '';
    $id             = '';
    $txn_id         = '';
    $payment_gross  = '';
    $currency_code  = $_SESSION['currency'];
    $payment_status = 'paid';
    $redirection    = '';
    $data           = array();
    $email_entry    = array(); 
    $user_email     = '';
    $greet_name     = '';
    $noti_for       = '';
    $send_email     = false;
    $total_amount   = '';
    $verify_token   = $_POST['g-recaptcha-response'];
    $reserved_menus = array();
    $table_ids      = array();
    $menu_list      = array();

    $row = $wpdb->get_results(  "SELECT * FROM $table WHERE option_name = 'sync_auto_gen_id'");
    if(empty($row)) {
        $entries = array(
                'option_name'    =>   'sync_auto_gen_id',
                'option_value'   =>   '1',
            );
        $wpdb->insert($table, $entries);
    } else {
        $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table  WHERE option_name = %s ", 'sync_auto_gen_id'));
        if ( $entries ) {
            $wpdb->query($wpdb->prepare("UPDATE $table SET option_value = %s WHERE option_name = %s", ($entries[0]->option_value+1), 'sync_auto_gen_id' ));
        }
    }
    $_SESSION['form_type'] = $_SESSION['sync_form'];

    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE option_name = %s ", 'sync_auto_gen_id'));
    if ( $entries ) 
        $txn_id = $entries[0]->option_value;

    $_SESSION['message'] = 'Reservation successful!';
    //header("Location: $location");
    if (!empty($_SESSION['sync_form']) && $_SESSION['sync_form'] =='restau') {
        unset($_SESSION['sync_form']);
        $table         = $wpdb->prefix . "sync_restau_entries";
        $cat           = 'restau';
        $item_number   = $_SESSION['item_qty']; 
        $payment_gross = $_SESSION['amount_to_pay_restau'];
        $redirection   = 'sync_restau_page_thank_u';
        $price         = $_SESSION['amount_to_pay_restau']; 
        $send_email    = true;
        $greet_name    = ucfirst($_SESSION['sync_entries']['name']);
        $user_email    = $_SESSION['sync_entries']['email'];
        $list_me       = $_SESSION['menu_ids'];

        for ($i = 0; $i < count($list_me); $i++ ) {
            for ($j = 0; $j < count($list_me[$i]); $j++ ) {
                $menu_list[]  = $list_me[$i][$j];
            }
            
        }                                   

        foreach ($menu_list as $key => $value) {
            preg_match('#\((.*?)\)#', $value, $match);
            $meta = get_post_meta( (int)$value, 'sync_restau', true );
            $menus .= get_post($value)->post_title . ' (' .$match[1].'), ';
        }
        $data['list'] = rtrim($menus, ', ');

        $email_entry['Reference Number'] = $_SESSION['sync_entries']['reference_number'];
        $email_entry['Time Slot']        = $_SESSION['sync_entries']['timeslot'];
        $email_entry['Total Guest(s)']   = $_SESSION['sync_entries']['guest_no'];
        $email_entry['Total Table(s)']   = $_SESSION['sync_entries']['table_no'];
        $email_entry['Branch']           = ucfirst($_SESSION['sync_entries']['branch']);
        $email_entry['Name']             = ucfirst($_SESSION['sync_entries']['name']);
        $email_entry['Picked Date']      = $_SESSION['sync_entries']['pick_date'];
        $email_entry['Phone']            = $_SESSION['sync_entries']['phone'];
        $email_entry['Email']            = $_SESSION['sync_entries']['email'];
        $email_entry['Address 1']        = ucfirst($_SESSION['sync_entries']['address_1']);
        $email_entry['Address 2']        = ucfirst($_SESSION['sync_entries']['address_2']);
        $email_entry['City']             = ucfirst($_SESSION['sync_entries']['city']);
        $email_entry['Province']         = ucfirst($_SESSION['sync_entries']['province']);
        $email_entry['Postal Code']      = $_SESSION['sync_entries']['postal_code'];
        $email_entry['Status']           = 'Processing';
        $email_entry['Amount Paid']      = $currency_code. ' ' .$price;
        $noti_for                        = 'Restaurant Reservation Notification';
    
        $data['success'] = true;
        $data['message'] = 'success!';
    }

    if (!empty($_SESSION['sync_form']) && $_SESSION['sync_form'] =='car'){
        unset($_SESSION['sync_form']);
        $table         = $wpdb->prefix . "sync_rent_car_entries";
        $cat           = 'car';
        $total_amount  = $_SESSION['amount_to_pay_car'];
        $payment_gross = ($total_amount * $_SESSION['sync_entries']['number_days']);
        $item_number   = $_SESSION['sync_entries']['number_days'];   
        $redirection   = 'sync_car_page_thank_u';
        $meta          = get_post_meta( $_SESSION['sync_entries']['car_id'], 'easync_car', true ); 
        $price         = $total_amount;
        $send_email    = true;
        $date_start    = new DateTime($_SESSION['sync_entries']['pick_date']);
        $date_end      = new DateTime($_SESSION['sync_entries']['return_date']);
        $number_days   = $date_end->diff($date_start)->format("%a");
        $greet_name    = ucfirst($_SESSION['sync_entries']['firstname']);
        $user_email    = $_SESSION['sync_entries']['email'];

        $email_entry['Car']                = get_post($_SESSION['sync_entries']['car_id'])->post_title;
        $email_entry['Car Type']           = $meta['type'];
        $email_entry['Car Model']          = $meta['model'];
        $email_entry['Reference Number']   = ucfirst($_SESSION['sync_entries']['reference_number']);
        $email_entry['First Name']         = ucfirst($_SESSION['sync_entries']['firstname']);
        $email_entry['Last Name']          = ucfirst($_SESSION['sync_entries']['lastname']);
        $email_entry['Phone']              = $_SESSION['sync_entries']['phone'];
        $email_entry['Email']              = $_SESSION['sync_entries']['email'];
        $email_entry['Pick Date']          = $_SESSION['sync_entries']['pick_date'];
        $email_entry['Pick Time']          = $_SESSION['sync_entries']['pick_time'];
        $email_entry['Return Date']        = $_SESSION['sync_entries']['return_date'];
        $email_entry['Return Time']        = $_SESSION['sync_entries']['return_time'];
        $email_entry['Pick Location']      = ucfirst($_SESSION['sync_entries']['pick_location']);
        $email_entry['Number of Days']     = $number_days;
        $email_entry['Facility Requested'] = $_SESSION['sync_entries']['facility_request'];
        $email_entry['Other Request(s)']   = (($_SESSION['sync_entries']['other_req']!='') ? $_SESSION['sync_entries']['other_req'] : 'N/A');
        $email_entry['Address 1']          = ucfirst($_SESSION['sync_entries']['address_1']);
        $email_entry['Address 2']          = ucfirst($_SESSION['sync_entries']['address_2']);
        $email_entry['City']               = ucfirst($_SESSION['sync_entries']['city']);
        $email_entry['Province']           = ucfirst($_SESSION['sync_entries']['province']);
        $email_entry['Postal Code']        = $_SESSION['sync_entries']['postal_code'];
        $email_entry['Status']             = 'Processing';
        $email_entry['Amount Paid']        = $currency_code. ' '.$price * $number_days;
        $noti_for                          = 'Car Booking Notification';

        $data['success'] = true;
        $data['message'] = 'success!';
    }

    if (!empty($_SESSION['sync_form']) && $_SESSION['sync_form'] =='hotel'){
        unset($_SESSION['sync_form']);
        $table         = $wpdb->prefix . "sync_hotel_entries";
        $cat           = 'hotel';
        $total_amount  = $_SESSION['amount_to_pay'];
        $payment_gross = ($total_amount * $_SESSION['sync_entries']['night_number']);
        $item_number   = $_SESSION['sync_entries']['night_number'];  
        $redirection   = 'sync_hotel_page_thank_u';
        $meta          = get_post_meta( $_SESSION['sync_entries']['room_id'], 'easync_hotel', true ); 
        $price         = $total_amount;
        $send_email    = true;
        $greet_name    = ucfirst($_SESSION['sync_entries']['firstname']);
        $user_email    = $_SESSION['sync_entries']['email'];

        $email_entry['Room Type']          = ucfirst(get_post($_SESSION['sync_entries']['room_id'])->post_title);
        $email_entry['Reference Number']   = ucfirst($_SESSION['sync_entries']['reference_number']);
        $email_entry['First Name']         = ucfirst($_SESSION['sync_entries']['firstname']);
        $email_entry['Last Name']          = ucfirst($_SESSION['sync_entries']['lastname']);
        $email_entry['Phone']              = $_SESSION['sync_entries']['phone'];
        $email_entry['Email']              = $_SESSION['sync_entries']['email'];
        $email_entry['Check-in']           = $_SESSION['sync_entries']['arrival_date'];
        $email_entry['Check-out']          = $_SESSION['sync_entries']['departure_date'];
        $email_entry['Night(s)']           = $_SESSION['sync_entries']['night_number'];
        $email_entry['Number of Guest(s)'] = $_SESSION['sync_entries']['guest_number'];
        $email_entry['Total Room(s)']      = $_SESSION['sync_entries']['room_number'];
        $email_entry['Facility Requested'] = $_SESSION['sync_entries']['facility_request'];
        $email_entry['Other Request(s)']   = (($_SESSION['sync_entries']['other_req']!='') ? $_SESSION['sync_entries']['other_req'] : 'N/A');
        $email_entry['Address 1']          = ucfirst($_SESSION['sync_entries']['address_1']);
        $email_entry['Address 2']          = ucfirst($_SESSION['sync_entries']['address_2']);
        $email_entry['City']               = ucfirst($_SESSION['sync_entries']['city']);
        $email_entry['Province']           = ucfirst($_SESSION['sync_entries']['province']);
        $email_entry['Postal Code']        = $_SESSION['sync_entries']['postal_code'];
        $email_entry['Status']             = 'Processing';
        $email_entry['Amount Paid']        = $currency_code. ' ' .$price * $_SESSION['sync_entries']['night_number'];
        $noti_for                          = 'Room Booking Notification';

        $data['success'] = true;
        $data['message'] = 'success!';
    }

    if($send_email==true) {
        $data['header_msg']       = 'Thank you for choosing '.get_bloginfo( 'name' ).'. Your transaction is now being processed and will be confirmed as soon as possible.<br /><br />Here are the details you submitted for your booking:';
        $data['footer_msg']       = 'For any concerns regarding your booking, please email us at '.get_option('admin_email');
        require_once("user-email-template.php");

        $to        = $user_email; // this is your Email address
        $from      = get_option('admin_email'); // this is the sender's Email address
        $headers   = "MIME-Version: 1.0" . "\r\n";
        $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
        $subject   = 'eaSYNC-Booking Reservation';
        $message   = $htmlContent;
    
        $headers2  = "MIME-Version: 1.0" . "\r\n";
        $headers2  .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers2  .= 'From: '.$noti_for.'<'.$from .'>' . "\r\n";
        $subject2  = get_bloginfo( 'name' ).' reservation (admin copy)';
        $message2  = $htmlContent;
        $name = get_bloginfo( 'name' );

        mail($to,$subject,$message,$headers);
        mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender

        $data['to'] = $to;
        $data['subject'] = $subject;
        $data['message'] = $message;
        $data['header'] = $headers;
    }

    $data['curr'] = $_SESSION;
    if(!empty($txn_id)){
        $syncpay_table = $wpdb->prefix . "sync_payments";
        $bridge = $wpdb->prefix . 'sync_rate_bridge';
        $rate = $wpdb->prefix . 'sync_room_rates';
        $room_id = $_SESSION['sync_entries']['room_id'];
        $prevPaymentResult = $wpdb->query("SELECT id FROM $syncpay_table WHERE txn_id = '".$txn_id."'");

        if ($prevPaymentResult->num_rows > 0) {
            $paymentRow = $prevPaymentResult->fetch_assoc();
            $last_insert_id = $paymentRow['payment_id'];
        } else {

            if( ( $_SESSION['form_type'] === 'hotel' && !empty($_SESSION['sync_entries']['arrival_date']) && !empty($_SESSION['sync_entries']['departure_date']) ) ||
                ( $_SESSION['form_type'] === 'car' && !empty($_SESSION['sync_entries']['pick_date']) && !empty($_SESSION['sync_entries']['return_date']) ) ||
                ( $_SESSION['form_type'] === 'restau' && !empty($_SESSION['sync_entries']['pick_date']) ) 
            ) {
                $wpdb->insert($table, $_SESSION['sync_entries']);
                $entry_id = $wpdb->insert_id;
                unset($_SESSION['sync_entries']);

                if ( ($_SESSION['form_type'] === 'restau') ) {
                    $table_entry    = $wpdb->prefix . 'sync_restau_tables';
                    $reserved_menus = $_SESSION['menu_ids'];
                    $temp_id_array      = explode(',', $_SESSION['table_ids']);
                    foreach ($temp_id_array as $each ) {
                        $table_ids[] = $each;
                    }

                    for ($i = 0; $i < count($reserved_menus); $i++) {
                        unset($save_menus);
                        for ($j = 0; $j < count($reserved_menus[$i]); $j++) {
                            $save_menus .= $reserved_menus[$i][$j]. ", ";
                        }
                        $save_menus = rtrim($save_menus, ', ');
                        $qry_table = $wpdb->get_results("INSERT INTO $table_entry(entry_id, table_id, menu_ids) VALUES('".$entry_id."', '".$table_ids[$i]."', '".$save_menus."'); ");
                    }
                }
            } else {
                $data["error"] = "Some fields are empty. Cannot save data.";
            }
            $entries = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
            if ( ! $entries ) { 
                $wpdb->print_error(); 
            } else {
                $id = $entries[0]->id;
            }
            $insert         = $wpdb->query("INSERT INTO $syncpay_table(item_belongsto,item_cat, item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('".$id."','".$cat."','".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."')");
            $last_insert_id = $wpdb->insert_id;
            $qry            = $wpdb->get_results("SELECT id from $rate where room_id = '".$room_id."';");
            $rate_id        = $qry[0]->id;
            if ( $_SESSION['form_type'] === 'hotel' && !empty($rate_id) ) {
                $save = $wpdb->query("INSERT INTO $bridge(rate_id, entry_id) VALUES ('".$rate_id."', '".$entry_id."')");
            }

            $table_check    = $wpdb->prefix . "sync_options";  
            $check          = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_check WHERE option_name = %s", $redirection));

            if(count($check) == 0 || $check[0]->option_value=='default') {
                $data['redirect'] = home_url( '/'.$_SESSION['sync_page_redirect'] ); 
            }else{
                $data['redirect'] = $check[0]->option_value; 
            }
            unset($_SESSION['sync_page_redirect']);
        }
    }

    
    echo json_encode($data);
    die();
}

if ( ! function_exists( 'eb_fs' ) ) {
    // Create a helper function for easy SDK access.
    function eb_fs() {
        global $eb_fs;
        if ( ! isset( $eb_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';
            $eb_fs = fs_dynamic_init( array(
                'id'                  => '8958',
                'slug'                => 'easync-booking',
                'type'                => 'plugin',
                'public_key'          => 'pk_559902b5858a3e4e9894b843a92d7',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'easync-booking',
                    'first-path'     => 'admin.php?page=easync-booking',
                ),
            ) );
        }
        return $eb_fs;
    }
    // Init Freemius.
    eb_fs();
    // Signal that SDK was initiated.
    do_action( 'eb_fs_loaded' );
}

add_action("wp_ajax_get_booking_details", "get_booking_details");
add_action("wp_ajax_nopriv_get_booking_details", "get_booking_details");
function get_booking_details() {
    global $wpdb;
    $reference      = $_REQUEST['ref'];
    $data           = array();
    $table          = $wpdb->prefix . "sync_hotel_entries";
    $table_payments = $wpdb->prefix . "sync_payments";
    $grace_table    = $wpdb->prefix . "sync_options";
    $grace_period   = $wpdb->get_results("SELECT option_value from $grace_table where option_name = 'sync_hotel_grace_period';");
    $qry            = $wpdb->get_results("select * from $table where status = 'pending' and reference_number = '".$reference."';");

    if (!empty($qry)) {
        $pay_status = $wpdb->get_results("SELECT payment_status, payment_gross from $table_payments where item_belongsto = '".$qry[0]->id."';");
        foreach ($qry as $values) {
            $data[] = $values;
        }
        array_push($data, $grace_period[0]->option_value, $pay_status[0]->payment_status, number_format($pay_status[0]->payment_gross, 2), easyncCurrency());
    }
    else { 
        $data = 'No Record';
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_cancel_booking", "cancel_booking");
add_action("wp_ajax_nopriv_cancel_booking", "cancel_booking");
function cancel_booking() {
    global $wpdb;
    $array        = array();
    $data         = array();
    $id           = $_REQUEST['id'];
    $entries      = $wpdb->prefix . 'sync_hotel_entries';
    $payments     = $wpdb->prefix . 'sync_payments';
    $table        = $wpdb->prefix . 'sync_options';
    $grace_period = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_hotel_grace_period';");
    $refund_rate  = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_hotel_refund_rate';");
    $amount_paid  = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'hotel' and item_belongsto = '".$id."';");
    $arrival_date = $wpdb->get_results("SELECT id, arrival_date from $entries where id = '".$id."';");
    $now          = date_create(date("m/d/Y"));
    $arrival      = date_create($arrival_date[0]->arrival_date); 
    $curr_id      = $arrival_date[0]->id;
    $check_period = date_diff($arrival, $now);
    $format       = $check_period->format("%a");

    if ( $format >= $grace_period[0]->option_value ) {
        $rate = $refund_rate[0]->option_value;
        $amount = $amount_paid[0]->payment_gross;
        $refund =  ( $rate / 100 ) * $amount;
        $cancel_cost = $amount - $refund;
        array_push($array, number_format($amount, 2), number_format(round($cancel_cost, 2), 2), number_format($refund, 2), easyncCurrency(), $curr_id);
    }
    foreach ($array as $value) {
        $data[] = $value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_cancel_reservation", "cancel_reservation");
add_action("wp_ajax_nopriv_cancel_reservation", "cancel_reservation");
function cancel_reservation() {
    global $wpdb;
    $array        = array();
    $data         = array();
    $id           = $_REQUEST['id'];
    $entries      = $wpdb->prefix . 'sync_restau_entries';
    $payments     = $wpdb->prefix . 'sync_payments';
    $table        = $wpdb->prefix . 'sync_options';
    $grace_period = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_restau_grace_period';");
    $refund_rate  = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_restau_refund_rate';");
    $amount_paid  = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'restau' and item_belongsto = '".$id."';");
    $pick_date    = $wpdb->get_results("SELECT id, pick_date from $entries where id = '".$id."';");
    $now          = date_create(date("m/d/Y"));
    $arrival      = date_create($pick_date[0]->pick_date); 
    $curr_id      = $pick_date[0]->id;
    $check_period = date_diff($arrival, $now);
    $format       = $check_period->format("%a");

    if ( $format >= $grace_period[0]->option_value ) {
        $rate = $refund_rate[0]->option_value;
        $amount = $amount_paid[0]->payment_gross;
        $refund =  ( $rate / 100 ) * $amount;
        $cancel_cost = $amount - $refund;
        array_push($array, number_format($amount, 2), number_format(round($cancel_cost, 2), 2), number_format($refund, 2), easyncCurrency(), $curr_id);
    }
    foreach ($array as $value) {
        $data[] = $value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_save_request_cancel_content", "save_request_cancel_content");
add_action("wp_ajax_nopriv_save_request_cancel_content", "save_request_cancel_content");
function save_request_cancel_content() {
    global $wpdb;
    $type         = $_REQUEST['type'];
    $options      = $wpdb->prefix . 'sync_options';
    $head_content = $_REQUEST['head_text'];
    $body_content = $_REQUEST['body_text'];
    $foot_content = $_REQUEST['footer_text'];
    $check1       = $_REQUEST['check1'];
    $check3       = $_REQUEST['check3'];
    $check7       = $_REQUEST['check7'];
    $check_val    = $check1. "-" .$check3. "-" .$check7;
    $qry_check    = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_selected_reminders';");
    
    if(count($qry_check) == 0) {
        $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_selected_reminders','".$check_val."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $check_val, "sync_selected_reminders"));
    }

    if ($type == "1" ) {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_hotel_email_head_cancel','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_hotel_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_body_cancel';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_hotel_email_body_cancel','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "sync_hotel_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_hotel_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "sync_hotel_email_footer_cancel"));
        }
    } else if ($type == "2") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_hotel_email_head_cancel','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "admin_hotel_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_body_cancel';");
        if(count($qry_body) == 0) {

            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_hotel_email_body_cancel','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "admin_hotel_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_hotel_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "admin_hotel_email_footer_cancel"));
        }
    } else if ($type == "3") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_declined_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_declined_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_declined_email_footer"));
        }
    } else if ($type == "4") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_approved_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_approved_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_approved_email_footer"));
        }
    }  else if ($type == "5") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_head';");
        if(count($qry_head) == 0) {

            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder7_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "book_reminder7_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder7_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "book_reminder7_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder7_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "book_reminder7_email_footer"));
        }
    } else if ($type == "6") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder3_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "book_reminder3_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder3_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "book_reminder3_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder3_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "book_reminder3_email_footer"));
        }
    } else if ($type == "7") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s  WHERE option_name = %s", $head_content, "book_reminder1_email_head"));
        }

        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "book_reminder1_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "book_reminder1_email_footer"));
        }
    } else if ($type == "8") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_head_notify';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_hotel_email_head_notify','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_hotel_email_head_notify"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_foot_notify';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_hotel_email_foot_notify','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "sync_hotel_email_foot_notify"));
        }
    }
    echo json_encode($data);
    wp_die();

}

add_action("wp_ajax_save_request_cancel_content_car", "save_request_cancel_content_car");
add_action("wp_ajax_nopriv_save_request_cancel_content_car", "save_request_cancel_content_car");
function save_request_cancel_content_car() {
    global $wpdb;
    $type         = $_REQUEST['type'];
    $options      = $wpdb->prefix . 'sync_options';
    $head_content = $_REQUEST['head_text'];
    $body_content = $_REQUEST['body_text'];
    $foot_content = $_REQUEST['footer_text'];
    $check1       = $_REQUEST['check1'];
    $check3       = $_REQUEST['check3'];
    $check7       = $_REQUEST['check7'];
    $check_val    = $check1. "-" .$check3. "-" .$check7;

    $qry_check = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_selected_reminders';");
    if (count($qry_check) == 0) {
        $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_selected_reminders','".$check_val."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $check_val, "sync_car_selected_reminders"));
    }

    if ($type == "1" ) {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_email_head_cancel','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_car_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_body_cancel';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_email_body_cancel','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "sync_car_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "sync_car_email_footer_cancel"));
        }
    } else if ($type == "2") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_car_email_head_cancel','".$head_content."')");
        }  else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "admin_car_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_body_cancel';");
        if(count($qry_body) == 0) {

            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_car_email_body_cancel','".$body_content."')");
        }
        else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "admin_car_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_car_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "admin_car_email_footer_cancel"));
        }
    } else if ($type == "3") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_car_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_declined_car_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_car_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_declined_car_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_car_email_footer','".$foot_content."')");
        }
        else{
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_declined_car_email_footer"));
        }
    } else if ($type == "4") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_car_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_approved_car_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_car_email_body','".$body_content."')");
        } else{
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_approved_car_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_car_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_approved_car_email_footer"));
        }
    } else if ($type == "5") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('rent_reminder7_car_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "rent_reminder7_car_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('rent_reminder7_car_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "rent_reminder7_car_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('rent_reminder7_car_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "rent_reminder7_car_email_footer"));
        }
    } else if ($type == "6") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder3_car_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('rent_reminder3_car_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "rent_reminder3_car_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder3_car_email_body;");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('rent_reminder3_car_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "rent_reminder3_car_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder3_car_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder3_car_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "rent_reminder3_car_email_footer"));
        }
    } else if ($type == "7") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_car_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_car_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "book_reminder1_car_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_car_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_car_email_body','".$body_content."')");
        }
        else{
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "book_reminder1_car_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_car_email_footer';");
        if(count($qry_foot) == 0) {

            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('book_reminder1_car_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "book_reminder1_car_email_footer"));
        }
    } else if ($type == "8") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_head_notify';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_email_head_notify','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_car_email_head_notify"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_foot_notify';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_car_email_foot_notify','".$foot_content."')");
        }
        else{
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "sync_car_email_foot_notify"));
        }
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_save_request_cancel_content_restau", "save_request_cancel_content_restau");
add_action("wp_ajax_nopriv_save_request_cancel_content_restau", "save_request_cancel_content_restau");
function save_request_cancel_content_restau() {
    global $wpdb;
    $type         = $_REQUEST['type'];
    $options      = $wpdb->prefix . 'sync_options';
    $head_content = $_REQUEST['head_text'];
    $body_content = $_REQUEST['body_text'];
    $foot_content = $_REQUEST['footer_text'];
    $check1       = $_REQUEST['check1'];
    $check3       = $_REQUEST['check3'];
    $check7       = $_REQUEST['check7'];
    $check_val    = $check1. "-" .$check3. "-" .$check7;

    $qry_check = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_selected_reminders';");
    if(count($qry_check) == 0) {
        $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_selected_reminders','".$check_val."')");
    } else {
        $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $check_val, "sync_restau_selected_reminders"));
    }

    if ($type == "1" ) {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_email_head_cancel','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_restau_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_body_cancel';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_email_body_cancel','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "sync_restau_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s  WHERE option_name = %s", $foot_content, "sync_restau_email_footer_cancel"));
        }
    } else if ($type == "2") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_head_cancel';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_restau_email_head_cancel','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "admin_restau_email_head_cancel"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_body_cancel';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_restau_email_body_cancel','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "admin_restau_email_body_cancel"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_footer_cancel';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('admin_restau_email_footer_cancel','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s  WHERE option_name = %s", $foot_content, "admin_restau_email_footer_cancel"));
        }
    } else if ($type == "3") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_restau_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_declined_restau_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_restau_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_declined_restau_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_declined_restau_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_declined_restau_email_footer"));
        }
    } else if ($type == "4") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_restau_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "request_approved_restau_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_restau_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "request_approved_restau_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('request_approved_restau_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "request_approved_restau_email_footer"));
        }
    } else if ($type == "5") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder7_restau_email_head','".$head_content."')");
        }  else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "reserve_reminder7_restau_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder7_restau_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "reserve_reminder7_restau_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder7_restau_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "reserve_reminder7_restau_email_footer"));
        }
    } else if ($type == "6") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder3_restau_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "reserve_reminder3_restau_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_body;");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder3_restau_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "reserve_reminder3_restau_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder3_restau_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "reserve_reminder3_restau_email_footer"));
        }
    } else if ($type == "7") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_head';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder1_restau_email_head','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "reserve_reminder1_restau_email_head"));
        }
    
        $qry_body = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_body';");
        if(count($qry_body) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder1_restau_email_body','".$body_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $body_content, "reserve_reminder1_restau_email_body"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_footer';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('reserve_reminder1_restau_email_footer','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "reserve_reminder1_restau_email_footer"));
        }
    } else if ($type == "8") {
        $qry_head = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_head_notify';");
        if(count($qry_head) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_email_head_notify','".$head_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $head_content, "sync_restau_email_head_notify"));
        }
    
        $qry_foot = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_foot_notify';");
        if(count($qry_foot) == 0) {
            $insert = $wpdb->query("INSERT INTO $options(option_name, option_value) VALUES('sync_restau_email_foot_notify','".$foot_content."')");
        } else {
            $wpdb->query($wpdb->prepare("UPDATE $options SET option_value = %s WHERE option_name = %s", $foot_content, "sync_restau_email_foot_notify"));
        }
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_request_cancel", "request_cancel");
add_action("wp_ajax_nopriv_request_cancel", "request_cancel");
function request_cancel() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_request_cancel_admin", "request_cancel_admin");
add_action("wp_ajax_nopriv_request_cancel_admin", "request_cancel_admin");
function request_cancel_admin() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_hotel_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_request_cancel_declined", "request_cancel_declined");
add_action("wp_ajax_nopriv_request_cancel_declined", "request_cancel_declined");
function request_cancel_declined() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_request_cancel_approved", "request_cancel_approved");
add_action("wp_ajax_nopriv_request_cancel_approved", "request_cancel_approved");
function request_cancel_approved() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_email_reminder7", "email_reminder7");
add_action("wp_ajax_nopriv_email_reminder7", "email_reminder7");
function email_reminder7() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder7_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_email_reminder3", "email_reminder3");
add_action("wp_ajax_nopriv_email_reminder3", "email_reminder3");
function email_reminder3() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_email_reminder1", "email_reminder1");
add_action("wp_ajax_nopriv_email_reminder1", "email_reminder1");
function email_reminder1() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_option_hotel_email_notify", "option_hotel_email_notify");
add_action("wp_ajax_nopriv_option_hotel_email_notify", "option_hotel_email_notify");
function option_hotel_email_notify() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_head_notify';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_hotel_email_foot_notify';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_request_cancel", "car_request_cancel");
add_action("wp_ajax_nopriv_car_request_cancel", "car_request_cancel");
function car_request_cancel() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_request_cancel_admin", "car_request_cancel_admin");
add_action("wp_ajax_nopriv_car_request_cancel_admin", "car_request_cancel_admin");
function car_request_cancel_admin() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_car_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_request_cancel_declined", "car_request_cancel_declined");
add_action("wp_ajax_nopriv_car_request_cancel_declined", "car_request_cancel_declined");
function car_request_cancel_declined() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_car_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_request_cancel_approved", "car_request_cancel_approved");
add_action("wp_ajax_nopriv_car_request_cancel_approved", "car_request_cancel_approved");
function car_request_cancel_approved() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_car_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_email_reminder7", "car_email_reminder7");
add_action("wp_ajax_nopriv_car_email_reminder7", "car_email_reminder7");
function car_email_reminder7() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'rent_reminder7_car_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_email_reminder3", "car_email_reminder3");
add_action("wp_ajax_nopriv_car_email_reminder3", "car_email_reminder3");
function car_email_reminder3() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder3_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_car_email_reminder1", "car_email_reminder1");
add_action("wp_ajax_nopriv_car_email_reminder1", "car_email_reminder1");
function car_email_reminder1() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'book_reminder1_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_option_car_email_notify", "option_car_email_notify");
add_action("wp_ajax_nopriv_option_car_email_notify", "option_car_email_notify");
function option_car_email_notify() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_head_notify';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_email_foot_notify';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_request_cancel", "restau_request_cancel");
add_action("wp_ajax_nopriv_restau_request_cancel", "restau_request_cancel");
function restau_request_cancel() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_request_cancel_admin", "restau_request_cancel_admin");
add_action("wp_ajax_nopriv_restau_request_cancel_admin", "restau_request_cancel_admin");
function restau_request_cancel_admin() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_head_cancel';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_body_cancel';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'admin_restau_email_footer_cancel';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_request_cancel_declined", "restau_request_cancel_declined");
add_action("wp_ajax_nopriv_restau_request_cancel_declined", "restau_request_cancel_declined");
function restau_request_cancel_declined() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_declined_restau_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_request_cancel_approved", "restau_request_cancel_approved");
add_action("wp_ajax_nopriv_restau_request_cancel_approved", "restau_request_cancel_approved");
function restau_request_cancel_approved() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'request_approved_restau_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_email_reminder7", "restau_email_reminder7");
add_action("wp_ajax_nopriv_restau_email_reminder7", "restau_email_reminder7");
function restau_email_reminder7() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder7_restau_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_email_reminder3", "restau_email_reminder3");
add_action("wp_ajax_nopriv_restau_email_reminder3", "restau_email_reminder3");
function restau_email_reminder3() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder3_restau_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_restau_email_reminder1", "restau_email_reminder1");
add_action("wp_ajax_nopriv_restau_email_reminder1", "restau_email_reminder1");
function restau_email_reminder1() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_head';");
    $qry_body   = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_body';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'reserve_reminder1_restau_email_footer';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_body) == 0 ) {
    } else {
        $data[] = $qry_body[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_option_restau_email_notify", "option_restau_email_notify");
add_action("wp_ajax_nopriv_option_restau_email_notify", "option_restau_email_notify");
function option_restau_email_notify() {
    global $wpdb;
    $options    = $wpdb->prefix . 'sync_options';
    $data       = array();
    $qry_head   = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_head_notify';");
    $qry_footer = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_email_foot_notify';");

    if ( count($qry_head) == 0 ) {
    } else {
        $data[] = $qry_head[0]->option_value;
    }

    if ( count($qry_footer) == 0 ) {
    } else {
        $data[] = $qry_footer[0]->option_value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_confirm_cancel", "confirm_cancel");
add_action("wp_ajax_nopriv_confirm_cancel", "confirm_cancel");
function confirm_cancel() {
    global $wpdb; 
    $id            = $_REQUEST['id'];
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table         = $wpdb->prefix . 'sync_payments';
    $email_cont    = $wpdb->prefix . 'sync_options';
    $entries       = $wpdb->prefix . 'sync_hotel_entries';
    $qry           = $wpdb->get_results("SELECT * from $entries where id = '".$id."';");
    $request_type = 'hotel_cancel';
    $content       = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('sync_hotel_email_head_cancel', 'sync_hotel_email_body_cancel', 'sync_hotel_email_footer_cancel')");
    $admin_content = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('admin_hotel_email_head_cancel', 'admin_hotel_email_body_cancel', 'admin_hotel_email_footer_cancel')");

    foreach ($qry as $values) {
        $name        = $values->firstname. " " .$values->lastname;
        $reference   = $values->reference_number;
        $phone       = $values->phone;
        $email       = $values->email;
        $status      = 'Pending'; 
        $email_entry = array();  
        $insert      = $wpdb->query("INSERT INTO $table_request( reference_num, name, phone_number, email_add, request_type, status) VALUES('".$reference."', '".$name."', '".$phone."', '".$email."', '".$request_type."', '".$status."');");
    }

    $greet_name           = ucfirst($qry[0]->firstname);
    $user_email           = $qry[0]->email;
    $data['header_msg']   = $content[0]->option_value;
    $data['footer_msg']   = $content[2]->option_value; 
    $data['body_msg']     = $content[1]->option_value;
    $data['admin_header'] = $admin_content[0]->option_value;
    $data['admin_footer'] = $admin_content[2]->option_value; 
    $data['admin_body']   = $admin_content[1]->option_value;
    require_once("email-templates/cancel-request-email-template.php");
    require_once("email-templates/admin-cancel-request.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'eaSYNC-Booking Reservation';
    $message    = $htmlContent;
    
    $headers2   = "MIME-Version: 1.0" . "\r\n";
    $headers2  .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $headers2  .= 'From: '.$noti_for.'<'.$from .'>' . "\r\n";
    $subject2   = get_bloginfo( 'name' ).' reservation (admin copy)';
    $message2   = $htmlContent_admin;
    $name       = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2);
    echo json_encode($id);
    wp_die();
}

add_action('wp_ajax_view_request_details', 'view_request_details');
add_action('wp_ajax_nopriv_view_request_details', 'view_request_details');
function view_request_details() {
    global $wpdb;
    $id            = $_REQUEST['id'];
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table_entries = $wpdb->prefix . 'sync_hotel_entries';
    $payments      = $wpdb->prefix . 'sync_payments';
    $table         = $wpdb->prefix . 'sync_options';
    $post          = $wpdb->prefix . "posts";
    $data          = array();;
    $request       = $wpdb->get_results("SELECT * from $table_request where id = '".$id."'; ");

    foreach ($request as $value) {
        $data[]      = $value;
        $entries     = $wpdb->get_results("SELECT id, room_id, arrival_date, departure_date, night_number, guest_number, facility_request, other_req from $table_entries where reference_number = '".$value->reference_num."';");
        $refund_rate = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_hotel_refund_rate';");
        $amount_paid = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'hotel' and item_belongsto = '".$entries[0]->id."';");
        
        foreach ($entries as $values) {
            $data[] = $values;
            $title  = $wpdb->get_results("SELECT post_title from $post where ID = '".$values->room_id."';");
            foreach ($title as $p_title) {
                $data[] = $p_title->post_title;
            }
        }
    }
    $rate        = $refund_rate[0]->option_value;
    $amount      = $amount_paid[0]->payment_gross;
    $refund      =  ( $rate / 100 ) * $amount;
    $cancel_cost = $amount - $refund;
    $data[]      = easyncCurrency();
    $data[]      = number_format($refund, 2);
    echo json_encode($data);
    wp_die();

}

add_action('wp_ajax_view_hotel_requests', 'view_hotel_requests');
add_action('wp_ajax_nopriv_view_hotel_requests', 'view_hotel_requests');
function view_hotel_requests() {
    global $wpdb;
    $status         = $_REQUEST['stat'];
    $data           = array();
    $table_requests = $wpdb->prefix . "sync_cancel_requests";
    $entries        = $wpdb->prefix . "sync_hotel_entries";
    $requests       = $wpdb->get_results("select * from $table_requests where status = '".$status."' and request_type = 'hotel_cancel'; ");
    
    if (!empty($requests)) {
        foreach ( $requests as $key => $value) {
            $data[]  = $value;
            $arrival = $wpdb->get_results("SELECT room_id, arrival_date from $entries where reference_number = '".$value->reference_num."'; ");
            foreach ($arrival as $date) {
                $data[] = $date;
            }
        }
    }
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_approve_cancel_request', 'approve_cancel_request');
add_action('wp_ajax_nopriv_approve_cancel_request', 'approve_cancel_request');
function approve_cancel_request() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $entries            = $wpdb->prefix . 'sync_hotel_entries';
    $payments           = $wpdb->prefix . 'sync_payments';
    $email_cont         = $wpdb->prefix . 'sync_options';
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_approved_email_head', 'request_approved_email_body', 'request_approved_email_footer')");
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $query_t            = $wpdb->get_results("SELECT id, firstname, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Approved' WHERE request_type= 'hotel_cancel' and reference_num = '".$query[0]->reference_num."';");
    $update             = $wpdb->get_results("UPDATE $entries SET status = 'cancelled' WHERE reference_number = '".$query[0]->reference_num."'; ");
    $pay_id             = $query_t[0]->id;
    $update_pay         = $wpdb->get_results("UPDATE $payments SET payment_status = 'cancelled' WHERE item_cat = 'hotel' and item_belongsto = '".$pay_id."';");
    $greet_name         = ucfirst($query_t[0]->firstname);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Booking Approved';
    $message    = $htmlContent;
    $name       = get_bloginfo( 'name' );
    mail($to,$subject,$message,$headers);
    echo json_encode($data); 
    wp_die();
}

add_action('wp_ajax_decline_cancel_request', 'decline_cancel_request');
add_action('wp_ajax_nopriv_decline_cancel_request', 'decline_cancel_request');
function decline_cancel_request() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $email_cont         = $wpdb->prefix . 'sync_options';
    $entries            = $wpdb->prefix . 'sync_hotel_entries';
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $query_t            = $wpdb->get_results("SELECT id, firstname, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_declined_email_head', 'request_declined_email_body', 'request_declined_email_footer')");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Declined' WHERE request_type= 'hotel_cancel' and reference_num = '".$query[0]->reference_num."';");
    $greet_name         = ucfirst($query_t[0]->firstname);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Booking Declined';
    $message    = $htmlContent;
    $name       = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    $data = $query_t[0]->id;
    echo json_encode($data); 
    wp_die();
}

add_action("wp_ajax_get_booking_details_car", "get_booking_details_car");
add_action("wp_ajax_nopriv_get_booking_details_car", "get_booking_details_car");
function get_booking_details_car() {
    global $wpdb;
    $reference      = $_REQUEST['ref'];
    $data           = array();
    $post           = $wpdb->prefix . "posts";
    $table          = $wpdb->prefix . "sync_rent_car_entries";
    $table_payments = $wpdb->prefix . "sync_payments";
    $grace_table    = $wpdb->prefix . "sync_options";
    $grace_period   = $wpdb->get_results("SELECT option_value from $grace_table where option_name = 'sync_car_grace_period';");
    $qry            = $wpdb->get_results("select * from $table where status = 'pending' and reference_number = '".$reference."';");
    $pay_status     = $wpdb->get_results("SELECT payment_status, payment_gross from $table_payments where item_cat = 'car' and item_belongsto = '".$qry[0]->id."';");
    $car            = $wpdb->get_results("SELECT post_title from $post where post_status = 'publish' and post_type = 'easync_car_rental' and ID = '".$qry[0]->car_id."';");

    if (!empty($qry)) {
        $pay_status = $wpdb->get_results("SELECT payment_status, payment_gross from $table_payments where item_belongsto = '".$qry[0]->id."';");
        foreach ($qry as $values) {
            $data[] = $values;
        }
        array_push($data, $grace_period[0]->option_value, $pay_status[0]->payment_status, number_format($pay_status[0]->payment_gross, 2), easyncCurrency(), $car[0]->post_title);
    } else { 
        $data = 'No Record';
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_cancel_rental", "cancel_rental");
add_action("wp_ajax_nopriv_cancel_rental", "cancel_rental");
function cancel_rental() {
    global $wpdb;
    $array        = array();
    $data         = array();
    $id           = $_REQUEST['id'];
    $entries      = $wpdb->prefix . 'sync_rent_car_entries';
    $payments     = $wpdb->prefix . 'sync_payments';
    $table        = $wpdb->prefix . 'sync_options';
    $grace_period = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_car_grace_period';");
    $refund_rate  = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_car_refund_rate';");
    $amount_paid  = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'car' and item_belongsto = '".$id."';");
    $pick_date    = $wpdb->get_results("SELECT id, pick_date from $entries where id = '".$id."';");
    $now          = date_create(date("m/d/Y"));
    $arrival      = date_create($pick_date[0]->pick_date); 
    $curr_id      = $pick_date[0]->id;
    $check_period = date_diff($arrival, $now);
    $format       = $check_period->format("%a");

    if ( $format >= $grace_period[0]->option_value ) {
        $rate        = $refund_rate[0]->option_value;
        $amount      = $amount_paid[0]->payment_gross;
        $refund      =  ( $rate / 100 ) * $amount;
        $cancel_cost = $amount - $refund;
        array_push($array, number_format($amount, 2), number_format(round($cancel_cost, 2), 2), number_format($refund, 2), easyncCurrency(), $curr_id);
    }
    foreach ($array as $value) {
        $data[] = $value;
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_confirm_cancel_car", "confirm_cancel_car");
add_action("wp_ajax_nopriv_confirm_cancel_car", "confirm_cancel_car");
function confirm_cancel_car() {
    global $wpdb; 
    $id            = $_REQUEST['id'];
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table         = $wpdb->prefix . 'sync_payments';
    $entries       = $wpdb->prefix . 'sync_rent_car_entries';
    $email_cont    = $wpdb->prefix . 'sync_options';
    $qry           = $wpdb->get_results("SELECT * from $entries where id = '".$id."';");
    $request_type  = 'car_cancel';
    $content       = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('sync_car_email_head_cancel', 'sync_car_email_body_cancel', 'sync_car_email_footer_cancel')");
    $admin_content = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('admin_car_email_head_cancel', 'admin_car_email_body_cancel', 'admin_car_email_footer_cancel')");

    foreach ($qry as $values) {
        $name      = $values->firstname. " " .$values->lastname;
        $reference = $values->reference_number;
        $phone     = $values->phone;
        $email     = $values->email;
        $status    = 'Pending'; 
        $insert    = $wpdb->query("INSERT INTO $table_request( reference_num, name, phone_number, email_add, request_type, status) VALUES('".$reference."', '".$name."', '".$phone."', '".$email."', '".$request_type."', '".$status."');");
    }

    $greet_name           = ucfirst($qry[0]->firstname);
    $user_email           = $qry[0]->email;
    $data['header_msg']   = $content[0]->option_value;
    $data['footer_msg']   = $content[2]->option_value; 
    $data['body_msg']     = $content[1]->option_value;
    $data['admin_header'] = $admin_content[0]->option_value;
    $data['admin_footer'] = $admin_content[2]->option_value; 
    $data['admin_body']   = $admin_content[1]->option_value;

    require_once("email-templates/cancel-request-email-template.php");
    require_once("email-templates/admin-cancel-request.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'eaSYNC-Booking Reservation';
    $message    = $htmlContent;
    
    $headers2   = "MIME-Version: 1.0" . "\r\n";
    $headers2  .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers2  .= 'From: '.$noti_for.'<'.$from .'>' . "\r\n";
    $subject2   = get_bloginfo( 'name' ).' reservation (admin copy)';
    $message2   = $htmlContent_admin;
    $name       = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2);
    echo json_encode($id);
    wp_die();
}

add_action("wp_ajax_get_booking_details_restau", "get_booking_details_restau");
add_action("wp_ajax_nopriv_get_booking_details_restau", "get_booking_details_restau");
function get_booking_details_restau() {
    global $wpdb;
    $reference      = $_REQUEST['ref'];
    $data           = array();
    $item           = array();
    $menu           = array();
    $qty            = array();
    $tmp            = array();
    $post           = $wpdb->prefix . "posts";
    $table          = $wpdb->prefix . "sync_restau_entries";
    $table_payments = $wpdb->prefix . "sync_payments";
    $grace_table    = $wpdb->prefix . "sync_options";
    $table_reserved = $wpdb->prefix . 'sync_restau_tables'; 
    $grace_period   = $wpdb->get_results("SELECT option_value from $grace_table where option_name = 'sync_restau_grace_period';");
    $qry            = $wpdb->get_results("select * from $table where reference_number = '".$reference."';");
    $pay_status     = $wpdb->get_results("SELECT payment_status, payment_gross from $table_payments where item_cat = 'restau' and item_belongsto = '".$qry[0]->id."';");
    $get_data       = $wpdb->get_results("SELECT * from $table_reserved where entry_id = '".$qry[0]->id."';");
    $id             = $qry[0]->id;

    for ($x = 0; $x < count($get_data); $x++) {
        $tmp = explode(", ", $get_data[$x]->menu_ids);
        for ($y = 0; $y < count($tmp); $y++) {
            $menu = explode(" ", $tmp[$y]);
            $restau = $wpdb->get_results("SELECT post_title from $post where post_status = 'publish' and post_type = 'easync_restau' and ID = '".$menu[0]."';");
            array_push($item, $restau[0]->post_title);
            array_push($qty, trim($menu[3],")"));
        }
        unset($tmp);
    }

    if (!empty($qry)) {
        $pay_status = $wpdb->get_results("SELECT payment_status, payment_gross from $table_payments where item_cat = 'restau' and item_belongsto = '".$id."';");
        foreach ($qry as $values) {
            $data[] = $values;
        }
        array_push($data, $grace_period[0]->option_value, $pay_status[0]->payment_status, number_format($pay_status[0]->payment_gross, 2), easyncCurrency(), $item, $qty);
    } else { 
        $data = 'No Record';
    }
    echo json_encode($data);
    wp_die();
}

add_action("wp_ajax_confirm_cancel_restau", "confirm_cancel_restau");
add_action("wp_ajax_nopriv_confirm_cancel_restau", "confirm_cancel_restau");
function confirm_cancel_restau() {
    global $wpdb; 
    $id            = $_REQUEST['id'];
    $error         = '';
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table         = $wpdb->prefix . 'sync_payments';
    $entries       = $wpdb->prefix . 'sync_restau_entries';
    $email_cont    = $wpdb->prefix . 'sync_options';
    $qry           = $wpdb->get_results("SELECT * from $entries where id = '".$id."';");
    $ref_num       = $qry[0]->reference_number;
    $request_type  = 'restau_cancel';
    $content       = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('sync_restau_email_head_cancel', 'sync_restau_email_body_cancel', 'sync_restau_email_footer_cancel')");
    $admin_content = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('admin_restau_email_head_cancel', 'admin_restau_email_body_cancel', 'admin_restau_email_footer_cancel')");

    foreach ($qry as $values) {
        $name            = $values->name;
        $reference       = $values->reference_number;
        $phone           = $values->phone;
        $email           = $values->email;
        $status          = 'Pending'; 
        $insert = $wpdb->query("INSERT INTO $table_request( reference_num, name, phone_number, email_add, request_type, status) VALUES('".$reference."', '".$name."', '".$phone."', '".$email."', '".$request_type."', '".$status."');"); 
    }

    $greet_name           = ucfirst($qry[0]->firstname);
    $user_email           = $qry[0]->email;
    $data['header_msg']   = $content[0]->option_value;
    $data['footer_msg']   = $content[2]->option_value; 
    $data['body_msg']     = $content[1]->option_value;
    $data['admin_header'] = $admin_content[0]->option_value;
    $data['admin_footer'] = $admin_content[2]->option_value; 
    $data['admin_body']   = $admin_content[1]->option_value;

    require_once("email-templates/cancel-request-email-template.php");
    require_once("email-templates/admin-cancel-request.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'eaSYNC-Booking Reservation';
    $message    = $htmlContent;
    
    $headers2   = "MIME-Version: 1.0" . "\r\n";
    $headers2  .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers2  .= 'From: '.$noti_for.'<'.$from .'>' . "\r\n";
    $subject2   = get_bloginfo( 'name' ).' reservation (admin copy)';
    $message2   = $htmlContent_admin;
    $name = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2);
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_view_car_requests', 'view_car_requests');
add_action('wp_ajax_nopriv_view_car_requests', 'view_car_requests');
function view_car_requests() {
    global $wpdb;
    $status         = $_REQUEST['stat'];
    $data           = array();
    $table_requests = $wpdb->prefix . "sync_cancel_requests";
    $entries        = $wpdb->prefix . "sync_rent_car_entries";
    $requests       = $wpdb->get_results("select * from $table_requests where status = '".$status."' and request_type = 'car_cancel'; ");

    if (!empty($requests)) {
        foreach ( $requests as $key => $value) {
            $data[]  = $value;
            $arrival = $wpdb->get_results("SELECT pick_date from $entries where reference_number = '".$value->reference_num."'; ");
            foreach ($arrival as $date) {
                $data[] = $date;
            }
        }
    }
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_view_restau_requests', 'view_restau_requests');
add_action('wp_ajax_nopriv_view_restau_requests', 'view_restau_requests');
function view_restau_requests() {
    global $wpdb;
    $status         = $_REQUEST['stat'];
    $data           = array();
    $table_requests = $wpdb->prefix . "sync_cancel_requests";
    $entries        = $wpdb->prefix . "sync_restau_entries";
    $requests       = $wpdb->get_results("select * from $table_requests where status = '".$status."' and request_type = 'restau_cancel'; ");
    if (!empty($requests)) {
        foreach ( $requests as $key => $value) {
            $data[] = $value;
            $arrival = $wpdb->get_results("SELECT pick_date from $entries where reference_number = '".$value->reference_num."'; ");
            foreach ($arrival as $date) {
                $data[] = $date;
            }
        }
    }
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_view_request_details_car', 'view_request_details_car');
add_action('wp_ajax_nopriv_view_request_details_car', 'view_request_details_car');
function view_request_details_car() {
    global $wpdb;
    $id            = $_REQUEST['id'];
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table_entries = $wpdb->prefix . 'sync_rent_car_entries';
    $payments      = $wpdb->prefix . 'sync_payments';
    $table         = $wpdb->prefix . 'sync_options';
    $post          = $wpdb->prefix . "posts";
    $data          = array();
    $request       = $wpdb->get_results("SELECT * from $table_request where id = '".$id."'; ");
    
    foreach ($request as $value) {
        $data[]      = $value;
        $entries     = $wpdb->get_results("SELECT id, car_id, pick_date, return_date, number_days, facility_request, other_req from $table_entries where reference_number = '".$value->reference_num."';");
        $refund_rate = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_car_refund_rate';");
        $amount_paid = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'car' and item_belongsto = '".$entries[0]->id."';");
        foreach ($entries as $values) {
            $data[] = $values;
            $title = $wpdb->get_results("SELECT post_title from $post where post_status = 'publish' and ID = '".$values->car_id."';");
            foreach ($title as $p_title) {
                $data[] = $p_title->post_title;
            }
        }
    }

    $rate        = $refund_rate[0]->option_value;
    $amount      = $amount_paid[0]->payment_gross;
    $refund      =  ( $rate / 100 ) * $amount;
    $cancel_cost = $amount - $refund;
    $data[]      = easyncCurrency();
    $data[]      = number_format($refund, 2);
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_view_request_details_restau', 'view_request_details_restau');
add_action('wp_ajax_nopriv_view_request_details_restau', 'view_request_details_restau');
function view_request_details_restau() {
    global $wpdb;
    $id            = $_REQUEST['id'];
    $table_request = $wpdb->prefix . 'sync_cancel_requests';
    $table_entries = $wpdb->prefix . 'sync_restau_entries';
    $table_menus   = $wpdb->prefix . 'sync_restau_tables';
    $payments      = $wpdb->prefix . 'sync_payments';
    $table         = $wpdb->prefix . 'sync_options';
    $post          = $wpdb->prefix . "posts";
    $data          = array();
    $item          = array();
    $temp_menu     = array();
    $request       = $wpdb->get_results("SELECT * from $table_request where id = '".$id."'; ");
    $entries       = $wpdb->get_results("SELECT * from $table_entries where reference_number = '".$request[0]->reference_num."';");
    $refund_rate   = $wpdb->get_results("SELECT option_value from $table where option_name = 'sync_restau_refund_rate';");
    $amount_paid   = $wpdb->get_results("SELECT payment_gross from $payments where item_cat = 'restau' and item_belongsto = '".$entries[0]->id."';");
    $get_menu_id   = $wpdb->get_results("SELECT menu_ids from $table_menus where entry_id = '".$entries[0]->id."';");

    foreach ($request as $values) {
        $data[] = $values;
    }

    for ($ndex = 0; $ndex < count($get_menu_id); $ndex++) {
        $temp_menu[] = explode(", ", $get_menu_id[$ndex]->menu_ids);
        foreach($temp_menu[$ndex] as $key) {
            $get_id[] = explode(' ', $key);
        }
    }
    for ($x = 0; $x < count($get_id); $x++) {
        $m_id[] = $get_id[$x][0];
        $m_qty[] = rtrim($get_id[$x][3], ')');

    }
    $data['menu'] = $m_qty;
    $tmp = $m_id; 

    foreach ($tmp as $index => $each_item) {
        $restau = $wpdb->get_results("SELECT post_title from $post where post_status = 'publish' and post_type = 'easync_restau' and ID = '".$each_item."';");
        $menu_list[] = $restau[0]->post_title. " (" .$m_qty[$index]. ")"; 
    }
    array_push($item, $menu_list);

    $rate        = $refund_rate[0]->option_value;
    $amount      = $amount_paid[0]->payment_gross;
    $refund      =  ( $rate / 100 ) * $amount;
    $cancel_cost = $amount - $refund;
    $curr        = easyncCurrency();
    $ref         = number_format($refund, 2);

    array_push($data, $entries, $item, $curr, $ref, $id);
    echo json_encode($data);
    wp_die();

}

add_action('wp_ajax_approve_cancel_request_car', 'approve_cancel_request_car');
add_action('wp_ajax_nopriv_approve_cancel_request_car', 'approve_cancel_request_car');
function approve_cancel_request_car() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $entries            = $wpdb->prefix . 'sync_rent_car_entries';
    $payments           = $wpdb->prefix . 'sync_payments';
    $email_cont         = $wpdb->prefix . 'sync_options';
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_approved_car_email_head', 'request_approved_car_email_body', 'request_approved_car_email_footer');");
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $query_t            = $wpdb->get_results("SELECT id, firstname, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Approved' WHERE request_type= 'car_cancel' and reference_num = '".$query[0]->reference_num."';");
    $update             = $wpdb->get_results("UPDATE $entries SET status = 'cancelled' WHERE reference_number = '".$query[0]->reference_num."'; ");
    $pay_id             = $query_t[0]->id;
    $update_pay         = $wpdb->get_results("UPDATE $payments SET payment_status = 'cancelled' WHERE item_cat = 'car' and item_belongsto = '".$pay_id."';");
    $greet_name         = ucfirst($query_t[0]->firstname);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Car Rental Approved';
    $message    = $htmlContent;
    $name = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    echo json_encode($data); 
    wp_die();
}

add_action('wp_ajax_decline_cancel_request_car', 'decline_cancel_request_car');
add_action('wp_ajax_nopriv_decline_cancel_request_car', 'decline_cancel_request_car');
function decline_cancel_request_car() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $email_cont         = $wpdb->prefix . 'sync_options';
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $entries            = $wpdb->prefix . 'sync_rent_car_entries';
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_declined_car_email_head', 'request_declined_car_email_body', 'request_declined_car_email_footer')");
    $query_t            = $wpdb->get_results("SELECT id, firstname, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Declined' WHERE request_type= 'car_cancel' and reference_num = '".$query[0]->reference_num."';");
    $greet_name         = ucfirst($query_t[0]->firstname);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Car Rental Declined';
    $message    = $htmlContent;
    $name       = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    $data = 'success';
    echo json_encode($data); 
    wp_die();
}

add_action('wp_ajax_approve_cancel_request_restau', 'approve_cancel_request_restau');
add_action('wp_ajax_nopriv_approve_cancel_request_restau', 'approve_cancel_request_restau');
function approve_cancel_request_restau() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $entries            = $wpdb->prefix . 'sync_restau_entries';
    $payments           = $wpdb->prefix . 'sync_payments';
    $email_cont         = $wpdb->prefix . 'sync_options';
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_approved_restau_email_head', 'request_approved_restau_email_body', 'request_approved_restau_email_footer')");
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $query_t            = $wpdb->get_results("SELECT id, name, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Approved' WHERE request_type= 'restau_cancel' and reference_num = '".$query[0]->reference_num."';");
    $update             = $wpdb->get_results("UPDATE $entries SET status = 'cancelled' WHERE reference_number = '".$query[0]->reference_num."'; ");
    $pay_id             = $query_t[0]->id;
    $update_pay         = $wpdb->get_results("UPDATE $payments SET payment_status = 'cancelled' WHERE item_cat = 'restau' and item_belongsto = '".$pay_id."';");
    $greet_name         = ucfirst($query_t[0]->name);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Reservation Approved';
    $message    = $htmlContent;
    $name = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    echo json_encode($data); 
    wp_die();
}

add_action('wp_ajax_decline_cancel_request_restau', 'decline_cancel_request_restau');
add_action('wp_ajax_nopriv_decline_cancel_request_restau', 'decline_cancel_request_restau');
function decline_cancel_request_restau() {
    global $wpdb;
    $id                 = $_REQUEST['id'];
    $email_cont         = $wpdb->prefix . 'sync_options';
    $request            = $wpdb->prefix . 'sync_cancel_requests';
    $entries            = $wpdb->prefix . 'sync_restau_entries';
    $query              = $wpdb->get_results("SELECT reference_num from $request where id = '".$id."';");
    $content            = $wpdb->get_results("SELECT option_value from $email_cont where option_name IN ('request_declined_restau_email_head', 'request_declined_restau_email_body', 'request_declined_restau_email_footer')");
    $query_t            = $wpdb->get_results("SELECT id, name, email from $entries where reference_number = '".$query[0]->reference_num."';");
    $qry                = $wpdb->get_results("UPDATE $request SET status = 'Declined' WHERE request_type= 'restau_cancel' and reference_num = '".$query[0]->reference_num."';");
    $greet_name         = ucfirst($query_t[0]->name);
    $user_email         = $query_t[0]->email;
    $data['header_msg'] = $content[0]->option_value;
    $data['footer_msg'] = $content[2]->option_value; 
    $data['body_msg']   = $content[1]->option_value;
    
    require_once("email-templates/cancel-request-email-template.php");

    $to         = $user_email; // this is your Email address
    $from       = get_option('admin_email'); // this is the sender's Email address
    $headers    = "MIME-Version: 1.0" . "\r\n";
    $headers   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers   .= 'From: '.get_bloginfo( 'name' ).'<'.$from .'>' . "\r\n";
    $subject    = 'Request to Cancel Reservation Declined';
    $message    = $htmlContent;
    $name       = get_bloginfo( 'name' );

    mail($to,$subject,$message,$headers);
    $data = 'success';
    echo json_encode($data); 
    wp_die();
}

add_action('wp_ajax_save_captcha_key', 'save_captcha_key');
add_action('wp_ajax_nopriv_save_captcha_key', 'save_captcha_key');
function save_captcha_key() {
    global $wpdb;
    $option             = $wpdb->prefix . 'sync_options';
    $captcha_key        = $_REQUEST['captcha_key'];
    $captcha_key_secret = $_REQUEST['captcha_key_secret'];
    $data               = array();
    $check              = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_captcha_key'");
    $check_secret       = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_captcha_key_secret'");

    if (empty($check)) {
        $insert = $wpdb->get_results("INSERT INTO $option(option_name, option_value) VALUES('sync_captcha_key', '".$captcha_key."'); ");
    } else {
        $update = $wpdb->get_results("UPDATE $option SET option_value = '".$captcha_key."' WHERE option_name = 'sync_captcha_key';");
    }

    if (empty($check_secret)) {
        $insert = $wpdb->get_results("INSERT INTO $option(option_name, option_value) VALUES('sync_captcha_key_secret', '".$captcha_key_secret."'); ");
    } else {
        $update = $wpdb->get_results("UPDATE $option SET option_value = '".$captcha_key_secret."' WHERE option_name = 'sync_captcha_key_secret';");
    }
    array_push( $data, 'Success', $captcha_key, $captcha_key_secret );
    echo json_encode($data); 
    wp_die();
}

add_action('wp_head', 'override_themecolor');
add_action('admin_head', 'override_themecolor');
function override_themecolor() {

    $theme_color       = "#ff5f01";
    $theme_hover_color = "#001d3d";
        
    echo "<script>
        document.documentElement.style.setProperty('--primary-theme-color', '".$theme_color."');
        document.documentElement.style.setProperty('--primary-theme-color-hover', '".$theme_hover_color."');
    </script>";

}

add_action('wp_print_scripts', 'set_captcha');
function set_captcha() {
    global $wpdb;
    $option     = $wpdb->prefix . 'sync_options';
    $site_key   = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_captcha_key';");
    $key        = $site_key[0]->option_value;
    $switch     = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_captcha_switch';");
    $switch_val = $switch[0]->option_value;

    if($switch_val == 'on') {
        wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js?render='.$key.'');
        wp_enqueue_script( 'recaptcha');
    }
} 

add_action('wp_ajax_delete_timeslot1', 'delete_timeslot1');
function delete_timeslot1() {
    global $wpdb;
    $option = $wpdb->prefix . 'sync_options';
    $qry    = $wpdb->get_results("DELETE FROM $option WHERE option_name = 'sync_timeslot1';");
    $data[] = 'Success';
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_delete_timeslot2', 'delete_timeslot2');
function delete_timeslot2() {
    global $wpdb;
    $option = $wpdb->prefix . 'sync_options';
    $qry    = $wpdb->get_results("DELETE FROM $option WHERE option_name = 'sync_timeslot2';");
    $data[] = 'Success';
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_delete_timeslot3', 'delete_timeslot3');
function delete_timeslot3() {
    global $wpdb;
    $option = $wpdb->prefix . 'sync_options';
    $qry    = $wpdb->get_results("DELETE FROM $option WHERE option_name = 'sync_timeslot3';");
    $data[] = 'Success';
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_delete_timeslot4', 'delete_timeslot4');
function delete_timeslot4() {
    global $wpdb;
    $option = $wpdb->prefix . 'sync_options';
    $qry    = $wpdb->get_results("DELETE FROM $option WHERE option_name = 'sync_timeslot4';");
    $data[] = 'Success';
    echo json_encode($data);
    wp_die();
}

add_action('wp_ajax_delete_timeslot5', 'delete_timeslot5');
function delete_timeslot5() {
    global $wpdb;
    $option = $wpdb->prefix . 'sync_options';
    $qry    = $wpdb->get_results("DELETE FROM $option WHERE option_name = 'sync_timeslot5';");
    $data[] = 'Success';
    echo json_encode($data);
    wp_die();
}

add_action('in_admin_header', 'plugin_page_head');
function plugin_page_head() {
    $image_path = plugin_dir_url( dirname( __FILE__ ) ).'easync-booking/images/logo orange light.svg';
    
    if ( 
        ( $_GET['page'] == 'easync-settings') || ( $_GET['page'] == 'easync-booking') || ( $_GET['page'] == 'easync-entries') || 
        ( $_GET['page'] == 'easync-cancellation-requests') || ( $_GET['page'] == 'easync-premium')
    ) {
        echo '<header class="main header-logo"> 
            <div class="sync-entries-title"><img src="'.$image_path.'";" width="184" height="47"></div>
        </header>';
    }      
}

add_action('admin_footer', 'loader_slh');
function loader_slh() {
    global $post_type; ?>
    <script>
        jQuery('<div class="loader_slh"><div class="preload_icon"></div></div>').prependTo('body');
        jQuery(window).load(function() {
            jQuery(".loader_slh").fadeOut("slow");
        });
    </script> <?php 
}

error_reporting(0);