<?php
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $sync_restau_privacy, $sync_restau_terms, $sync_paypal_enable; 
session_start();
$table_entries = $wpdb->prefix . "sync_restau_entries";

$_SESSION['publish'] = $publishable_key;
$_SESSION['secret'] = $secret_key;
$_SESSION['currency'] = easyncCurrency();
 
?>
<div class="modall sync-transform fade sync-modal-personal-info" id="restau_menu_info" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy">

			<div class="customer-info sync_container_for_price">
				<?php 
				$banner = plugin_dir_url(dirname( __FILE__ )) . '../images/food-banner.jpg';
				$table_name = $wpdb->prefix . "sync_options";
              	$entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC",'sync_restau_banner_image' ) );
             	 if ( ! $entries ) {
                  $wpdb->print_error(); 
              	}else {
              		$banner = wp_get_attachment_url( $entries[0]->option_value );
              	}
				 ?>
					<div class="row-1 first-row sync-food-banner" style="background-image: url('<?php echo esc_url($banner); ?>');">
						<div class="sync_components ">
						</div>
					</div>	
					<div class="row-1 second-row">
						<form id="restau_continue_payment" action="" method="post">
							<?php wp_nonce_field('easync_restau_to_pay', 'easync_restau_nonce'); ?>
							<div class="sync_components easync-menu-list">
								<div class="sync_options_currency">
								</div>
								<div class="container sync-container"><h1>Menu</h1></div>
									<div id="tab" class="container sync-container">	
										<ul  class="nav nav-pills">
											<?php
												$count = 0;
												$args = array(
												    'orderby'    => 'date', 
												    'order'      => 'DSC'
												);
												$category = 'easync_food_category';
												$terms = get_terms($category, $args);
												//$page_link_id = the_field('link_to_page', false, false);
												foreach($terms as $key=> $term) {
													$count++;
													$hover = 'sfHover';
													$active_show = 'active show';
													if ($count!=1) {
														$hover = '';
														$active_show = '';
													}
													?>
													<li class="<?php echo $hover;?>">
										        		<a  href="<?php echo '#'.$count.'a'?>" data-toggle="tab" class="<?php echo $active_show; ?>"><?php echo esc_html($term->name);?></a>
													</li>
													<?php
												}
											?>
										</ul>

										<div class="tab-content clearfix">
											<?php
												$count2 = 0;
												//get_the_title($page_link_id);
												foreach($terms as $key=> $term) {
													$count2++;
													$active = 'active';
													if($count2!=1) $active = '';
													if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
													   $the_query = new WP_Query( array(
														    'post_type'      => 'easync_restau',
														    'orderby'        => 'post_date',
														    'order'          => 'DESC',
														    'post_status'    => 'publish',
															'posts_per_page' => -1,
														    'tax_query'      => array(
														        array (
														            'taxonomy' => $category,
														            'field' => 'slug',
														            'terms' => $term->slug ,
														        )
														    ),
														) );
													   
													   	?>
													   <div class="<?php echo 'tab-pane '.$active;?>" id="<?php echo $count2.'a';?>">
													    	<div class="list">
													    		<?php
													    		 while ( $the_query->have_posts() ) : $the_query->the_post();
													    		 	$meta = get_post_meta( get_the_ID(), 'sync_restau', true );
															   	 	if($meta['avail']== "Yes") {
																		?>
																		<div class="special-request">
																    		<div class="list-row first-row">
																				<p><?php echo $meta['avail']; ?></p>
																    			<input type="checkbox" name="check_dish[]" value="<?php echo esc_html(get_the_ID());?>" class="special-request-field qty-check">
																				<label class=""></label>
																    		</div>
																    		<div class="list-row second-row">
																    			<img style="cursor: pointer;" alt="<?php echo easyncStringLimitWords(get_the_title(),12);?>" src="<?php echo the_post_thumbnail_url('full') ?>">
																    		</div>
																    		<div class="list-row third-row">
																    			<h2><?php echo easyncStringLimitWords(get_the_title(),12);?></h2>
																    			<p><?php echo easyncStringLimitWords(get_the_content(),25);?></p>
																    		</div>
																    		<div class="list-row fourth-row">
																    			<p class="quantity">
																    				<span>Qty </span><input id="sync-item-qty" type="number" name="qty[]" min="1" value="1">
																    			</p>
    																			<p>
    																				<span class="sync_currency_symbol"><?php echo esc_html(easyncCurrency()).' '; ?></span>
    																				<span class="sync_price_money_format">
    																				<?php echo number_format(easyncPrice($meta['price']),2); ?>
    																				</span>
    																			</p>
																    			<p>
																    			Sub. 
																    				<span class="sync_price_money_format">
																    					<?php 
																						//echo number_format(easyncPrice($meta['price']),2);
																						?>
																						0.00
																    				</span>
																    			</p>
																    		</div>
																		</div>
																		<?php
																	}
															   	 endwhile;
															   	 wp_reset_query();
													    		?>
													    	</div>
													    </div>
													 <?php  
													}
												}
											?>
										</div>
								   </div>
								   <br>

								   <?php
										$option = $wpdb->prefix . "sync_options";
										$table = $wpdb->prefix . "sync_restau_entries";

										$check_option = $wpdb->get_results("SELECT option_value from $option where option_name = 'sync_switch_restau_coupon';");
										$check_reference = $wpdb->get_results("SELECT reference_number from $table;");

										for ($i=0; $i < count($check_reference); $i++) {
											$check_reference[$i] = $check_reference[$i]->reference_number;
										}

										rsort($check_reference);

										$check_reference = $check_reference[0] == '' ? 'RES0000000000000' : $check_reference[0];
										$check_reference++;

									?>

								<div class="restau_free">
									<div class="book-summary-total">
										<p>Total 
											<span class="sync_price_money_format"> 0</span><span class="sync_currency_symbol"><?php echo esc_html(easyncCurrency()).' '; ?></span>
										</p>		
									</div>
									<div class="book-summary-payment">
										<div class="book-summary-footer">
											<p>By clicking this button, you acknowledge that you have read and agreed to the <a target="_blank" href="<?php echo esc_url($sync_restau_terms); ?>">Terms and Conditions</a> and <a target="_blank" href="<?php echo esc_url($sync_restau_privacy); ?>"> Privacy Policy</a></p>
											<div class="payment">
												<input type="hidden" class= "sync_currency_code" name="sync_currency_code" value="<?php echo esc_html(easyncCurrency()); ?>">
												<input type="hidden" name="amount_to_pay_restau" id="amount_to_pay_restau" value="">
												<input type="hidden" class= "sync_currency_code" name="sync_currency_code" value="<?php echo esc_html(easyncCurrency()); ?>">
												<input type="hidden" name="reference_number" id="reference_number" value="<?php echo $check_reference; ?>">
												<input type="hidden" name="amount_to_pay_restau" id="amount_to_pay_restau" value="">
												<input type="hidden" name="table_id" id="table_id" value="">
												<input type="hidden" class="c_name" name="c_name" value="<?php echo $_POST['full_name'];?>">
												<input type="hidden" class="email_add" name="email_add" value="<?php echo $_POST['email_add'];?>">
												<input type="hidden" class="phone_no" name ="phone_no" value="<?php echo $_POST['phone_no'];?>">
												<input type="hidden" class="branch" name="branch" value="<?php echo $_POST['branch'];?>">
												<input type="hidden" class="guest_no" name="guest_no" value="<?php echo $_POST['guest_no'];?>">
												<input type="hidden" class="table_no" name="table_no" value="<?php echo $_POST['table_no'];?>">
												<input type="hidden" class="picked_date" name="picked_date" value="<?php echo $_POST['picked_date'];?>">
												<input type="hidden" class="timeslot" name="timeslot" value="<?php echo $_POST['timeslot'];?>">
												<input type="hidden" class="reserved_items" name="reserved_items" value="">
												<input type="hidden" class="item_size" name="item_size" value="">
												
												<button type="submit" class="restau-continue-payment" >Continue to Payment</button>
											</div>
										</div>
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

