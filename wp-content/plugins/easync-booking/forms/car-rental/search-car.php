
<?php 
if( ! defined( 'ABSPATH' ) ) exit;
if(!is_admin()) {
global $wpdb, $post, $errors_config_car;
$table = $wpdb->prefix . 'sync_options';
$qry = $wpdb->get_results( "SELECT option_value FROM $table where option_name IN ('sync_authorize_switch', 'sync_paypal_switch' ,'sync_stripe_switch', 'sync_offline_switch');");

if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off' && $qry[3]->option_value=='off') && is_user_logged_in() == true) {
	?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Hotel Booking or click "Advance" and enter needed information"</span><ul><?php
	?><li>Please select and enable a payment gateway.</li></ul><?php
	exit;
}
if(!empty($errors_config_car) && is_user_logged_in()==true) {
	?><h3>Please configure the following on eaSYNC Booking settings:</h3><span>Go to your backend and find "eaSYNC Booking" on the sidebar and click "Settings" then click the "General" and click "Car Rental" or click "Advance" and enter needed information"</span><ul><?php
	
	foreach ($errors_config_car as $error) {
		?>
		<li><?php echo $error; ?></li>
		<?php
	}
	if ($qry && ($qry[0]->option_value=='off' && $qry[1]->option_value=='off' && $qry[2]->option_value=='off' && $qry[3]->option_value=='off') && is_user_logged_in() == true) {
		?><li>Please select and enable a payment gateway.</li><?php
	}
	exit;
	?></ul><?php
}elseif(!empty($errors_config_car) && is_user_logged_in()==false){
	?><h3>This module is currently under maintenance, check back soon!</h3><?php
	exit;
}
$_SESSION['sync_form'] = 'car';
$_SESSION['sync_page_redirect'] = $post->post_name;

$table_name = $wpdb->prefix . "sync_options";
$entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_default_time'));
?>

