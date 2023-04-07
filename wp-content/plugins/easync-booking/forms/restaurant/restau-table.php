<?php
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $sync_restau_privacy, $sync_restau_terms; 
session_start();
$table_entries = $wpdb->prefix . "sync_restau_entries";
$table_name = $wpdb->prefix . 'sync_options';
?>

<script>
    var ids = [];
    var tble_count = 0;
    var cost_sum = 0;
</script>

<div class="sync-result-lists search-result-container sync_container_for_table table-search-result-container" id="select_table">
    <div class="center-wrapper">
        <?php
            $reserved  = array();
            $no_found  = 0;
            $args = array(
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'easync_restau_table',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
            );

            query_posts($args);
            $the_query = new WP_Query( $args );

            while ($the_query->have_posts()) : $the_query->the_post();
                $number_conflect      = 0;
                $temp_id              = get_the_ID();
                $_SESSION['table_id'] = $temp_id;
                $available            = 'yes';

                $table = $wpdb->prefix . "sync_restau_entries";
                $table_record = $wpdb->prefix . "sync_restau_tables";
                $entries = $wpdb->get_results( "SELECT * FROM $table INNER JOIN $table_record on $table.id = $table_record.entry_id WHERE $table_record.table_id = $temp_id and $table.status !='cancelled' ORDER BY $table.id DESC" );
	            
                if ( ! $entries ) {
	                $wpdb->print_error(); 
	            }else {
	                foreach ($entries as $key => $item) { 
	                	$reserved['archive_pick']   = $item->pick_date;
						$start_date              = $reserved['archive_pick'];
						$start_ts                = strtotime($start_date);	
                        $new_pick_date_ts     = strtotime($date_pick);
                        
                        if((($new_pick_date_ts <= $start_ts))) {
                            $number_conflect++;
                            break;
                        }
	                }  
	            }

                $meta = get_post_meta( get_the_ID(), 'sync_restau_table', true ); 
                if($number_conflect>=$meta['total']) 
                    $available = 'no';

                if((!empty($meta['avail']) && $meta['avail'] =='Yes') && ($available=='yes') && $meta['branch'] == $branch ) {
                    $no_found = 1; 
                    $def_imge = WP_PLUGIN_URL . '/easync-booking/images/logo orange dark.svg'; ?>
                    <div class="result-item <?php echo $temp_id; ?>">
                        <input style="display:none" type="checkbox" name="table_<?php echo $temp_id;?>" id="table_<?php echo $temp_id;?>">
                        <div class="result-image">
                            <?php if (has_post_thumbnail( get_the_ID() )) { ?>
                                <a data-fancybox="<?php echo 'gallery_'.esc_html(get_the_ID()); ?>" href="<?php echo esc_url(the_post_thumbnail_url('full')) ?>">
                                    <img src="<?php echo the_post_thumbnail_url('full'); ?>">
                                </a>
                            <?php } else { ?> 
                                <img src="<?php echo $def_imge; ?>">
                            <?php } ?>
							<?php
								$meta_img = get_post_meta( get_the_ID(), 'sync_table_images_group', true );  
								if ( $meta_img ) {
	          						foreach ( $meta_img as $field ) {
	          							?><a style="visibility: hidden;" data-fancybox="<?php echo 'gallery_'.get_the_ID(); ?>" href="<?php echo wp_get_attachment_url( $field['table_images'] ) ?>"><img style="visibility: hidden;" src="<?php echo wp_get_attachment_url( $field['table_images'] ) ?>"></a><?php
									}
	          					}
							?>
                           
                            <div class="sync_avail_table">
                                <span>Available <?php echo esc_html(($meta['total']-$number_conflect));?></span>
                            </div>
                        </div>
                        <div class="result-item-details">
                            <?php $_SESSION['title'] = get_the_title(); ?>
                            <h2><?php echo esc_html(the_title());?></h2>
                            
                            <?php $meta = get_post_meta( get_the_ID(), 'sync_restau_table', true ); ?>

                            <p><strong>Number of Seats: </strong>  <?php echo esc_html($meta['seats']); ?></p>
                            <p><?php echo easyncStringLimitWords(get_the_content(),24);?></p>

                        </div>
                        <div class="go-book" id="go-book">
                            <input type="hidden" class="left_available <?php echo $temp_id; ?> " id="<?php echo $meta['total'] - $number_conflect; ?>" value="<?php echo $meta['total'] - $number_conflect; ?>">
                            <button type="button" id="<?php echo $temp_id; ?>" class="select_table">Select Table</button>
                            <button style="display:none;" type="button" id="<?php echo $temp_id; ?>" class="deselect_table">Deselect Table</button>
                        </div>
                    </div>

                    <script>
                        var table_qty = "<?php echo $table_qty; ?>";
                        jQuery("#<?php echo $temp_id; ?>.select_table").click( function () { 

                            var table_id = this.id;
                            var available = jQuery('input.left_available.<?php echo $temp_id; ?>').val();

                            jQuery(".result-item.<?php echo $temp_id; ?>").addClass("selected-table");
                            jQuery("#set_qty .modal-header button").prop( "id", "<?php echo $temp_id; ?>" );
                            jQuery("#table_<?php echo $temp_id; ?>").prop( "checked", true );
                            jQuery("#<?php echo $temp_id; ?>.deselect_table").show();
                            jQuery("#<?php echo $temp_id; ?>.select_table").hide();
                            jQuery("#selected_table_id").val(table_id);
                            jQuery("#available_left").val(available);
                            
                            if ( table_qty == 1 ) {
                                jQuery("#restau_menu_info").modal("show");
                                jQuery('#select_table .select_table').prop("disabled", true);
                                jQuery('.easync-menu-list .payment_method_restau').show();
                                jQuery('#restau_continue_payment #table_id').val(table_id);
                                // jQuery('#restau_menu_info form').prop('id', 'restau_continue_payment');
                            } else {
                                jQuery("#set_qty").modal({backdrop: 'static', keyboard: false}, "show");
                                jQuery('#restau_menu_info form').prop('id', 'restau_continue_reservation');
                            }
                        });

                        jQuery("#<?php echo $temp_id; ?>.deselect_table").click( function () {
                            jQuery(".result-item.<?php echo $temp_id; ?>").removeClass("selected-table");
                            jQuery("#table_<?php echo $temp_id; ?>").prop( "checked", false );
                            jQuery("#<?php echo $temp_id; ?>.deselect_table").hide();
                            jQuery("#<?php echo $temp_id; ?>.select_table").show();
                            jQuery('#select_table .select_table').prop("disabled", false);

                            var remove = "<?php echo $temp_id; ?>";
                            var subtract = jQuery.grep(ids, function(value) {
                                return value === remove;
                            }).length;
                            
                            ids = jQuery.grep(ids, function(value) {
                                return value != remove;
                            });

                            tble_count -= +subtract;

                        });

                    </script>

                <?php  }
            endwhile;

            if($no_found == 0) { ?>
                <div class="sync_hotel_no_result">
                    <p>No Result Found</p>  
                </div>
            <?php } ?>

            <div class="navigation">
                <div class="alignleft next"><?php previous_posts_link('Top Entries &raquo;') ?></div>
                <div class="alignright previous"><?php next_posts_link('&laquo; Old Entries') ?></div>
            </div>
            <?php
            wp_reset_query();
            unset($the_query);
        ?>
    </div>