<?php include ('pay.php'); ?>

<div class="modall sync-transform fade sync-modal-personal-info" id="coupon_list_restau" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-sm" role="document" data-keyboard="false">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-targett="#restau_menu_info" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-bodyy" style="background-color: #c4c4c4;">
		    <div class="content_list">
				<?php
					$table_coupon = $wpdb->prefix . "sync_coupons";
					$coupons = $wpdb->get_results("select * from $table_coupon where coupon_type = 'restau_coupon' and coupon_status = 'active'");
					$table_entries = $wpdb->prefix . "sync_restau_entries";
					if (!empty($coupons)) {
						foreach ( $coupons as $key => $value) {
							$used_restau_coupons = $wpdb->get_results("select coupon_id from $table_entries where coupon_id = '$value->id'");
							?>
							<div class="coupon_container">
								<div class="discount_value">
									<h4><span></span><?php echo easyncCurrency(). " " .$value->coupon_value; ?></h4>
									<h4>OFF</h4>
								</div>
								<div class="discount_details">
	
									<p style="font-size: 20px;"><?php echo $value->coupon_title; ?></p>
									<span style="font-size: 14px;"><strong>Code: </strong></span><span class="cpn_code"><?php echo $value->coupon_code; ?></span>
									<p>Save <span></span><?php echo easyncCurrency(). " " .$value->coupon_value; ?> when you pay for your booking/reservation. </p>
									<p style="font-size: 13px;"> 
									<?php echo count($used_restau_coupons); ?> used | <label style="font-size: 14px;">Expiration Date: <?php echo $value->expiration_date; ?></label> </p>
								</div>
								<div class="use_button">
									<p class="btn-use-restau" id="<?php echo $value->coupon_code; ?>"> Use </p>
								</div>
							</div>
							<div class="cpn_note">
								<span class="note_details"> Details: Click the "Use" button or copy code to avail this amazing promo. Catch this deal now! </span>
							</div>
							<?php
						}
					}
					else { ?>
						<div class="no_coupons">
							<div class="notice" style="text-align:center;">
								<h3>No Coupons available at the moment.</h3>
							</div>
						</div>
					<?php
					}
				?> 
			</div>
	   	</div>
      </div>
    </div>
  </div>
