<?php 
if( ! defined( 'ABSPATH' ) ) exit;
if(!is_admin()) {
global $wpdb, $post, $errors_config_hotel;

$table = $wpdb->prefix . 'sync_options';
$qry = $wpdb->get_results( "SELECT option_value FROM $table where option_name IN ('sync_authorize_switch', 'sync_paypal_switch', 'sync_stripe_switch', 'sync_offline_switch');");

if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off' && $qry[3]->option_value=='off' )  && is_user_logged_in() == true) {
	?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Hotel Booking or click "Advance" and enter needed information"</span><ul><?php
	?><li>Please select and enable a payment gateway.</li></ul><?php
	exit;
}
if(!empty($errors_config_hotel) && is_user_logged_in()==true) {
	?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Hotel Booking or click "Advance" and enter needed information"</span><ul><?php
	foreach ($errors_config_hotel as $error) {
		?>
		<li><?php echo $error; ?></li>
		<?php
	}
	if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off' && $qry[3]->option_value=='off') && is_user_logged_in() == true) {
		?><li>Please select and enable a payment gateway.</li><?php
	}
	exit;
	?></ul><?php
}elseif(!empty($errors_config_hotel) && is_user_logged_in()==false){
	?><h3>This module is currently under maintenance, check back soon!</h3><?php
	exit;
}
		
$_SESSION['sync_form'] = 'hotel';
$_SESSION['sync_page_redirect'] = $post->post_name;

?>

<div class="sync_form_wrapper_set sync_user_option">
	<div class="head_label">
		<h1>Hotel Accommodation</h1>
	</div>
	<div class="select_opt">
		<input type="button" value="Book a Room" name="book_room" class="book_room">
		<input type="button" value="Check Booking" name="check_booking" class="check_booking">  
	</div>
</div>


<div class="sync_form_wrapper sync_hotel_wrapper" style="display:none;">
	<div class="go_back">
		<span class="back_text"><i class="fa fa-arrow-left"></i>  Back</span>
	</div>
	<div class="sync_container pick-date">
		<div class="sync_options_currency">
			<!-- <select class="sync_options_currency_onchange" name="sync_options_currency_name">
			<?php //echo sync_options_currency();?>
			</select> -->
		</div>
		<div class="sync_title">
			<h1>Room Reservation</h1>
			<?php
			if (!empty($_SESSION['message'])) {
			    echo '<p class="message"> '.esc_html($_SESSION['message']).'</p>';
			    unset($_SESSION['message']);
			}
			?>
		</div>
		<div class="sync_components">
			<form id="search_hotel_room" action="" method="post">
				<div class="sync-holder-field">
					<div class="holder holder-calendar">
						<label>Check-in Date</label>
						<input required readonly id="datepicker_hotel" data-toggle="datepicker-hotel" value="<?php echo isset($_POST['date_arrive']) ? esc_html($_POST['date_arrive']) : '' ?>" name="date_arrive"><i class="far fa-calendar-alt fa-1x calendar"></i>
					</div>
					<div style="display: none;" class="holder" data-toggle="datepicker"></div>
					<div class="holder holder-night quantity">
						<label>Duration</label>
						<input id="spend_night_hotel" type="number" min="1" max="30" step="1" value="<?php echo isset($_POST['night_number']) ? esc_html($_POST['night_number']) : '1' ?>" name="night_number"><span class="night night-text">night(s)</span>
					</div>
					<div class="holder holder-check-out no-border">
						<label>Check-out Date</label>
						<label class="date_departure"><?php echo isset($_POST['date_departure']) ? esc_html($_POST['date_departure']) : '' ?></label>
						<label id="date_departure_num"><?php echo isset($_POST['night_number']) ? '<i class="fa fa-moon-o fa-1x"></i> '.esc_html($_POST['night_number']).' night only' : '' ?></label>
						<input type="hidden" value="<?php echo isset($_POST['date_departure']) ? esc_html($_POST['date_departure']) : '' ?>" name="date_departure" id="date_departure">
					</div>
					<div class="holder holder-guest-number quantity">
						<label>Guest(s)</label>
						<input type="number" value="<?php echo isset($_POST['number_guest']) ? $_POST['number_guest'] : '2' ?>" step="1" min="1" max="30" name="number_guest" maxlength="4">
					</div>
					<div class="holder holder-rooms-number quantity">
						<label>Room(s)</label>
						<input type="number" value="<?php echo isset($_POST['number_room']) ? $_POST['number_room'] : '1' ?>" step="1" min="1" max="30" name="number_room" maxlength="2">
					</div>
					<div class="holder holder-rooms-number quantity">
						<label>Bed(s)</label>
						<input type="number" value="<?php echo isset($_POST['number_bed']) ? $_POST['number_bed'] : '1' ?>" step="1" min="1" max="30" name="number_bed" maxlength="2">
					</div>
				</div>
				<div class="holder holder-check-availability">
					<div class="holder holder-check-room">
						<input type="button" value="Check Room" name="check_room" class="find-room" id="find-room">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="sync_form_wrapper_set sync_check_booking" style="display:none;">
	<div class="go_back">
		<span class="back_text"><i class="fa fa-arrow-left"></i>  Back</span>
	</div>
	<div class="ref_head">
		<h1>Search Bookings</h1>
	</div>
	<div class="get_reference">
		<input type="text" class="ref_number" name="ref_number" placeholder="Enter Reference Number" >
		<span class="search_ref"> Search </span>
	</div>
</div>

