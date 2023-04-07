<?php
if ( ! defined( 'ABSPATH' ) ) exit;
session_start();
global $wpdb, $sync_car_privacy, $sync_car_terms, $sync_paypal_enable;

$options_table   = $wpdb->prefix . "sync_options";
$table_entries   = $wpdb->prefix . "sync_rent_car_entries";
$driver_require  = $wpdb->get_results("SELECT option_value FROM $options_table WHERE option_name = 'sync_driver_switch';");

$is_require_d = $driver_require[0]->option_value;


$_SESSION['publish'] = $publishable_key;
$_SESSION['secret'] = $secret_key;
$_SESSION['currency'] = easyncCurrency();

?>
<div class="modall sync-transform fade sync-modal-personal-info" id="car_customer_info" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">

			<div class="customer-info car-customer-info">
					<div class="row-1 first-row">
						<div class="sync_components">
							<div class="car-profile">
								<img src="" alt="car">
								<div class="car-name">
									<h2>Dodge Challenger</h2>
									<span class="type">Type: sedan</span>
									</br>
									<span class="model">2018 model</span>
								</div>
							</div>
							<div class="car-cost">
								<div class="date">
									<span>Rental Dates</span>
									<p><span><?php echo esc_html($date_pick) ;?></span> - <span><?php echo esc_html($date_return);?></span></p>
									<input type="hidden" class="rent-car-day" value="<?php echo esc_html($number_days);?>">
								</div>
								<div class="pickup">
									<span>Pickup Location</span>
									<p><?php echo esc_html(ucfirst($pick_location));?></p>
								</div>
								<div class="pricing-details">
									<span>Pricing Details</span>
									<p><span class="sync_price_money_format">123</span></p>
								</div>
							</div>
						</div>
					</div>	

					<div class="row-1 second-row">
						<form id="car_continue_payment" action="" method="post" enctype="multipart/form-data">
							<?php wp_nonce_field('easync_car_to_pay', 'easync_car_nonce'); ?>
							<input type="hidden" name="car_pick_date" value="<?php echo esc_html($date_pick);?>">
							<input type="hidden" name="car_pick_time" value="<?php echo esc_html($pick_time);?>">
							<input type="hidden" name="car_pick_location" value="<?php echo esc_html($pick_location);?>">
							<input type="hidden" name="car_return_date" value="<?php echo esc_html($date_return);?>">
							<input type="hidden" name="car_return_time" value="<?php echo esc_html($return_time);?>">
							<input type="hidden" name="car_number_day" value="<?php echo esc_html($number_days);?>">
							<input type="hidden" name="with_or_out_driver" value="<?php echo esc_html($with_or_out_driver);?>">
							<div class="sync_components personal-holder personal-holder-car">
								<h1>Your Information</h1>

								<div class="personal-info firstname">
									<label>First Name</label><span class="sync_asterisk">*</span></br>
									<input type="text" id="firstname" name="firstname" placeholder="e.g. John" >
								</div>

								<div class="personal-info lastname">
									<label>Last Name</label><span class="sync_asterisk">*</span></br>
									<input type="text" id="lastname" name="lastname"  placeholder="e.g. Smith">
								</div>

								<div class="personal-info phone">
									<label>Reachable Mobile Number</label><span class="sync_asterisk">*</span></br>
									<input type="text" id="phone" name="phone"  placeholder="e.g. 0997123457" ><span class="reachable"></span>
								</div>
								<div class="personal-info email-address">
									<label>Email Address</label><span class="sync_asterisk">*</span></br>
									<input type="email" name="email"  placeholder="e.g. email@example.com">
								</div>
								<div class="special-request">
									<h4>Special request (optional)</h4>
									<div class="special-request-holder">
									</div>
								</div>
								<div class="special-request-others">
									<label style="display: none">Please write in English or in establishment's local language</label></br>
								</div>
							</div>

							<?php 
								if ($is_require_d == 'on') { ?>
									<div class="sync_components sync_with_driver_container ">
										<h1>Driver's Information</h1>

										<div class="personal-info driver-name">
											<label>Name</label><span class="sync_asterisk">*</span></br>
											<input type="text" name="driver_name" placeholder="Doe, John" >
										</div>

										<div class="personal-info driver-phone">
											<label>Reachable Mobile Number</label><span class="sync_asterisk">*</span></br>
											<input type="number" name="driver_phone"  placeholder="e.g. 0997123457"><span class="reachable"></span>
										</div>

										<label for="file">Take a photo of your driver's license front and back.</label> 
										
										<div id="filediv1"><input name="file1" type="file" id="file1" accept="image/png, image/jpg, image/jpeg" class="sync_file" /></div>
										<div id="filediv2"><input name="file2" type="file" id="file2" accept="image/png, image/jpg, image/jpeg" class="sync_file" /></div>
										<label for="file"><strong>Note: </strong>Accepted Images: JPEG, JPG, PNG)</label> 
									</div>
								<?php }
							?>
							<div class="sync_components cancellation">
								<h1>Cancellation Policy</h1>
								<?php 

									$table_cancellation = $wpdb->prefix . "sync_options";
									$table = $wpdb->prefix . "sync_rent_car_entries";
									$cancellation = $wpdb->get_results("select option_value from $table_cancellation where option_name = 'sync_car_page_cancellation'");
									$check_reference = $wpdb->get_results("SELECT reference_number from $table;");
									// echo $cancellation[0]->option_value;

									for ($i=0; $i < count($check_reference); $i++) {
										$check_reference[$i] = $check_reference[$i]->reference_number;
									}
	
									rsort($check_reference);
	
									$check_reference = $check_reference[0] == '' ? 'CAR0000000000000' : $check_reference[0];
									$check_reference++;

									if ($cancellation[0]->option_value == 'default' || $cancellation[0]->option_value == '') { ?>
										<div class="cancel-msg"><span>This reservation is non-refundable.</span></div>
									<?php
									}
									else { ?>
										<div class="cancel-link" style="padding:0px 9px;"><span><a target="_blank" href="<?php echo $cancellation[0]->option_value; ?>"> Click Here to view Cancellation Policy. </a></span></div>
									<?php	
									}
								?>
							</div>
							<div class="sync_components personal-holder-car free">
								<h1>Pricing</h1>
								<div class="book-summary-subtotal">
									<p><strong style="font-weight: normal; color: #999b99;">Dodge Challenger</strong> (<?php echo esc_html($number_days); echo (($number_days>1)? ' days': ' day')?>)
										<span> 123</span>
									</p>
								</div>
								<div class="book-summary-total">
									<p>Total
									<span class="final_noDiscount_car"> 1,780.00</span>
									</p>
								</div>
								<div class="book-summary-payment">
									<p>By clicking this button, you acknowledge that you have read and agreed to the <a target="_blank" href="<?php echo esc_url($sync_car_terms); ?>">Terms and Conditions</a> and <a target="_blank" href="<?php echo esc_url($sync_car_privacy); ?>"> Privacy Policy</a></p>
									<div class="payment">
										<input type="hidden" name="sync_currency_code" value="<?php echo esc_html(easyncCurrency()); ?>">
										<input type="hidden" class="amount_to_pay_car" name="amount_to_pay_car" value="">
										<input type="hidden" class="car_post_id" name="car_post_id" value="">
										<input type="hidden" name="reference_number" id="reference_number" value="<?php echo $check_reference; ?>">
										<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
										<input type="hidden" class="is_required" name="is_required" value="<?php echo $is_require_d; ?>">

										<button type="submit" class="car-continue-payment" >Continue to Payment</button>
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