</div>

<div class="modall sync-transform fade sync-modal-qty" id="set_qty" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="table_number">
                    <div class="div_set_qty">
                        <input type="hidden" name="table_id" id="selected_table_id" value="">
                        <input type="hidden" name="available_left" id="available_left" value="">
                        <label for="" class="table-qty">Table Quantity </label>
                        <div class="separator">
                            <div class="input_dv">
                                <input type="text" name="inpt_qty" id="inpt_qty" class="inpt_qty" min="1"> 
                            </div>
                            <button type="submit" class="get_qty">Done</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    jQuery(document).ready (function () {
        (function() {
            jQuery.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));  

        jQuery("#table_number #inpt_qty").inputFilter(function(value) {
            var qtyss = jQuery('#available_left').val();
            var set = "<?php echo $table_qty; ?>";
            if ( set >= qtyss) {
                return /^\d*$/.test(value) && (value === "" || (parseInt(value) <= qtyss && parseInt(value) !== 0));
            } else {
                return /^\d*$/.test(value) && (value === "" || (parseInt(value) <= set && parseInt(value) !== 0));
            }
             
        });
        
    });

    jQuery('#set_qty .close').on('click', function () {
        var id = this.id;

        jQuery(".result-item."+id).removeClass("selected-table");
        jQuery("#set_qty .modal-header button").removeAttr("id");
        jQuery("#table_"+id).prop( "checked", false );
        jQuery("#"+id+".deselect_table").hide();
        jQuery("#"+id+".select_table").show();
        jQuery('#select_table .select_table').prop("disabled", false);
    });

    jQuery(document).ready( function () {
        
        jQuery("#set_qty .get_qty").click( function (e) {
            
            var t_id = jQuery("#selected_table_id").val(); 
            var qtys = jQuery('#available_left').val();
            var qty = jQuery("#inpt_qty").val();
            var table_set = "<?php echo $table_qty; ?>";
            tble_count += +qty;
            e.preventDefault();
            jQuery('#table_number .error-qty.active').remove();

            if ( tble_count == table_set ) {
                jQuery("#restau_menu_info").modal("show");
                jQuery('#select_table .select_table').prop("disabled", true);
                jQuery("#inpt_qty").val("");
                jQuery("#set_qty").modal("hide");

                for (let i = 0; i < qty; i++) {
                    ids.push(t_id);
                }

                if (table_set > 1) {
                    jQuery('#restau_menu_info form').prop('id', 'restau_continue_reservation');
                    jQuery('#restau_continue_reservation #table_id').val(ids);
                    jQuery('#restau_continue_reservation #multiple_table').show();
                } else {
                    jQuery('#restau_menu_info form').prop('id', 'restau_continue_payment');
                    jQuery('#restau_continue_payment #table_id').val(ids);
                    jQuery('.easync-menu-list .payment_method_restau').show();
                }

            } else if ( tble_count > table_set) {
                e.preventDefault();
                jQuery('#table_number .error-qty.active').remove();
                jQuery('#table_number .input_dv').append('<div class="error error-qty active"> Number of selected tables exceeded the expected quantity. </div>');
                tble_count -= +qty;
            } else if ((tble_count == "") || (qty == "")) {
                e.preventDefault();
                jQuery('#table_number .error-qty.active').remove();
                jQuery('#table_number .input_dv').append('<div class="error error-qty active"> This field is required. </div>');
            } else {
                jQuery("#set_qty").modal("hide");
                jQuery("#inpt_qty").val("");
                for (let i = 0; i < qty; i++) {
                    ids.push(t_id);
                }
            }
        });
    });

</script>