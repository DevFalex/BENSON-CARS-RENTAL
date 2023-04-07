<?php
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $sync_hotel_privacy, $sync_hotel_terms, $sync_paypal_enable;
session_start();
$_SESSION['currency'] = easyncCurrency();

$option_table = $wpdb->prefix . 'sync_options';
$captcha = $wpdb->get_results("SELECT option_value from $option_table where option_name = 'sync_captcha_key';");
$secret = $wpdb->get_results("SELECT option_value from $option_table where option_name = 'sync_captcha_key_secret';");

$key = $captcha[0]->option_value;
$secret_key = $secret[0]->option_value;
$_SESSION['secret_key'] = $secret_key;

?>

<div class="modall sync-transform fade sync-modal-personal-info" id="customer_info" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">
			<div class="customer-info">
					<div class="row-1 first-row">
						<div class="sync_components">
							<h1>Booking Details</h1>
							<div class="room-profile">
								<img src="" alt="room">
								<h2>Deluxe Queen</h2>
								<div class="amenities"></div>
							</div>
							<div class="room-cost">
								<div class="date">
									<span>Dates</span>
									<p><span><?php echo esc_html($date_arrive);?></span> - <span><?php echo esc_html($date_departure);?></span></p>
									<span><i class="fa fa-moon-o fa-1x"></i><span> <?php echo esc_html($night_number);?> </span>night(s) only</span>
								</div>
								<div class="guest">
									<span>Guest(s)</span>
									<p><span><?php echo esc_html($number_guest);?></span> Guest(s)</p>
								</div>
								<div class="rooms">
									<span>Room(s)</span>
									<p><span><?php echo esc_html($number_room);?></span> Room(s)</p>
								</div>
								<div class="beds">
									<span>Bed(s)</span>
									<p><span><?php echo esc_html($number_bed);?></span> Bed(s)</p>
								</div>
								<div class="pricing-details">
									<span>Pricing Details</span>
									<p>
										<!-- <span class="sync_currency_symbol"><?php echo easyncCurrency().' ';?></span> -->
										<span class="sync_price_money_format">123</span>
									</p>
								</div>
							</div>
						</div>
					</div>	

					<div class="row-1 second-row">
						<form id="continue_payment" action="" method="post">
							<?php wp_nonce_field('easync_hotel_to_pay', 'easync_hotel_nonce'); ?>
							<input type="hidden" name="hotel_arrival_date" value="<?php echo esc_html($date_arrive);?>">
							<input type="hidden" name="hotel_departure_date" value="<?php echo esc_html($date_departure);?>">
							<input type="hidden" name="hotel_night_number" value="<?php echo esc_html($night_number);?>">
							<input type="hidden" name="hotel_guest_number" value="<?php echo esc_html($number_guest);?>">
							<input type="hidden" name="hotel_number_room" value="<?php echo esc_html($number_room);?>">
							<!-- <input type="hidden" name="room_id" value=""> -->
							<div class="sync_components personal-holder personal-holder-hotel">
								<h1>Your Information</h1>

								<div class="personal-info firstname">
									<label>First Name *</label></br>
									<input type="text" id="firstname" name="firstname" placeholder="e.g. John" >
								</div>

								<div class="personal-info lastname">
									<label>Last Name *</label></br>
									<input type="text" id="lastname" name="lastname"  placeholder="e.g. Smith">
								</div>

								<div class="personal-info phone">
									<label>Reachable Mobile Number *</label></br>
									<input type="text" id="phone" name="phone" placeholder="e.g. 09971234571" title="Must contain 11 digits">
								</div>
								<div class="personal-info email-address">
									<label>Email Address *</label></br>
									<input type="email" id="email-address" name="email"  placeholder="e.g. email@example.com">
								</div>

								<div class="special-request">
									<h4>Special request (optional)</h4>
									<div class="special-request-holder">
									</div>
								</div>

								<div class="special-request-others">
									<label style="display: none">Please write in English or in hotel's local language</label></br>
									
								</div>
							</div>
							<div class="sync_components cancellation">
								<h1>Cancellation Policy</h1>
								<?php 

									$table_cancellation = $wpdb->prefix . "sync_options";
									$table = $wpdb->prefix . "sync_hotel_entries";

									$cancellation = $wpdb->get_results("select option_value from $table_cancellation where option_name = 'sync_hotel_page_cancellation'");
									$check_reference = $wpdb->get_results("SELECT reference_number from $table;");

									for ($i=0; $i < count($check_reference); $i++) {
										$check_reference[$i] = $check_reference[$i]->reference_number;
									}
	
									rsort($check_reference);
	
									$check_reference = $check_reference[0] == '' ? 'HTL0000000000000' : $check_reference[0];
									$check_reference++;
									// echo $cancellation[0]->option_value;

									if ($cancellation[0]->option_value == 'default' || $cancellation[0]->option_value == '') { ?>
										<div class="cancel-msg"><span>This reservation is non-refundable.</span></div>
									<?php
									}
									else { ?>
										<div class="cancel-link" style="padding:0px 9px;"><span><a target="_blank" href="<?php echo $cancellation[0]->option_value; ?>"> View Cancellation Policy. </a></span></div>
									<?php	
									}
								?>
								
							</div>

							<div class="sync_components footer-holder-hotel free">
								<h1>Pricing</h1>
								<div class="book-summary-subtotal">
									<p><strong style="font-weight: normal; color: #999b99;">Deluxe Queen Room</strong> (<?php echo esc_html($night_number);?> night(s) x<?php echo esc_html($night_number);?> room(s))
										<span> 123</span>
									</p>
								</div>
								<div class="book-summary-total">
									<p>Total
									<span class="total_noDiscount"> 1,780.00</span>
									</p>	
									
								</div>
								<div class="book-summary-payment">
									<p>By clicking this button, you acknowledge that you have read and agreed to the <a target="_blank" href="<?php echo esc_url($sync_hotel_terms); ?>">Terms and Conditions</a> and <a target="_blank" href="<?php echo esc_url($sync_hotel_privacy); ?>"> Privacy Policy</a></p>
									<div class="payment">
										<input type="hidden" name="sync_currency_code" value="<?php echo esc_html(easyncCurrency()); ?>">
										<input type="hidden" class="amount_to_pay" name="amount_to_pay" value="">
										<input type="hidden" name="reference_number" id="reference_number" value="<?php echo $check_reference; ?>">
										<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

										<button type="submit" class="continue-payment" >Continue to Payment</button>
										
									</div>
								</div>
							</div>
				    	</form>
				    </div>
			</div>
      </div>
    </div>
  </div>
</div>

<script>
	jQuery(document).ready(function() {
		<?php  
			global $wpdb;
			$option = $wpdb->prefix . 'sync_options';
			$switch = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_captcha_switch';");
			$switch_val = $switch[0]->option_value;
		?>

		var switch_val = "<?php echo $switch_val; ?>";
		
		if(switch_val == "on") { 
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo $key; ?>', {action: 'homepage'})
				.then(function(token) {
					document.getElementById('g-recaptcha-response').value=token;
				});
			});
		}

	});
</script>