</div>

<script>
	jQuery(document).ready(function() {

		jQuery('#pay_method').on('change',function(){
        	var optionText = jQuery("#pay_method option:selected").val();
			var coupon_isset = jQuery("#coupon_setting").val();
			jQuery(".payment_method #pay_method").css("text-align-last", "left");
			jQuery(".payment_method #pay_method").css("text-align", "left");

			if (optionText == "paypal") {
				jQuery("#restau_menu_info form").attr("id", "restau_continue_payment");
				jQuery(".book-summary-payment").show();
				jQuery(".restau-continue-payment").show();
				jQuery(".payment_method_restau p").hide();
				jQuery(".restau-stripe-payment").hide();
				jQuery(".restau-authorize-payment").hide();
				jQuery(".restau-offline-payment").hide();
				if (coupon_isset == 'on') {
					jQuery(".add_coupon_restau").show();
				}
			}
			if (optionText == "offline") {
				jQuery("#restau_menu_info form").attr("id", "submit_reservation");
				jQuery(".book-summary-payment").show();
				jQuery(".restau-offline-payment").show();
				jQuery(".payment_method_restau p").hide();
				jQuery(".restau-stripe-payment").hide();
				jQuery(".restau-authorize-payment").hide();
				jQuery(".restau-continue-payment").hide();
				if (coupon_isset == 'on') {
					jQuery(".add_coupon_restau").show();
				}
			}
			if (optionText == "stripe") {
				jQuery("#restau_menu_info form").attr("id", "restau_continue_payment_stripe");
				jQuery(".book-summary-payment").show();
				jQuery(".restau-continue-payment").hide();
				jQuery(".restau-authorize-payment").hide();
				jQuery(".payment_method_restau p").hide();
				jQuery(".restau-offline-payment").hide();
				jQuery(".restau-stripe-payment").show();
				if (coupon_isset == 'on') {
					jQuery(".add_coupon_restau").show();
				}
			}
			if (optionText == "authorize") {
				jQuery("#restau_menu_info form").attr("id", "restau_continue_payment_authorize");
				jQuery(".book-summary-payment").show();
				jQuery(".restau-continue-payment").hide();
				jQuery(".payment_method_restau p").hide();
				jQuery(".restau-stripe-payment").hide();
				jQuery(".restau-offline-payment").hide();
				jQuery(".restau-authorize-payment").show();
				if (coupon_isset == 'on') {
					jQuery(".add_coupon_restau").show();
				}
			}
    	});

		jQuery("#add_coupon_restau").click(function() {
			jQuery("#coupon_field_restau").css("display", "inline-block");
			jQuery("#view_coupons_restau").show();
			jQuery("#add_coupon").hide();
			jQuery("#add_coupon_restau").hide();
			jQuery("#choice").show();
		});

		jQuery("#cancel_restau").click( function () {
			jQuery("#choice").hide();
			jQuery("#add_coupon_restau").show();
			jQuery("#coupon_field_restau").hide();
			jQuery("#view_coupons_restau").hide();
			jQuery('.alert-danger.error-coupon').remove();
		});

		jQuery("#view_coupons_restau").click( function () {
			jQuery("#coupon_list_restau").modal('show');
			jQuery("#restau_menu_info").modal('hide');
		});

		jQuery(".btn-use-restau").click(function () {
			var code = jQuery(this).attr('id');
			jQuery(".add_coupon_restau #coupon_field_restau").val(code);
			jQuery("#coupon_list_restau").modal('hide');
			jQuery("#restau_menu_info").modal('show');
		});

	});

