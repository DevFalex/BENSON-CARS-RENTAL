<?php  
if( ! defined( 'ABSPATH' ) ) exit;
global $subscription_hotel, $subscription_car, $subscription_restau, $wpdb; ?>
<?php 
$hotel_key = "";
$car_key = "";
$restau_key = "";

$opt_table = $wpdb->prefix . 'sync_options';
$get_hotel_key = $wpdb->get_results("SELECT * from $opt_table where option_name IN ('sync_premium_hotel', 'sync_premium_hotel_key');");
$hotel_key = $get_hotel_key[1]->option_value;
$get_car_key = $wpdb->get_results("SELECT * from $opt_table where option_name IN ('sync_premium_car', 'sync_premium_car_key');");
$car_key = $get_car_key[1]->option_value;

$get_restau_key = $wpdb->get_results("SELECT * from $opt_table where option_name IN ('sync_premium_restau', 'sync_premium_restau_key');");
$restau_key = $get_restau_key[1]->option_value;

function get_starred($str) {
    $len = strlen($str);
    return str_repeat('*', $len - 4).substr($str, $len - 4, 4);
}
?>

<main class="sync_backend_premium">  
    <div class="sync_common_settings">
        <div class="premium-container">
            <div class="easync_head">
                <h3 class="plugin_desc"> 
                    Go Premium <span class="small-text-desc" style="font-weight:normal; font-size:20px; color:black;"> and experience all the feautures eaSYNC Booking has to offer for your business website.</span>
                </h3>
            </div>
            <br>
            <div class="easync_details">
                <h4 class="plugin_desc"> 
                    <span class="small-text-desc" style="font-weight:normal; font-size:20px; color:black;"> Click below to choose your premium plan.</span>
                </h4>
            </div>
            <br>
            <div class="buy_section">
                <button class="hotel_module">Buy Hotel Booking Premium</button>
                <br>
                <button class="car_module">Buy Car Booking Premium</button>
                <br>
                <button class="restau_module">Buy Restaurant Booking Premium</button>
            </div>
            <br>
                <span class="license_info">
                    Once you select, you will receive an email with your license key.
                </span>
            <br>
            <div class="more-info_contact-us">
                <span class="more-info">
                    For more information, visit us at our website <a href="https://easync.syntacticsinc.com/" target="_blank">easync.syntacticsinc.com</a>.
                </span>
            </div>
        </div>
    </div>
</main>

<script>
    jQuery('.buy_section .hotel_module').click( function () {
        window.open('https://easync.syntacticsinc.com/hotel-booking-reservation-plugin-pricing/', '_blank');
    });
    jQuery('.buy_section .car_module').click( function () {
        window.open('https://easync.syntacticsinc.com/car-booking-reservation-plugin-pricing/', '_blank');
    });
    jQuery('.buy_section .hotel_module').click( function () {
        window.open('https://easync.syntacticsinc.com/hotel-booking-reservation-plugin-pricing/', '_blank');
    });
</script>