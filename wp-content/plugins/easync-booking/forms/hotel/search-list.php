<?php 
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb; 
session_start();

$table_rate   = $wpdb->prefix . "sync_room_rates";
$custom_rates = $wpdb->get_results("select * from $table_rate where status = 'Active';");

foreach ($custom_rates as $each_rates) {

	$date_today = date_create(date("m/d/Y"));
	$end_date_rate = date_create($each_rates->end_date);
	$date_dif = date_diff($date_today, $end_date_rate);
	$result = $date_dif->format('%R%a');
	if ($result <= '0') {
		$wpdb->query("UPDATE $table_rate SET status = 'Ended' WHERE id = '$each_rates->id'");
	}
}

?>
<div class="sync-result-lists search-result-container sync_container_for_price">

	<div class="center-wrapper">
		

		<?php

			$reserved = array();
			$no_found = 0;

			$args = array(
						   'orderby' => 'post_date',
						   'order' => 'DESC',
						   'post_type' => 'easync_hotel_room',
						   'post_status' => 'publish',
			               'posts_per_page' => -1,
			               'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
			               );

			query_posts($args);
			$the_query = new WP_Query( $args );

			while ($the_query->have_posts()) : $the_query->the_post();
				$number_conflect = 0;
				$temp_id = get_the_ID();
				$available = 'yes';

	            $table = $wpdb->prefix . "sync_hotel_entries";
                $entries = $wpdb->get_results( "SELECT * FROM $table WHERE room_id = $temp_id and status != 'cancelled' ORDER BY id DESC" );
	            if ( ! $entries ) {
	                $wpdb->print_error(); 
	            }else {
	                foreach ($entries as $key => $item) { 
	                	$reserved['archive_arrival']   = $item->arrival_date;
	                	$reserved['archive_departure'] = $item->departure_date;
	                	$reserved['reserved_rooms'] = $item->room_number;
	                	$reserved['reserved_beds'] = $item->bed_number;
	                	
						$range = new DatePeriod(
						     new DateTime($date_arrive),
						     new DateInterval('P1D'),
						     new DateTime($date_departure)
						);
						$start_date              = $reserved['archive_arrival'];
						$end_date                = $reserved['archive_departure'];
						$start_ts                = strtotime($start_date);
						$end_ts                  = strtotime($end_date);

						foreach ($range as $key => $value) {
							$new_checkin_date        = $value->format('m/d/y');	
							$new_checkin_date_ts     = strtotime($new_checkin_date);
							if((($new_checkin_date_ts <= $end_ts))) {
								$number_conflect++;
								// $number_conflect += $reserved['reserved_rooms']; 
								break;
							}
						}

	                } 
	            }

				$meta = get_post_meta( get_the_ID(), 'easync_hotel', true ); 

				if($number_conflect>=$meta['number_room'] || $number_room > ($meta['number_room']-$number_conflect)) 
	            	$available = 'no';
				

				if((!empty($meta['avail']) && $meta['avail'] =='Yes') && (!empty($meta['avail']) && $meta['capacity'] == $number_guest && $meta['number_bed'] == $number_bed ) && ($available=='yes')) {
					$no_found = 1;
					$def_imge = WP_PLUGIN_URL . '/easync-booking/images/logo orange dark.svg';
					?>
					<div class="result-item">
						<div class="result-image">
							<?php if (has_post_thumbnail( get_the_ID() )) { ?>
								<a data-fancybox="<?php echo 'gallery_'.esc_html(get_the_ID()); ?>" href="<?php echo esc_url(the_post_thumbnail_url('full')) ?>">
									<img src="<?php echo the_post_thumbnail_url('full') ?>">
								</a>
							<?php } else { ?>
								<img src="<?php echo $def_imge ?>">
							<?php } ?>
							<?php
								$meta = get_post_meta( get_the_ID(), 'sync_room_images_group', true );  
								if ( $meta ) {
	          						foreach ( $meta as $field ) {
	          							?><a style="visibility: hidden;" data-fancybox="<?php echo 'gallery_'.get_the_ID(); ?>" href="<?php echo wp_get_attachment_url( $field['room_images'] ) ?>"><img style="visibility: hidden;" src="<?php echo wp_get_attachment_url( $field['room_images'] ) ?>"></a><?php
									}
	          					}
							?>
							<span class="sync-tag"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;&nbsp;
								
								<?php 
									$id = get_the_ID();
									$meta = get_post_meta( $id, 'easync_hotel', true ); 
									$rate = $wpdb->prefix . 'sync_room_rates';
									$qry = $wpdb->get_results("SELECT * from $rate where status = 'active' and room_id = '".$id."';");
									$now = date("m/d/Y");
									$orig_price = $meta['price'];

									$start = $qry[0]->start_date;
									$start_date = date_create($qry[0]->start_date);
									$date_now = date_create(date("m/d/Y"));
									$end = date_create($qry[0]->end_date);
									$start_diff = date_diff($date_now, $start_date);
									$format_start = $start_diff->format("%R%a");
									$diff = date_diff($date_now, $end);
									$format = $diff->format("%R%a");
									if ( $orig_price > $qry[0]->rate ) {
										if (($now == $start) || ($format_start <= '0') && ($format > '0' ) ) { ?>
											<span class="orig_price"><del> <?php
												echo esc_html(easyncCurrency()).' '.easyncPrice($meta['price']);
											?> </del></span> &nbsp;&nbsp; <?php
										} 
									} ?>
									
								<span class="sync_currency_symbol"><?php echo esc_html(easyncCurrency()).' '; ?></span>	
								<span class="sync_price_money_format">
									<?php 
									if (($now == $start) || ($format_start <= '0') && ($format > '0' ) ) {
										echo $qry[0]->rate;
									} else {
										echo easyncPrice($meta['price']);
									} ?>	
								</span>
							</span>
							<div class="sync_avail_room">
								<span>Available <?php echo esc_html(($meta['number_room']-$number_conflect));?></span>
							</div>
						</div>
						<div class="result-item-details">
							<?php $_SESSION['title'] = get_the_title(); ?>
							<h2><?php echo esc_html(the_title());?></h2>
							
							<?php 
							$meta = get_post_meta( get_the_ID(), 'easync_hotel', true ); 
							?>
							<p><strong>Room Measurement: </strong>  <?php echo esc_html($meta['measurement']); ?></p>
							<p><?php echo easyncStringLimitWords(get_the_content(),24);?></p>
							<input type="hidden" class="specify-special-request" value="<?php echo esc_html($meta['writemsg']);?>"><?php
							$temp_data = '';
							$meta = get_post_meta( get_the_ID(), 'sync_customdata_group', true );  
							if ( $meta ) {
          						foreach ( $meta as $field ) {
          							$temp_data .= $field['TitleItem'].',';
								}
          					}
          					?><input type="hidden" class="amenities" value="<?php echo (($temp_data!='') ? esc_html($temp_data) : '')?>"><?php
          					$temp_data = '';
          					$meta = get_post_meta( get_the_ID(), 'sync_specialrequest_group', true );  
							if ( $meta ) {
          						foreach ( $meta as $field ) {
          							$temp_data .= $field['specialrequest'].',';
								}
          					}
							?>
							<input type="hidden" class="facilities-special-request" value="<?php echo (($temp_data!='') ? esc_html($temp_data) : '')?>"> 
							<input type="hidden" class="room-id" value="<?php echo esc_html(get_the_ID());?>">
						</div>
						<div class="go-book" id="go-book">
							<button type="submit" data-toggle="modal" data-targett="#customer_info" data-backdrop="static" data-keyboard="false" class="book-save">Book now</button>
						</div>
					</div>
					<?php
				}
			endwhile;

			if($no_found == 0) {
		    	?><div class="sync_hotel_no_result">
					<p>No Result Found</p>
				</div><?php
		    }

			?>
			<div class="navigation">
			<div class="alignleft next"><?php previous_posts_link('Top Entries &raquo;') ?></div>
			<div class="alignright previous"><?php next_posts_link('&laquo; Old Entries') ?></div>
			</div>
			<?php
			wp_reset_query();
		?>

	</div>

</div>