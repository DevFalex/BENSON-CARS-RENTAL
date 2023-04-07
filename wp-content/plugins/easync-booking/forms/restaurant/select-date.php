<?php
if( ! defined( 'ABSPATH' ) ) exit;
if(!is_admin()) {
	session_start();
	global $wpdb, $post, $errors_config_restau;
	$table = $wpdb->prefix . 'sync_options';
	$qry = $wpdb->get_results( "SELECT option_value FROM $table where option_name IN ('sync_authorize_switch', 'sync_paypal_switch' ,'sync_stripe_switch');");

	if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off') && is_user_logged_in() == true) {
		?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Hotel Booking or click "Advance" and enter needed information"</span><ul><?php
		?><li>Please select and enable a payment gateway.</li></ul><?php
		exit;
	}
	
	if(!empty($errors_config_restau) && is_user_logged_in()==true) {
		?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Restaurant Reservation" or click "Advance" and enter needed information"</span><ul><?php
		foreach ($errors_config_restau as $error) {
			?>
			<li><?php echo $error; ?></li>
			<?php
		}
		
		if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off') && is_user_logged_in() == true) {
			?><li>Please select and enable a payment gateway.</li><?php
		}
		exit;
		?></ul><?php
	}elseif(!empty($errors_config_restau) && is_user_logged_in()==false){
		?><h3>This module is currently under maintenance, check back soon!</h3><?php
		exit;
	}	
	$_SESSION['sync_form'] = 'restau';
	$_SESSION['sync_page_redirect'] = $post->post_name;
	$table_name = $wpdb->prefix . "sync_options";
	$timezone_offset_minutes = 330;
	$timezone_name = timezone_name_from_abbr("", $timezone_offset_minutes*60, false);
	date_default_timezone_set($timezone_name);
	date_default_timezone_get();
	?>
	<div class="sync_form_wrapper restau_wrapper" style="display:none;">
		<div class="go_back">
			<span class="back_text"><i class="fa fa-arrow-left"></i>  Back</span>
		</div>
		<div class="sync_container pick-date">
			<div class="sync_title">
				<h1>Restaurant Reservation</h1>
				<?php
				if (!empty($_SESSION['message'])) {
					echo '<p class="message"> '.esc_html($_SESSION['message']).'</p>';
					unset($_SESSION['message']);
				}
				?>
			</div>
			<div class="sync_components">
				<form id="reserved_table" action="" method="post">
					<div class="column first">
						<div class="first-column calendar">
							<p class="label"><span>Select Date</span></p>
							<div class="input-group">
								<input type="hidden" class="docs-date" name="picked_date" placeholder="" value="">
							</div>
							<div class="docs-datepicker-container"></div>
						</div>
						<div class="first-column timeslot">
							<p><span>Pick your preferred time slot</span></p>
							<div class="timeslot-box">
								<?php
									$icon_array = array('sunrise.png', 'sun.png', 'sun.png', 'night.png', 'night.png');
									for ($i=1; $i < 6; $i++) { 
										$option_name = 'sync_timeslot'.$i;
										$entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ", $option_name));
										$from = explode("-", $entries[0]->option_value, 2)[0];
										$to   = explode("-", $entries[0]->option_value, 2)[1];
										if ( $entries ) {
											?>
											<div class="<?php echo 'timeslot-item slot-'.$i;?>">
												<p><img src="<?php echo plugin_dir_url(dirname( __FILE__ )) . '../images/'.$icon_array[$i-1]; ?>"></p>
												<p><?php echo esc_html($from);?></p>
												<p>--to--</p>
												<p><?php echo esc_html($to);?></p>
												<input type="hidden" value="<?php echo esc_html($from).'-'.esc_html($to);?>">
											</div>
											<?php
										}
									}
								?>	
							</div>
							<input type="hidden" name="timeslot" class="preferred-timeslot">
						</div>
					</div>
					<div class="column second">
						<div class="second-column date-today">
							<span>TODAY</span>
							<h2><?php echo esc_html(date('l', strtotime(date('d-m-Y'))));?></h2>
							<span><?php echo esc_html(date('M d, Y', strtotime(date('d-m-Y'))));?></span>
						</div>
						<div class="second-column form">
							<p class="label"><span>Your Information</span></p>
							<p class="sync_restau_holder_name">
								<input required type="text" name="full_name" id="full_name" placeholder="Name" value="<?php echo isset($_POST['full_name']) ? esc_html($_POST['full_name']) : '' ?>"><i class="icon-in-field fa fa-pencil fa-1x" ></i>
							</p>
							<p class="sync_restau_holder_email">
								<input required type="email" name="email_add" id="email_add" placeholder="Email Address" value="<?php echo isset($_POST['email_add']) ? esc_html($_POST['email_add']) : '' ?>"><i class="icon-in-field fa fa-envelope fa-1x"></i>
							</p>
							<p class="sync_restau_holder_phone">
								<input required type="text" name="phone_no" id="phone_no" placeholder="Phone Number" value="<?php echo isset($_POST['phone_no']) ? esc_html($_POST['phone_no']) : '' ?>"><i class="icon-in-field fa fa-phone fa-1x"></i>
							</p>
							<p class="label"><span>Branch Location</span></p>
							<p class="sync_restau_holder_branch">
								<select name="branch" class="branch_location js-states form-control">
									<?php
										$entries = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name = 'sync_branch_locations' ORDER BY id DESC" );
										if ( ! $entries ) {
											$wpdb->print_error(); 
										}else {
											foreach ( $entries as $key => $value) {
												if ($value->option_value == $_POST['branch']) { ?>
													<option value="<?php echo isset($_POST['branch']) ? esc_html($_POST['branch']) : '' ?>" selected><?php echo isset($_POST['branch']) ? esc_html($_POST['branch']) : '' ?></option>
												<?php } else { ?>
													<option value="<?php echo esc_html($value->option_value);?>"><?php echo esc_html(ucfirst($value->option_value));?></option>
												<?php }
											}
										}
									?>
								</select>
							</p>
							<div class="table_guest">
								<div class="sync-guest quantity">
									<p class="label"><span>Guest(s)</span></p>
									<p><input type="number" name="guest_no" min="1" max="30" value="<?php echo isset($_POST['guest_no']) ? esc_html($_POST['guest_no']) : '1' ?>" ></p>
								</div>
								<div class="sync-table quantity">
									<p class="label"><span>Table(s)</span></p>
									<p><input type="number" name="table_no" min="1" max="30" value="<?php echo isset($_POST['table_no']) ? esc_html($_POST['table_no']) : '1' ?>" ></p>
								</div>
							</div>
							
							
						</div>
						<div class="third-column submit-button" >
							<!-- <input type="button" data-dismiss="modal" data-target="#restau_menu_info" data-toggle="modal" name="submit" value="Reserve a table"> -->
							<button id="reserve" type="submit" class="reserve-table" >Reserve a Table</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="sync_form_wrapper_set sync_user_option">
		<div class="head_label">
			<h1>Restaurant Reservation</h1>
		</div>
		<div class="select_opt">
			<input type="button" value="Reserve a Table" name="reserve_table" class="reserve_table">
			<input type="button" value="Check Reservation" name="check_reservation" class="check_reservation"> 
		</div>
	</div>

	<div class="sync_form_wrapper_set sync_check_reservation" style="display:none;">
		<div class="go_back">
			<span class="back_text"><i class="fa fa-arrow-left"></i> Back</span>
		</div>
		<div class="ref_head">
			<h1>Search Reservation</h1>
		</div>
		<div class="get_reference">
			<input type="text" class="ref_number" name="ref_number" placeholder="Enter Reference Number" >
			<span class="search_ref_restau"> Search </span>
		</div>
	</div>

	<div class="modall sync-transform fade sync-modal-reserve-notFound" id="reserve_notFound" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
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

	<div class="modall sync-transform fade sync-modal-reservation-info" id="show_cancel" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
		<div class="modal-dialog" role="document" data-keyboard="false">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-targett="#customer_info">
						<span aria-hidden="true">×</span>
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
								<input class="confirm_cancel_restau" type="button" value="Confirm" id="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modall sync-transform fade sync-modal-reservation-info" id="reservation_info_restau" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
		<div class="modal-dialog" role="document" data-keyboard="false">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-bodyy">
					<div class="cancel_content">
						<div class="reservation-details">
							<div class="cust_name">
							</div>
							<br>
							<div class="reservation_details">
								<div class="person_email">
								</div>
								<div class="person_phone">
								</div>
							</div>
							<div class="reservation_details">
								<div class="menu_name">
								</div>
							</div>
							<br>
							<div class="reservation_details">
								<div class="reservation_date">
								</div>
								<div class="reservation_time">
								</div>
								<div class="reservation_branch">
								</div>
								<div class="reservation_table">
								</div>
								<div class="reservation_guests">
								</div>
								<div class="reservation_paid">
								</div>
							</div>
							<br>
							<div class="cancel_section" style="text-align:center;">	
								<?php 
									$check = $wpdb->get_results("SELECT * from $table_name  where option_name IN ('sync_restau_grace_period', 'sync_restau_refund_rate');");
									if( (!empty($check[0]->option_value)) && (!empty($check[1]->option_value))) { ?>
										<input class="cancel_reservation" type="button" value="Cancel Reservation" id="">
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

	<div class="modall sync-transform fade sync-modal-reservation-info" id="cancel_success" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
		<div class="modal-dialog" role="document" data-keyboard="false">
			<div class="modal-content">
				<div class="modal-bodyy">
					<div class="cancel_content">
						<div class="cancel_body">
							<h1>Cancellation Request Sent.</h1>
							<div class="sub_content">
								<span class="content">Please allow 1-2 business days to review and assist you with your request.</span>
							</div>
							<br>
							<div class="button_close" style="text-align:center;">
								<input class="close_modal restau" type="button" value="Close">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php 

	if (!empty(sanitize_text_field($_POST['full_name'])) && !empty(sanitize_text_field($_POST['email_add'])) && !empty(sanitize_text_field($_POST['phone_no'])) && 
		!empty(sanitize_text_field($_POST['branch'])) && !empty(sanitize_text_field($_POST['guest_no'])) && !empty(sanitize_text_field($_POST['table_no'])) ) {

		$branch = sanitize_text_field($_POST['branch']);
		$table_qty = intval($_POST['table_no']);
		$guest_qty = intval($_POST['guest_no']);
		$table_count = $table_qty;
		$date_pick = sanitize_text_field($_POST['picked_date']);
	
		include('food-menu.php');
		include('restau-table.php');
		include('payment.php'); 
		include('thank-you.php'); 
		include('payment_authorize.php');
	}
}
?>

