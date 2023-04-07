<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
?>
<div class="sync-result-lists search-result-container sync_container_for_price car-search-result-container">
	<div class="center-wrapper">
		<?php

			$reserved = array();
			$no_found = 0;

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

			while ($the_query->have_posts()) : $the_query->the_post();
				$number_conflect = 0;
				$temp_id = get_the_ID();
				$_SESSION['car_id'] = $temp_id;
				$available = 'yes';

	            $table = $wpdb->prefix . "sync_rent_car_entries";
                $entries = $wpdb->get_results( "SELECT * FROM $table WHERE car_id = $temp_id and status != 'cancelled' ORDER BY id DESC" );
	            if ( ! $entries ) {
	                $wpdb->print_error(); 
	            }else {
	                foreach ($entries as $key => $item) { 
	                	$reserved['archive_pick']   = $item->pick_date;
	                	$reserved['archive_return'] = $item->return_date;
	                	
						$range = new DatePeriod(
						     new DateTime($date_pick),
						     new DateInterval('P1D'),
						     new DateTime($date_return)
						);
						$start_date              = $reserved['archive_pick'];
						$end_date                = $reserved['archive_return'];
						$start_ts                = strtotime($start_date);
						$end_ts                  = strtotime($end_date);

						foreach ($range as $key => $value) {
							$new_pick_date        = $value->format('m/d/y');	
							$new_pick_date_ts     = strtotime($new_pick_date);
							if((($new_pick_date_ts <= $end_ts))) {
								$number_conflect++;
								// $number_conflect += $reserved['reserved_rooms']; 
								break;
							}
						}
	                }  
	            }

				$meta = get_post_meta( get_the_ID(), 'easync_car', true ); 

				if($number_conflect>=$meta['number_car']) 
	            	$available = 'no';
				
				if((!empty($meta['avail']) && $meta['avail'] =='Yes') && ($vehicle_type==$meta['type'] || $vehicle_type=='all') && ($available=='yes')) {
					$no_found = 1;
					$def_imge = WP_PLUGIN_URL . '/easync-booking/images/logo orange dark.svg';
					?>
					<div class="result-item">
						<div class="result-image">
							<?php if (has_post_thumbnail( get_the_ID() )) { ?>
								<img src="<?php echo the_post_thumbnail_url('full') ?>">
							<?php } else { ?>
								<img src="<?php echo $def_imge; ?>"> 
							<?php } ?>
							<span class="sync-tag"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sync_currency_symbol"><?php echo esc_html(easyncCurrency()).' '; ?></span>
								<span class="sync_price_money_format">
								<?php
								echo esc_html(easyncPrice($meta['price'])); 
								?>	
								</span>/ Day
							</span>
							<div class="sync_car_overlay">
							    <ul>
							    	<?php
										$tax_value = $wpdb->prefix . 'sync_options';
										$get_tax = $wpdb->get_results("SELECT option_value from $tax_value where option_name='sync_car_taxes';");
										$get_fees = $wpdb->get_results("SELECT option_value from $tax_value where option_name='sync_car_fees';");
			          					$meta_ft = get_post_meta( get_the_ID(), 'easync_car_features_group', true );  
										if ( $meta_ft ) {
			          						foreach ( $meta_ft as $field ) {
			          							?><li><p><i class="sync_color_green fa fa-check-circle fa-2x"></i><span><?php echo ' '.esc_html($field['car_features']); ?></span></p></li><?php
											}
			          					}
							    	?>
								</ul>
							</div>
							<div class="item-overlay top"></div>
							<div class="sync_avail_room">
								<span>Available <?php echo esc_html(($meta['number_car']-$number_conflect));?></span>
							</div>
						</div>
						<div class="result-item-details car-details"> 
							<?php $_SESSION['title'] = get_the_title(); ?>
							<h2><?php echo esc_html(the_title());?></h2>
							<p class="type"><strong>Type: </strong><span><?php echo esc_html($meta['type']);?></span></p>
							<p class="model"><span><strong><?php echo esc_html(ucfirst($meta['model']));?></strong></span></p>
							
							<input type="hidden" class="car-id" value="<?php echo esc_html(get_the_ID());?>">
							<input type="hidden" class="car-deposit" value="<?php echo esc_html($meta['deposit']);?>">
							<input type="hidden" class="car-tax" value="<?php echo $get_tax[0]->option_value;?>">
							<input type="hidden" class="car-fees" value="<?php echo $get_fees[0]->option_value;?>">
							<?php 
								$meta = get_post_meta( get_the_ID(), 'easync_car', true );  
								$_SESSION['get_car_id'] = get_the_ID();
							?><input type="hidden" class="specify-special-request" value="<?php echo esc_html($meta['writemsg']);?>">
							<?php
								$temp_data = '';
								$meta = get_post_meta( get_the_ID(), 'sync_car_specialrequest_group', true );  
								if ( $meta ) {
									foreach ( $meta as $field ) {
										$temp_data .= $field['specialrequest'].',';
									}
								}
							?>
							<input type="hidden" class="facilities-special-request" value="<?php echo (($temp_data!='') ? esc_html($temp_data) : '')?>"> 
							<div class="go-book" id="go-book">
								<button type="submit" data-toggle="modal" data-targett="#car_customer_info" data-backdrop="static" data-keyboard="false" class="book-car" id="book-car" >Book Now</button>
							</div>
						</div>
					</div>
					<?php
				}
			endwhile;

		    if($no_found == 0) {
		    	?><div class="sync_car_no_result">
					<p>No Result Found</p>
				</div><?php
		    }

			?>
			<input type="hidden" class="with-or-without" value="<?php echo esc_html($with_or_out_driver);?>">
			<div class="navigation">
				<div class="alignleft next"><?php previous_posts_link('Top Entries &raquo;') ?></div>
				<div class="alignright previous"><?php next_posts_link('&laquo; Old Entries') ?></div>
			</div>
			<?php
			wp_reset_query();
		?>
	</div>
</div>