<div class="modall sync-transform fade sync-modal-booking-info" id="booking_info" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-md" role="document" data-keyboard="false">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">
		    <div class="booking-details">
				<div class="cust_name">

				</div>
				<div class="person_info">
					<div class="person_labels">

					</div>
					<div class="space">

					</div>
					<div class="person_data">

					</div>
				</div>
				<div class="book_head">

				</div>
				<div class="booking_details">
					<div class="booking_labels">

					</div>
					<div class="space">

					</div>
					<div class="booking_data">

					</div>
				</div>
				<br>
				<div class="cancel_section" style="text-align:center;">

					<?php 
						$table_name = $wpdb->prefix . 'sync_options';
						$check = $wpdb->get_results("SELECT * from $table_name  where option_name IN ('sync_hotel_grace_period', 'sync_hotel_refund_rate');");

						if( (!empty($check[0]->option_value)) && (!empty($check[1]->option_value))) { ?>
							<input class="cancel_booking" type="button" value="Cancel Booking" id="">
						<?php } 
					?>

				</div>
				<br>
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<div class="modall sync-transform fade sync-modal-booking-notFound" id="booking_notFound" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-md" role="document" data-keyboard="false">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">
		    <div class="rental-details">
				<h3>No Record Found.</h3>
			</div>
			<br>
			<div class="button_close">
				<input class="close_modal" type="button" value="Close" data-dismiss="modal">
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<div class="modall sync-transform fade sync-modal-booking-info" id="show_cancel" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog" role="document" data-keyboard="false">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-bodyy">
		    <div class="cancel_content">
				<div class="cancel_body">
					<div class="cancel_details">
						<div class="breakdown_label">
							<h1>Cancellation Cost Breakdown</h1>
						</div>
						<br>
						<div class="breakdown_details">
							<div class="breakdown_labels">

							</div>
							<div class="space">

							</div>
							<div class="breakdown_calculation">

							</div>
						</div>
						<hr style="border: 1px solid;">
						<div class="return_details">
							<div class="return_label">

							</div>
							<div class="space">

							</div>
							<div class="return_amount">

							</div>
						</div>
					<br>
					</div>
					<div class="cancel_action">
						<input class="confirm_cancel" type="button" value="Confirm" id="">
					</div>
				</div>
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<div class="modall sync-transform fade sync-modal-booking-info" id="cancel_success" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog" role="document" data-keyboard="false">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-bodyy">
		    <div class="cancel_content">
				<div class="cancel_body">
					<h1>Cancellation Request Sent.</h1>
					<div class="sub_content">
						<span class="content">Please allow 1-2 business days to review and assist you with your request.</span>
					</div>
					<br>
					<div class="button_close" style="text-align:center;">
						<input class="close_modal" type="button" value="Close">
					</div>
				</div>
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<?php    


	if( (!empty(sanitize_text_field($_GET['sync_options_currency_name']))) || (!empty(sanitize_text_field($_POST['date_arrive'])) && !empty(sanitize_text_field($_POST['night_number'])) && !empty(sanitize_text_field($_POST['number_guest'])) && !empty(sanitize_text_field($_POST['number_room'])))) {

		$_SESSION['sync_default_curreny'] = sanitize_text_field($_GET['sync_options_currency_name']);
		$date_arrive    = sanitize_text_field($_POST['date_arrive']);
		$date_departure = sanitize_text_field($_POST['date_departure']);
		$night_number   = intval($_POST['night_number']);
		$number_guest   = intval($_POST['number_guest']);
		$number_room    = intval($_POST['number_room']);
		$number_bed    = intval($_POST['number_bed']);
		
		$_SESSION['sync_date_arrive'] = $date_arrive;
		$_SESSION['sync_number_guest'] = $number_guest;
		$_SESSION['sync_number_room'] = $number_room;
		$_SESSION['sync_number_bed'] = $number_bed;

		include('search-list.php');		
		include('personal-info.php');
		include('payment.php');
		include('thank-you.php');
		include('payment_authorize.php');

	}

	// if(!empty($_GET['sync_options_currency_onchange']) && !empty($_GET['sync_options_currency_name'])) {

	// 	$_SESSION['sync_default_curreny'] = $_GET['sync_options_currency_name'];
	// 	$date_arrive    = $_POST['date_arrive'];
	// 	$date_departure = $_POST['date_departure'];
	// 	$night_number   = $_POST['night_number'];
	// 	$number_guest   = $_POST['number_guest'];
	// 	$number_room    = $_POST['number_room'];
		
	// 	$_SESSION['sync_date_arrive'] = $date_arrive;
	// 	$_SESSION['sync_number_guest'] = $number_guest;
	// 	$_SESSION['sync_number_room'] = $number_room;

	// 	include('search-list.php');		
	// 	include('personal-info.php');
	// 	include('payment.php');
	// 	include('thank-you.php');

	// } 

} ?>

<script>
	jQuery(".select_opt .book_room").click( function () {
		jQuery(".sync_form_wrapper.sync_hotel_wrapper").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});
	
	jQuery(".select_opt .check_booking").click( function () {
		jQuery(".sync_form_wrapper_set.sync_check_booking").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});

	
	jQuery(".sync_hotel_wrapper .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper.sync_hotel_wrapper').hide();
	});
	
	jQuery(".sync_check_booking .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper_set.sync_check_booking').hide();
	});

	jQuery("#booking_info .close").click( function () {
		jQuery('body').loading('stop');
	});

	jQuery("#show_cancel .close").click( function () {
		jQuery('body').loading('stop');
		jQuery("#booking_info").show();
	});

	jQuery("#cancel_success .close").click( function () {
		jQuery('body').loading('stop');
	});

	jQuery("#cancel_success .close").click( function () {
		jQuery('body').loading('stop');
		location.reload();
	});

	jQuery("#cancel_success .close_modal").click( function () {
		jQuery('body').loading('stop');
		location.reload();
	});


</script>