<div class="sync_form_wrapper car-rental-wrapper" style="display: none;">
	<div class="go_back">
		<span class="back_text"><i class="fa fa-arrow-left"></i>  Back</span>
	</div>
	<div class="sync_container pick-date">
		<div class="sync_options_currency">
		</div>
		<div class="sync_title">
			<h1>Rental Services</h1>
			<?php
			if (!empty($_SESSION['message'])) {
			    echo '<p class="message"> '.esc_html($_SESSION['message']).'</p>';
			    unset($_SESSION['message']);
			}
			?>
		</div>
		<div class="sync_components">
			<form id="search_car_rental" action="" method="post">
				<div class="sync_components-container">
					<div class="sync-holder-field">
						<div class="holder holder-calendar">
							<label>Pickup Date <span class="sync_asterisk">*</span></label>
							<input readonly id="datepicker_car_rental_pick" required value="<?php echo isset($_POST['date_pick']) ? esc_html($_POST['date_pick']) : '' ?>" data-toggle="car-datepicker" name="date_pick"><i class="far fa-calendar-alt fa-1x calendar"></i>
						</div>
						<div style="display: none;" data-toggle="car-datepicker"></div>
						<div class="holder time_field">
							<label>Pickup Time <span class="sync_asterisk" style="visibility: hidden;">*</span></label>
							<?php
							if ( ! $entries ) {
								?>
								<input id="rental_pick_time" type="text" placeholder="Select Time" value="<?php echo isset($_POST['pick_time']) ? esc_html($_POST['pick_time']) : '' ?>" name="pick_time">
								<?php
							}else{
								?>
								<input id="rental_pick_time" type="text" placeholder="Select Time" value="<?php echo isset($_POST['pick_time']) ? esc_html($_POST['pick_time']) : explode("-", $entries[0]->option_value, 2)[0] ?>" name="pick_time">
								<?php
							}
							?>
							<i class="fas fa-clock fa-1x"></i>
						</div>
						<div class="holder holder-calendar return">
							<label>Return Date <span class="sync_asterisk">*</span></label>
							<input id="datepicker_car_rental_return" required value="<?php echo isset($_POST['date_return']) ? esc_html($_POST['date_return']) : '' ?>" data-toggle="car-min-datepicker" name="date_return"><i class="far fa-calendar-alt fa-1x calendar"></i>
						</div>
						<div style="display: none;" data-toggle="car-min-datepicker"></div>
						<div class="holder">
							<label>Return Time<span class="sync_asterisk" style="visibility: hidden;">*</span></label>
							<?php
							if ( ! $entries ) {
								?>
								<input id="rental_return_time" type="text" placeholder="Select Time" class="tooltip-error1" title="(Return time) must be less than of (Pick up time)" value="<?php echo isset($_POST['return_time']) ? esc_html($_POST['return_time']) : '' ?>" name="return_time">
								<?php
							}else{
								?>
								<input id="rental_return_time" type="text" placeholder="Select Time" class="tooltip-error1" title="(Return time) must be less than of (Pick up time)" value="<?php echo isset($_POST['return_time']) ? esc_html($_POST['return_time']) : explode("-", $entries[0]->option_value, 2)[1]?>" name="return_time">
								<?php
							}
							?>
							<i class="fas fa-clock fa-1x"></i>
						</div>
						<div class="holder">
							<label>Pickup Location<span class="sync_asterisk" style="visibility: hidden;">*</span></label>
							<select class="rental_pick_location js-states form-control" name="pick_location">
							  	<?php
			                        $table_name = $wpdb->prefix . "sync_options";
			                        $entries = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name = 'sync_car_pickup' ORDER BY id DESC" );
			                        if ( ! $entries ) {
			                            $wpdb->print_error(); 
			                        }else {
			                            foreach ( $entries as $key => $value) {
			                            	
			                            	if(isset($_POST['pick_location']) && $_POST['pick_location']==$value->option_value) {
			                            		?><option selected value="<?php echo esc_html($value->option_value);?>"><?php echo esc_html(ucfirst($value->option_value));?></option><?php
			                            	} else {
			                            		?><option value="<?php echo esc_html($value->option_value);?>"><?php echo esc_html(ucfirst($value->option_value));?></option><?php
			                            	}
			                            }
			                        }
				                ?>
							</select>
						</div>
						<div class="holder">
							<label>Vehicle Type<span class="sync_asterisk" style="visibility: hidden;">*</span></label>
							<select class="rental_vehicle_type js-states form-control" name="vehicle_type">
								<option value="all">All</option>
								<?php
									$args = array(
										'orderby' => 'post_date',
										'order' => 'DESC',
										'post_type' => 'easync_car_rental',
										'post_status' => 'publish',
										'posts_per_page' => -1,
										'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
									);

									query_posts($args);
									$the_query = new WP_Query( $args );
									$meta_unique =  array();
									while ($the_query->have_posts()) : $the_query->the_post();
										$temp_id = get_the_ID();
							            $querystr = "
							                SELECT *
							                FROM $wpdb->postmeta 
							                WHERE meta_key LIKE 'easync_car' AND post_id = $temp_id
							                ORDER BY meta_id DESC
							            ";
							            
							            $meta_override = $wpdb->get_results( $querystr, OBJECT );
							            
							            if ( ! $meta_override ) {
							                $wpdb->print_error(); 
							            }else {
							            	foreach ($meta_override as $key => $value) {
							            		$meta = get_post_meta( get_the_ID(), $value->meta_key, true );
							            		array_push($meta_unique, $meta['type']);
							            	}
							            }
							        endwhile;
							        wp_reset_query();
							        $meta_unique = array_unique($meta_unique); 

							        foreach ($meta_unique as $key => $value) {
						        		if(isset($_POST['vehicle_type']) && $_POST['vehicle_type']==$value) {
		                            		?><option selected value="<?php echo esc_html($value);?>"><?php echo esc_html(ucfirst($value));?></option><?php
		                            	}else{
		                            		?><option value="<?php echo esc_html($value); ?>"><?php echo esc_html(ucfirst($value));?></option><?php
		                            	}
							        }
								?>	
							</select>
						</div>
					</div>
					<div class="holder holder-check-availability">
						<input type="hidden" name="with_or_out_driver" class="with_or_out_driver" value="<?php echo isset($_POST['with_or_out_driver']) ? esc_html($_POST['with_or_out_driver']) : 'self-driven' ?>">
						<input type="submit" value="Check Availability" name="check_car" class="find-car">
						<div class="holder options">
							<label style="visibility: hidden;">Self-Driven</label>
							<div class="car-driver" style="visibility:hidden;">
								<input type="checkbox" name="self_driven" value="self-driven" class="rent-driver self-driver">
								<?php
									if(isset($_POST['with_or_out_driver'])) {
										if($_POST['with_or_out_driver']=='with driver') {
											?><label class="active">Self-driven</label><?php
										}else{
											?><label class="active">Self-driven</label><?php
										}
									}else{
										?><label class="active">Self-driven</label><?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="sync_form_wrapper_set sync_user_option">
	<div class="head_label">
		<h1>Car Rentals</h1>
	</div>
	<div class="select_opt">
		<input type="button" value="Rent a Car" name="rent_car" class="rent_car">
		<input type="button" value="Check Rental" name="check_rental" class="check_rental">  
	</div>
</div>

<div class="sync_form_wrapper_set sync_check_rental" style="display:none;">
	<div class="go_back">
		<span class="back_text"><i class="fa fa-arrow-left"></i> Back</span>
	</div>
	<div class="ref_head">
		<h1>Search Rentals</h1>
	</div>
	<div class="get_reference">
		<input type="text" class="ref_number" name="ref_number" placeholder="Enter Reference Number" >
		<span class="search_ref_car"> Search </span>
	</div>
</div>

<div class="modall sync-transform fade sync-modal-rental-info" id="rental_info" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-md" role="document" data-keyboard="false">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">
		    <div class="rental-details">
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
				<div class="rental_details">
					<div class="rental_labels">

					</div>
					<div class="space">

					</div>
					<div class="rental_data">

					</div>
				</div>
				<br>
				<div class="cancel_section" style="text-align:center;">
					<?php $check = $wpdb->get_results("SELECT * from $table_name  where option_name IN ('sync_car_grace_period', 'sync_car_refund_rate');");
						if( (!empty($check[0]->option_value)) && (!empty($check[1]->option_value))) { ?>
							<input class="cancel_rental" type="button" value="Cancel Rental" id="">
					<?php } ?>
				</div>
				<br>
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<div class="modall sync-transform fade sync-modal-rental-notFound" id="rental_notFound" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
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

<div class="modall sync-transform fade sync-modal-booking-info" id="show_cancel_car" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
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
						<input class="confirm_cancel_car" type="button" value="Confirm" id="">
					</div>
				</div>
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<div class="modall sync-transform fade sync-modal-booking-info" id="cancel_success_car" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
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
	$converPickTime = date('h:i a', strtotime($_POST['pick_time']));
	if(substr( $converPickTime, 0, 1 ) == 0) {
		$converPickTime  = substr( $converPickTime, 1 );
	}
	$converReturnTime = date('h:i a', strtotime($_POST['return_time']));
	if(substr( $converReturnTime, 0, 1 ) == 0) {
		$converReturnTime  = substr( $converReturnTime, 1 );
	}
	if(!empty(sanitize_text_field($_POST['date_pick'])) && !empty(sanitize_text_field($converPickTime)) && !empty(sanitize_text_field($_POST['date_return'])) && !empty(sanitize_text_field($converReturnTime)) && !empty(sanitize_text_field($_POST['pick_location'])) && !empty(sanitize_text_field($_POST['vehicle_type']))) {

		$pick_time   = sanitize_text_field($converPickTime);
		$pick_time_h = explode(":", $pick_time, 2);
		$pick_am_pm  = substr($pick_time, -2);
		$return_time   = sanitize_text_field($converReturnTime);
		$return_time_h = explode(":", $return_time, 2);
		$return_am_pm  = substr($return_time , -2);

		if( empty($pick_time) ) {
			echo "
				<script type=\"text/javascript\" async>
					$('.tooltip-error1').tooltipster({
						animation: 'fade',
						delay: 200,
						theme: 'tooltipster-punk',
						trigger: 'click'
					});
					$('#rental_return_time').click();					
				</script>";
		} else {
			$date_pick          = sanitize_text_field($_POST['date_pick']); 
		    $pick_time          = sanitize_text_field($converPickTime);
		    $date_return        = sanitize_text_field($_POST['date_return']);
		    $return_time        = sanitize_text_field($converReturnTime);
		    $pick_location      = sanitize_text_field($_POST['pick_location']);
		    $vehicle_type       = sanitize_text_field($_POST['vehicle_type']);
		    $self_driven        = sanitize_text_field($_POST['self_driven']);
		    $with_or_out_driver = 'with driver'; //sanitize_text_field($_POST['with_or_out_driver']);

		    $date_start = new DateTime($date_pick);
	    	$date_end   = new DateTime($date_return);
			$number_days = $date_end->diff($date_start)->format("%a");

			include('search-car-list.php');		
			include('personal-info.php');
			include('payment.php');	
			include('thank-you.php');
			include('payment_authorize.php');

		}
	} 
}
?>

