<?php  
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb?>
<br/>
<h3>How to use this plugin:</h3>
<main class="">
  <h4>Adding Shortcode:</h4>
  <p>1. Create a <strong>full width</strong> page</p>
  <p>2. Copy and paste the shortcodes below</p>		
  <h5>For Hotel Room</h5>
  <p>Shortcode: <strong>[easync_hotel_code]</strong></p>
  <p>To add hotel room type, go to auto generated <strong>eaSYNC Hotel</strong> in your sidebar</p>
  <h5>For Car Rental</h5>
  <p>Shortcode: <strong>[easync_car_code]</strong></p>
  <p>To add car rental, go to auto generated <strong>eaSYNC Rental</strong> in your sidebar</p>
  <h5>For Restaurant Reservation</h5>
  <p>Shortcode: <strong>[easync_restau_code]</strong></p>
  <p>To add menu type, go to auto generated <strong>eaSYNC Restau</strong> in your sidebar</p>
  <h4>Paypal configuration:</h4>
  <p>Please go to setting and click advance tab, set your paypal credentials.</p>
    <h4>Stripe configuration:</h4>
  <p>Please go to setting and click advance tab, set your stripe credentials.</p>
  <section id="content1">
    <div id="accordion">
      <div class="card sync-dashboard-car">
        <div class="card-header sync-card-header" id="headingOne">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-targett="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-car"></i> 
              Expected Car Return
            </button>
          </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <div id="accordion-car">

              <div id="accordion-sub" style="overflow-y: scroll;overflow-x: hidden;max-height: 600px;">
              <?php
                  $table_name = $wpdb->prefix . "sync_rent_car_entries";
                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE status = %s ORDER BY return_date ASC", 'active'));
                  if ( ! $entries ) {
                      $wpdb->print_error(); 
                  }else {
                      foreach ( $entries as $key => $value) {
                          ?>
                          <div class="card sync-dashboard-car"><!-- sync-car-due-date -->
                            <?php 
                            $current = strtotime(date("m/d/y"));
                            $return = strtotime($value->return_date);
                            $due = '';
                            $due_date_text = '';
                            $show_tip = 'true';
                            $date1=date_create(date("m/d/y"));
                            $date2=date_create($value->return_date);
                            $diff=date_diff($date1,$date2);
                            $remain_day = $diff->format("%a days").' remaining';
                            if($return < $current) {
                               $remain_day = '';
                               $show_tip = 'false';
                               $due = 'sync-car-due-date';
                               $due_date_text = '<h4 class="text-due-date">( '.$diff->format("%R%a days").' )</h4>';
                            }
                            ?>
                            <div class="card-header sync-card-header <?php echo $due;?>" id="headingOne<?php echo $key;?>">
                              <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-targett="#collapseOne<?php echo $key;?>" aria-expanded="true" aria-controls="collapseOne1"><i class="fas fa-user-circle"></i>
                                  <?php echo $value->lastname.' , '.$value->firstname; ?>
                                </button>
                              </h5>
                              <div class="car-expected-return-holder">
                                <?php echo $due_date_text; ?>
                                <p>
                                  <label for="amount">(Pick date - Return Date)</label>
                                  <input hidden="hidden" type="text" class="car-expected-return <?php echo $due.'-input';?>" disabled="disabled" style="border: 0; color: #f6931f; font-weight: bold; background-color: transparent;" size="100"/>
                                  <input type="text" class="label-expected-return <?php echo $due.'-input';?>" disabled="disabled" style="border: 0; color: #f6931f; font-weight: bold; width: 300px; background-color: transparent;box-shadow: none;" size="100"/>        
                                </p>
                                <div class="slider-range" data-date-min="<?php echo $value->pick_date; ?>" data-date-max="<?php echo $value->return_date; ?>" data-date-deff="<?php echo $remain_day;?>" data-show-tip="<?php echo $show_tip; ?>"></div>
                              </div>
                            </div>

                            <div id="collapseOne<?php echo $key;?>" class="collapse hide" aria-labelledby="headingOne<?php echo $key;?>" data-parent="#accordion-sub">
                              <div class="card-body">
                                <div id="accordion-car<?php echo $key;?>">

                                  <p><?php echo 'Rented Time: '.$value->pick_time.' - Return Time: '.$value->return_time; ?></p>

                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                      }
                  }
              ?>
              </div>

              <div class="sync-car-return-history">
                <h3>Return Logs</h3>
                <div class="sync-car-return-history-scroll">
                           
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th scope="col">Date Rented</th>
                        <th scope="col">Returned Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Car | Type | Model</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                       $table_name = $wpdb->prefix . "sync_rent_car_entries";
                       $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE status != %s OR status != %s ORDER BY return_date DESC", 'deleted', 'inactive'));
                       if ( ! $entries ) {
                          $wpdb->print_error(); 
                       }else {
                         foreach ( $entries as $key => $value) {
                            $meta = get_post_meta( $entries[0]->car_id, 'easync_car', true );
                            $car_name  = get_post($entries[0]->car_id)->post_title;
                            $car_type = '';
                            $car_model = '';
                            if(isset( $meta['type'] )) {
                              $car_type  = ' | '.$meta['type'];
                            }
                            if(isset( $meta['model'] )) {
                              $car_model = ' | '.$meta['model'];
                            }
                            
                              ?>
                              <tr>
                                <td scope="row"><?php echo $value->pick_date; ?></td>
                                <td><?php echo $value->return_date; ?></td>
                                <td><?php echo $value->lastname.', '.$value->firstname; ?></td>
                                <td><?php echo $car_name.''.$car_type.''.$car_model; ?></td>
                              </tr>
                              <?php
                          }
                       }

                      ?>
                    </tbody>
                  </table>

                  </div>

                </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
      
</main>