<script>
	jQuery('#show_cancel .close').click( function () {
		if (jQuery('#reservation_info_restau').hasClass('show_modal')) {
			jQuery('#reservation_info_restau').removeClass('show_modal');
			jQuery('#reservation_info_restau').addClass('hide_modal');
		} else {
			jQuery('#reservation_info_restau').addClass('show_modal');
		}
	});

	jQuery('#reservation_info_restau .close').click( function () {
		jQuery('#reservation_info_restau').removeClass('show_modal');
		jQuery('#reservation_info_restau').removeClass('hide_modal');
	});
	
	jQuery('#cancel_success .close_modal.restau').click( function () {
		location.reload();
	});

	jQuery(".select_opt .reserve_table").click( function () {
		jQuery(".sync_form_wrapper.restau_wrapper").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});
	
	jQuery(".select_opt .check_reservation").click( function () {
		jQuery(".sync_form_wrapper_set.sync_check_reservation").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});

	jQuery(".restau_wrapper .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper.restau_wrapper').hide();
	});
	
	jQuery(".sync_check_reservation .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper_set.sync_check_reservation').hide();
	});

	jQuery("#reserved_table .reserve-table").click( function (evt) {
		var pref_date = jQuery('#reserved_table .docs-date').val();
		var timeslot = jQuery('#reserved_table .preferred-timeslot').val();
		var date = new Date();
		var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        var am_pm = date.getHours() >= 12 ? "pm" : "am";
        hours = hours < 10 ? "0" + hours : hours;
        var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		var cur_time = hours + ":" + minutes + " " + am_pm; 
		
		var cur_date = String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getDate()).padStart(2, '0') + '/' + date.getFullYear();
		var pref_timeslot = timeslot.split('-');
		var from = pref_timeslot[0];
		var to = pref_timeslot[1];

		if (pref_date == "") {
			evt.preventDefault();
			jQuery('#reserved_table .error-picked-date.active').remove();
			jQuery('#reserved_table .docs-datepicker-container').append('<div class="error error-picked-date active"> This field is required. </div>');
		} else {
			jQuery('#reserved_table .error-picked-date.active').remove();
		}

		if (timeslot == "") {
			evt.preventDefault();
			jQuery('#reserved_table .error-timeslot.active').remove();
			jQuery('#reserved_table .timeslot').append('<div class="error error-timeslot active"> This field is required. </div>');
		} else {
			jQuery('#reserved_table .error-timeslot.active').remove();
		}

		if ((cur_date == pref_date) && timeslot != "" ) {
			if ( (from <= cur_time) || (to <= cur_time) ) {
				evt.preventDefault();
				jQuery('#reserved_table .error-timeslot.active').remove();
				jQuery('#reserved_table .timeslot').append('<div class="error error-timeslot active"> Selected timeslot is already past the current time. </div>');
			} else {
				jQuery('#reserved_table .error-timeslot.active').remove();
			}
		}
	});

</script>