<script>
	jQuery(".select_opt .rent_car").click( function () {
		jQuery(".sync_form_wrapper.car-rental-wrapper").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});
	
	jQuery(".select_opt .check_rental").click( function () {
		jQuery(".sync_form_wrapper_set.sync_check_rental").show();
		jQuery(".sync_form_wrapper_set.sync_user_option").hide();
	});

	jQuery(".car-rental-wrapper .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper.car-rental-wrapper').hide();
	});
	
	jQuery(".sync_check_rental .go_back").click( function () {
		jQuery('.sync_form_wrapper_set.sync_user_option').show();
		jQuery('.sync_form_wrapper_set.sync_check_rental').hide();
	});

	jQuery("#cancel_success_car .close_modal").click( function () {
		jQuery('body').loading('stop');
		location.reload();
	});

	jQuery("#cancel_success_car .close").click( function () {
		jQuery('body').loading('stop');
		location.reload();
	});

	jQuery(document).on('click', '.find-car', function (e) {
		var pickup_time = jQuery('#rental_pick_time').val();
		var pickup_date = jQuery('#datepicker_car_rental_pick').val();
		var return_date = jQuery('#search_car_rental .holder #datepicker_car_rental_return').val();
		var today = new Date();
		var hour = String(today.getHours());
		var minute = String(today.getMinutes());
		var minutes = "";
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();
		current_date = mm + '/' + dd + '/' + yyyy;

		if (minute < '10') {
			minutes = ('0' + minute).slice(-2);
		} else {
			minutes = minute;
		}

		current_hour = ('0' + hour).slice(-2);
		current = current_hour + ':' + minutes;
		
		if (pickup_date == current_date ) {
			if (current > pickup_time) {
				e.preventDefault();

				jQuery('.error-name.error-time.active').remove();
				jQuery('#search_car_rental .holder.time_field').append('<div class="error error-name error-time active">Time set is already past the current time.</div>'); 
				jQuery('html, body').animate({scrollTop: jQuery('#search_car_rental').offset().top}, 200);
				jQuery('.car-search-result-container').hide();
			} 
		} else {
			jQuery('.error-name.error-time.active').remove();
		}

		if (return_date == "") {
			e.preventDefault();
			jQuery('#search_car_rental .holder.holder-calendar.return').append('<div class="error error-name error-time active">This field is required.</div>');
		}

	});
</script>