</script>

<script>

	jQuery(document).ready( function () {
		var occurence = 0;
		var menu = [];
		var temp_arr = [];
		var reservations = [];
		var items = [];
		var item_qty = [];
		var item_size = [];

		jQuery('.fourth-row p:first-child .quantity-nav').css('display', 'none');
		jQuery('.fourth-row p:first-child input').prop('disabled', true);

		jQuery(document).on('click', '#multiple_table', function (evt) {
			evt.preventDefault();
			var amt = jQuery('#restau_continue_reservation .total_amount_restau p .sync_price_money_format').text();

			if ((jQuery('#restau_continue_reservation input[name="check_dish[]"]').prop('checked')) == false) {
				jQuery('#restau_continue_reservation #tab').append('<div class="error error-pick-item active"> Please select at least one item. </div>')
			} else {
				jQuery('.easync-menu-list .total_amount_restau p .sync_price_money_format').text(amt);
				jQuery('.fourth-row p:first-child .quantity-nav').css('display', 'none');
				jQuery('.fourth-row p:first-child input').prop('disabled', true);
				jQuery('.easync-menu-list .special-request-field + label').removeClass('active');
				jQuery('.easync-menu-list .nav-pills li a').removeClass('active show');
				jQuery('.easync-menu-list .nav-pills li.sfHover a').addClass('active show');
				jQuery('.easync-menu-list .tab-content.clearfix .tab-pane').removeClass('active show');
				jQuery('.easync-menu-list .tab-content.clearfix .tab-pane#1a').addClass('active show');

				items = [];
				item_qty = [];

				jQuery('#restau_continue_reservation input[name="check_dish[]"]:checked').each (function () {
					if ( jQuery(this).is(':checked') ) {
						items.push(jQuery(this).val());
					}
				});

				jQuery('#restau_continue_reservation input[name="qty[]"]').each (function () {
					item_qty.push(jQuery(this).val());
				});

				menu = [];
				for (let i = 0; i < items.length; i++) {
					var menu_item = items[i] + " ( QTY " + item_qty[i] + ")";
					menu_item.toString();
					menu.push(menu_item);
					item_size.push(item_qty[i]);
				}
				
				temp_arr = [];
				temp_arr.push( "["+menu+"]" );
				reservations.push(temp_arr);

				if ( (ids.length - 2) > occurence ) {
					occurence++;
					jQuery('.fourth-row p:first-child input').attr('value', '1');
					jQuery('.fourth-row p:first-child input').val('1');
					jQuery('.tab-content.clearfix .fourth-row p:first-child input').attr('value', '1');
					jQuery('.tab-content.clearfix .fourth-row p:first-child input').val('1');
					jQuery('.list-row.fourth-row p:last-child() span').text('0.00');
					jQuery('.easync-menu-list .special-request .list-row.first-row input').prop('checked', false);
				} else {
					jQuery('.fourth-row p:first-child input').attr('value', '1');
					jQuery('.fourth-row p:first-child input').val('1');
					jQuery('.tab-content.clearfix .fourth-row p:first-child input').attr('value', '1');
					jQuery('.tab-content.clearfix .fourth-row p:first-child input').val('1');
					jQuery('.list-row.fourth-row p:last-child() span').text('0.00');
					jQuery('#restau_menu_info form').prop('id', 'restau_continue_payment');
					jQuery('.easync-menu-list .payment_method_restau').show();
					jQuery('#restau_continue_payment #multiple_table').hide();
					jQuery('.easync-menu-list .special-request .list-row.first-row input').prop('checked', false);
					jQuery('.payment .reserved_items').val(reservations);
					jQuery('.payment .item_size').val(item_size);
					
				}
			}

			
		});
	});

	jQuery('#restau_menu_info .close').on('click', function () {
		location.reload();
	});

</script>

