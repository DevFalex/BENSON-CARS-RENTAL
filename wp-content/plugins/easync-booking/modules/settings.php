<?php  
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $sync_hotel_enable, $sync_captcha_enable, $sync_driver_enable, $sync_car_enable, $sync_restau_enable, $sync_currency; $sync_checkin_switch; 
?>

<h3 class="sync-entries-title">Settings</h3>
<main class="sync_backend_entries">
  
  <input id="tab1" type="radio" class="sync_tab" name="tabs" checked>
  <label for="tab1"><i class="fa fa-cog"></i> General</label>

  <?php if(is_super_admin()) { ?>
  <input id="tab2" type="radio" class="sync_tab" name="tabs">
  <label for="tab2"><i class="fa fa-wrench"></i> Advance</label>
  <?php } ?>  
  <section id="content1">

    <div class="sync_common_settings">
        <div class="sync_settings_enable hotel">
          <label>Hotel Booking</label>
          <div>
            <?php if ($sync_hotel_enable==false) { ?>
              <input type="checkbox" id="sync_hotel_switch" value="on" name="sync_hotel_switch"/>
            <?php } else { ?>
              <input type="checkbox" id="sync_hotel_switch" value="on" checked name="sync_hotel_switch"/>
            <?php } ?>
          </div>
        </div>
        <div class="sync_settings_enable car">
           <label>Car Rental</label><div>
            <?php
                if ($sync_car_enable==false) {
                  ?>
                 <input type="checkbox" id="sync_car_switch" value="on" name="sync_car_switch"/>
                <?php
                }else{  
                ?>
                 <input type="checkbox" id="sync_car_switch" value="on" checked name="sync_car_switch"/>
                <?php
              }
            ?>
          </div>
        </div>
        <div class="sync_settings_enable restau">
           <label>Restaurant Reservation</label><div>
            
            <?php
                if ($sync_restau_enable==false) {
                  ?>
                  <input type="checkbox" id="sync_restau_switch" value="on" name="sync_restau_switch"/>
                  <?php
                }else{
                ?>
                <input type="checkbox" id="sync_restau_switch" value="on" checked name="sync_restau_switch"/>
                <?php
              }
            ?>
          </div>
        </div></br>
    </div>

    <div id="accordion">
      <?php if ($sync_hotel_enable==true) { ?>
      <div class="card">
        <div class="card-header sync-card-header" id="headingOne">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-targett="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-bed"></i> 
              Hotel Booking
            </button>
          </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <div id="accordion-hotel">
              <div class="sync_hotel_thank_you_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingOne-hotel-1">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseOne-hotel-1" aria-expanded="false" aria-controls="collapseOne-hotel-1"><i class="fa fa-chevron-right"></i>
                        Thank you page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne-hotel-1" class="collapse" aria-labelledby="headingOne-hotel-1" data-parent="#accordion-hotel">
                    <div class="card-body">
                      <h6>Select thank you page</h6>
                      <div class="container">
                        <form id="sync_hotel_thank_u" class="sync_hotel_thank_u" method="POST" >
                          <?php wp_nonce_field('easync_hotel_thank_you', 'easync_hotel_thank_you_nonce'); ?>
                          <select name="sync_hotel_thank_you">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_page_thank_u'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                  $selected = 'selected';
                                  ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_hotel_privacy_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingOne-hotel-2">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseOne-hotel-2" aria-expanded="false" aria-controls="collapseOne-hotel-2"><i class="fa fa-chevron-right"></i>
                        Privacy policy page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne-hotel-2" class="collapse" aria-labelledby="headingOne-hotel-2" data-parent="#accordion-hotel">
                    <div class="card-body">
                      <h6>Select privacy policy page</h6>
                      <div class="container">
                        <form id="sync_hotel_privacy" class="sync_hotel_privacy" method="POST" >
                          <?php wp_nonce_field('easync_hotel_privacy', 'easync_hotel_privacy_nonce'); ?>
                          <select name="sync_hotel_privacy">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_page_privacy'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                  $selected = 'selected';
                                  ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                       </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_hotel_terms_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingOne-hotel-3">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseOne-hotel-3" aria-expanded="false" aria-controls="collapseOne-hotel-3"><i class="fa fa-chevron-right"></i>
                        Terms and conditions page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne-hotel-3" class="collapse" aria-labelledby="headingOne-hotel-3" data-parent="#accordion-hotel">
                    <div class="card-body">
                      <h6>Select terms and conditions page</h6>
                      <div class="container">
                        <form id="sync_hotel_terms" class="sync_hotel_terms" method="POST" >
                          <?php wp_nonce_field('easync_hotel_terms', 'easync_hotel_terms_nonce'); ?>
                          <select name="sync_hotel_terms">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_page_terms'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                  $selected = 'selected';
                                  ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>  
              </div>

              <div class="sync_hotel_cancellation_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingOne-hotel-4">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseOne-hotel-4" aria-expanded="false" aria-controls="collapseOne-hotel-4"><i class="fa fa-chevron-right"></i>
                        Cancellation Settings
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne-hotel-4" class="collapse" aria-labelledby="headingOne-hotel-4" data-parent="#accordion-hotel">
                    <div class="card-body">
                      <h6>Set Cancellation Settings</h6>
                      <div class="container">
                        <form id="sync_hotel_cancellation" class="sync_hotel_cancellation" method="POST" >
                          <?php wp_nonce_field('easync_hotel_cancellation', 'easync_hotel_cancellation_nonce'); ?>
                          <div class="cancel_form">
                              
                            <div class="content-left">
                              <label for="sync_hotel_cancellation">Select Cancellation Policy Page</label>
                              <select name="sync_hotel_cancellation" id="sync_hotel_cancellation">
                                <option value="default">Default</option>
                                <?php
                                $pages = get_pages(); 
                                $table_name = $wpdb->prefix . "sync_options";
                                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_page_cancellation'));
                                foreach ($pages as $page_data) {
                                  $title = $page_data->post_title;
                                  $selected = '';
                                  if($entries && $entries[0]->option_value == get_permalink($page_data))
                                      $selected = 'selected';
                                      ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                                  }
                                ?>
                              </select>
                              <label for="cancel_day">Days given to costumers to cancel booking (prior to booked date) </label>
                              <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_grace_period'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="cancel_day" id="cancel_day">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="cancel_day" id="cancel_day" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                                <label for="refund_rate">Cancellation Refund Rate (%)</label>
                                <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_hotel_refund_rate'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="refund_rate" id="refund_rate">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="refund_rate" id="refund_rate" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                                <input type="submit" value="Save" name="save" id= "save_cancel_dtls" class="save-btn btn btn-success"/>
                              
                            </div>
                          </div>
                        </form>  
                      </div>
                    </div>
                  </div>
                </div>  
              </div>

              <div class="sync_hotel_email_notifs">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-hotel-3.5">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-hotel-3.5" aria-expanded="false" aria-controls="collapseThree-hotel-3.5"><i class="fa fa-chevron-right"></i>
                      Email notification
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-hotel-3.5" class="collapse" aria-labelledby="headingThree-hotel-3.5" data-parent="#accordion-hotel">
                    <div class="card-body">
                      <div class="container">
                        <form id="sync_hotel_emails" class="sync_hotel_emails" method="POST">
                          <?php wp_nonce_field('easync_hotel_emails', 'easync_hotel_emails'); ?>
                            <div class="set_notif">
                              <label for="select_notifs" class="select_notifLabel">Select Email Reminders (Can select more than one): </label>
                              <br>
                              <?php 
                                $options = $wpdb->prefix . 'sync_options';
                                $qry_check = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_selected_reminders';");
                                $selected = explode("-", $qry_check[0]->option_value);
                                $option = $wpdb->prefix . 'sync_options';
                                $query = $wpdb->get_results("SELECT option_value from $option where option_name IN ('book_reminder7_email_head', 'book_reminder7_email_body', 'book_reminder7_email_footer') ;");
                                
                                if ( $selected[0] != 'true' ) { ?>
                                  <input type="checkbox" id="7days" name="7days">
                                <?php } else {?>
                                  <input type="checkbox" id="7days" name="7days" checked>
                                <?php } ?>

                                <label for="7days"> 7 days before booked date  </label>
                                <br>

                                <?php if ( $selected[1] != 'true' ) { ?>
                                  <input type="checkbox" id="3days" name="3days">
                                <?php } else {?>
                                  <input type="checkbox" id="3days" name="3days" checked>
                                <?php } ?>

                                <label for="3days"> 3 days before booked date  </label>
                                <br>

                                <?php if ( $selected[2] != 'true' ) { ?>
                                  <input type="checkbox" id="1days" name="1days">
                                <?php } else {?>
                                  <input type="checkbox" id="1days" name="1days" checked>
                                <?php } ?>
                                
                                <label for="1days"> 1 day before booked date  </label>
                            </div>
                            <br>
                            <div class="email_section">
                              <label for="email_type" class="email_typeLabel"> Email Template: </label>
                              <select name="email_type" id="email_type">
                                <option disabled value="0" selected>Choose an email template... </option>
                                <option value="1">Request to Cancel Booking Email (Client)</option>
                                <option value="2">Request to Cancel Booking Email (Admin)</option>
                                <option value="3">Cancel Booking Declined Email</option>
                                <option value="4">Cancel Booking Approved Email</option>
                                <option value="5">Booking Reminder Email (7 Days)</option>
                                <option value="6">Booking Reminder Email (3 Days)</option>
                                <option value="7">Booking Reminder Email (1 Day)</option>
                                <option value="8">Successful Booking</option>
                              </select>
                              <br>

                              <label for="email-header-text">Email Header</label>
                              <textarea placeholder="If empty, default header will appear in email." name="head_text" id="email-header-text" rows="4" cols="30"></textarea><br>

                              <label id="body_label" for="email-body-text">Email Body</label>
                              <textarea placeholder="If empty, default body will appear in email." name="body_text" id="email-body-text" rows="4" cols="30"></textarea><br id="br_body">
                              <label for="email-footer-text">Email Footer</label>
                              <textarea placeholder="If empty, default footer will appear in email." name="footer_text" id="email-footer-text" rows="4" cols="30"></textarea></br>

                              <input type="submit" disabled value="Save" id= "save_email_cntnt" name="save" class="save-btn btn btn-success"/>
                            </div>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } 
      if ($sync_car_enable==true) { ?>
      <div class="card">
        <div class="card-header sync-card-header" id="headingTwo">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-car"></i> 
              Car Rental
            </button>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
          <div class="card-body">
              <div id="accordion-car">
                <div class="setting-car-pickup-location">
                  <div class="card">
                    <div class="card-header sync-card-header" id="headingTwo-car-1">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-1" aria-expanded="false" aria-controls="collapseTwo-car-1"><i class="fa fa-chevron-right"></i>
                          Pickup location
                        </button>
                      </h5>
                    </div>
                    <div id="collapseTwo-car-1" class="collapse" aria-labelledby="headingTwo-car-1" data-parent="#accordion-car">
                      <div class="card-body">
                        <h6>Pickup location</h6>
                        <div class="container">
                          <div class="list-group">
                            <?php
                                $table_name = $wpdb->prefix . "sync_options";
                                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_pickup'));
                                if ( ! $entries ) {
                                  $wpdb->print_error(); 
                                } else {
                                  foreach ( $entries as $key => $value) {
                                    ?>
                                    <a href="#" class="list-group-item select-pickup-location" data-id="<?php echo $value->id;?>" data-value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></a>
                                    <?php
                                  }
                                }
                            ?>
                          </div>
                        </div>
                        <form id="sync_car_pickup" class="sync_car_pickup" method="POST" >
                            <?php wp_nonce_field('easync_car_pickup', 'easync_car_pickup_nonce'); ?>
                            <div class="item-row">
                              <input type="text" name="location_name" class="location_name" value=""/>
                              <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              <div class="setting-car-types">
                <div class="card">
                    <div class="card-header sync-card-header" id="headingTwo-car-2">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-2" aria-expanded="false" aria-controls="collapseTwo-car-2"><i class="fa fa-chevron-right"></i>
                         Car types
                        </button>
                      </h5>
                    </div>
                    <div id="collapseTwo-car-2" class="collapse" aria-labelledby="headingTwo-car-2" data-parent="#accordion-car">
                      <div class="card-body">
                        <h6>Car types</h6>
                        <div class="container">
                          <div class="list-group">
                            <?php
                              $table_name = $wpdb->prefix . "sync_options";
                              $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_types'));
                              if ( ! $entries ) {
                                $wpdb->print_error(); 
                              } else {
                                foreach ( $entries as $key => $value) {
                                  ?><a href="#" class="list-group-item select-car-type" data-id="<?php echo $value->id;?>" data-value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></a><?php
                                }
                              }
                            ?>
                          </div>
                        </div>
                        <form id="sync_car_types" class="sync_car_types" method="POST" >
                          <?php wp_nonce_field('easync_car_types', 'easync_car_types_nonce'); ?>
                              <div class="item-row">
                                <input type="text" name="type_name" class="type_name" value=""/>
                                <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                              </div>
                        </form>
                      </div>
                    </div>
                </div>
              </div>

              <div class="setting-car-model">
                <div class="card">
                    <div class="card-header sync-card-header" id="headingTwo-car-3">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-3" aria-expanded="false" aria-controls="collapseTwo-car-3"><i class="fa fa-chevron-right"></i>
                        Car model
                        </button>
                      </h5>
                    </div>
                    <div id="collapseTwo-car-3" class="collapse" aria-labelledby="headingTwo-car-3" data-parent="#accordion-car">
                      <div class="card-body">
                        <h6>Car model</h6>
                        <div class="container">
                          <div class="list-group">
                            <?php
                              $table_name = $wpdb->prefix . "sync_options";
                              $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_model'));
                              if ( ! $entries ) {
                                  $wpdb->print_error(); 
                              }else {
                                foreach ( $entries as $key => $value) {
                                  ?>
                                  <a href="#" class="list-group-item select-car-model" data-id="<?php echo $value->id;?>" data-value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></a>
                                  <?php
                                }
                              }
                            ?>
                          </div>
                        </div>
                        <form id="sync_car_model" class="sync_car_model" method="POST" >
                          <?php wp_nonce_field('easync_car_model', 'easync_car_model_nonce'); ?>
                            <div class="item-row">
                              <input type="text" name="model_name" class="model_name" value=""/>
                              <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                          </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_car_thank_you_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-4">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-4" aria-expanded="false" aria-controls="collapseTwo-car-4"><i class="fa fa-chevron-right"></i>
                      Thank you page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-4" class="collapse" aria-labelledby="headingTwo-car-4" data-parent="#accordion-car">
                    <div class="card-body">
                      <h6>Select thank you page</h6>
                      <div class="container">
                        <form id="sync_car_thank_u" class="sync_car_thank_u" method="POST" >
                          <?php wp_nonce_field('easync_car_thank_u', 'easync_car_thank_u_nonce'); ?>
                          <select name="sync_car_thank_you">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_page_thank_u'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                $selected = 'selected';
                                ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_car_privacy_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-5">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-5" aria-expanded="false" aria-controls="collapseTwo-car-5"><i class="fa fa-chevron-right"></i>
                      Privacy policy page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-5" class="collapse" aria-labelledby="headingTwo-car-5" data-parent="#accordion-car">
                    <div class="card-body">
                      <h6>Select privacy policy page</h6>
                      <div class="container">
                        <form id="sync_car_privacy" class="sync_car_privacy" method="POST" >
                          <?php wp_nonce_field('easync_car_privacy', 'easync_car_privacy_nonce'); ?>
                          <select name="sync_car_privacy">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_page_privacy'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                $selected = 'selected';
                                ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_car_terms_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-6">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-6" aria-expanded="false" aria-controls="collapseTwo-car-6"><i class="fa fa-chevron-right"></i>
                      Terms and conditions page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-6" class="collapse" aria-labelledby="headingTwo-car-6" data-parent="#accordion-car">
                    <div class="card-body">
                      <h6>Select terms and conditions page</h6>
                      <div class="container">
                        <form id="sync_car_terms" class="sync_car_terms" method="POST" >
                          <?php wp_nonce_field('easync_car_terms', 'easync_car_terms_nonce'); ?>
                          <select name="sync_car_terms">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_page_terms'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                $selected = 'selected';
                                ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_car_cancellation_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-8">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-8" aria-expanded="false" aria-controls="collapseTwo-car-8"><i class="fa fa-chevron-right"></i>
                      Cancellation Settings
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-8" class="collapse" aria-labelledby="headingTwo-car-8" data-parent="#accordion-car">
                    <div class="card-body">
                      <h6>Set Cancellation Settings</h6>
                      <div class="container">
                        <form id="sync_car_cancellation" class="sync_car_cancellation" method="POST" >
                            <?php wp_nonce_field('easync_car_cancellation', 'easync_car_cancellation_nonce'); ?>
                            <div class="cancel_form">

                              <div class="content-left">
                                <label for="sync_car_cancellation">Select Cancellation Policy Page</label>
                                <select name="sync_car_cancellation" id="sync_car_cancellation">
                                  <option value="default">Default</option>
                                  <?php
                                  $pages = get_pages(); 
                                  $table_name = $wpdb->prefix . "sync_options";
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_page_cancellation'));
                                  foreach ($pages as $page_data) {
                                    $title = $page_data->post_title;
                                    $selected = '';
                                    if($entries && $entries[0]->option_value == get_permalink($page_data))
                                      $selected = 'selected';
                                      ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                                    }
                                  ?>
                                </select>
                                <label for="cancel_day">Days given to costumers to cancel booking (prior to booked date) </label>
                                <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_grace_period'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="cancel_day" id="cancel_day">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="cancel_day" id="cancel_day" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                                <label for="refund_rate">Cancellation Refund Rate (%)</label>
                                <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_refund_rate'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="refund_rate" id="refund_rate">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="refund_rate" id="refund_rate" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                              </div>
                            </div>
                            <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                          </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_car_email_notifs">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-car-6.5">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-car-6.5" aria-expanded="false" aria-controls="collapseThree-car-6.5"><i class="fa fa-chevron-right"></i>
                        Email notification
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-car-6.5" class="collapse" aria-labelledby="headingThree-car-6.5" data-parent="#accordion-car">
                    <div class="card-body">
                      <div class="container">
                        <form id="sync_car_emails" class="sync_car_emails" method="POST" >
                        <?php wp_nonce_field('easync_car_emails', 'easync_car_emails_nonce'); ?>
                            <div class="set_notif">
                                <label for="select_notifs" class="select_notifLabel">Select Email Reminders (Can select more than one): </label>
                                <br> 
                                <?php 
                                $options = $wpdb->prefix . 'sync_options';
                                $qry_check = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_car_selected_reminders';");
                                $selected = explode("-", $qry_check[0]->option_value);
                                $option = $wpdb->prefix . 'sync_options';
                                $query = $wpdb->get_results("SELECT option_value from $option where option_name IN ('car_reminder7_email_head', 'car_reminder7_email_body', 'car_reminder7_email_footer');");
                                
                                if ( $selected[0] != 'true' ) { ?>
                                    <input type="checkbox" id="7days" name="7days">
                                <?php } else {?>
                                    <input type="checkbox" id="7days" name="7days" checked>
                                <?php } ?>

                                <label for="7days"> 7 days before booked date  </label>
                                <br>

                                <?php if ( $selected[1] != 'true' ) { ?>
                                    <input type="checkbox" id="3days" name="3days">
                                <?php } else {?>
                                    <input type="checkbox" id="3days" name="3days" checked>
                                <?php } ?>

                                <label for="3days"> 3 days before booked date  </label>
                                <br>

                                <?php if ( $selected[2] != 'true' ) { ?>
                                    <input type="checkbox" id="1days" name="1days">
                                <?php } else {?>
                                    <input type="checkbox" id="1days" name="1days" checked>
                                <?php } ?>
                                
                                <label for="1days"> 1 day before booked date  </label>
                            </div>
                            <br>
                            <div class="email_section">
                              <label for="car_email_type" class="car_email_typeLabel"> Email Template: </label>
                              <select name="car_email_type" id="car_email_type">
                                <option disabled value="0" selected>Choose an email template... </option>
                                <option value="1">Request to Cancel Rental Email (Client)</option>
                                <option value="2">Request to Cancel Rental Email (Admin)</option>
                                <option value="3">Cancel Rental Declined Email</option>
                                <option value="4">Cancel Rental Approved Email</option>
                                <option value="5">Rental Reminder Email (7 Days)</option>
                                <option value="6">Rental Reminder Email (3 Days)</option>
                                <option value="7">Rental Reminder Email (1 Day)</option>
                                <option value="8"> Rental</option>
                              </select>
                              <br>

                              <label for="email-text-header">Email Header</label>
                              <textarea placeholder="If empty, default header will appear in email." name="head_text" id="email-text-header" rows="4" cols="30"></textarea><br>

                              <label id="body_label" for="email-text-body">Email Body</label>
                              <textarea placeholder="If empty, default body will appear in email." name="body_text" id="email-text-body" rows="4" cols="30"></textarea><br id="br_car_body">
                              <label for="email-text-body">Email Footer</label>
                              <textarea placeholder="If empty, default footer will appear in email." name="footer_text" id="email-text-footer" rows="4" cols="30"></textarea></br>

                              <input type="submit" disabled value="Save" id= "save_email_cntnt" name="save" class="save-btn btn btn-success"/>
                            </div>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_default_car_pickup_return">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-7">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-7" aria-expanded="false" aria-controls="collapseTwo-car-7"><i class="fa fa-chevron-right"></i>
                      Default time
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-7" class="collapse" aria-labelledby="headingTwo-car-7" data-parent="#accordion-car">
                    <div class="card-body">
                      <label>Default time</label>
                      <div class="container">
                        <form id="sync_default_car_time" class="sync_car_pickup" method="POST" >
                          <?php wp_nonce_field('easync_car_default_time', 'easync_car_default_time_nonce'); ?>
                        <?php
                              $table_name = $wpdb->prefix . "sync_options";
                              $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_car_default_time'));
                              if ( ! $entries ) { ?>
                                <label>Pickup </label>
                                <input type="text" id="sync_default_pickup" name="sync_default_pickup">
                                <label>Return </label>
                                <input type="text" id="sync_default_return" name="sync_default_return"> <?php
                              } else { ?>
                                <label>Pickup </label>
                                <input type="text" id="sync_default_pickup" name="sync_default_pickup" value="<?php echo explode("-", $entries[0]->option_value, 2)[0]; ?>">
                                <label>Return </label>
                                <input type="text" id="sync_default_return" name="sync_default_return" value="<?php echo explode("-", $entries[0]->option_value, 2)[1]; ?>" >
                              <?php }
                          ?>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_driver_information_settings">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingTwo-car-11">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseTwo-car-11" aria-expanded="false" aria-controls="collapseTwo-car-11"><i class="fa fa-chevron-right"></i>
                      Driver Information Settings
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo-car-11" class="collapse" aria-labelledby="headingTwo-car-11" data-parent="#accordion-car">
                    <div class="card-body">
                      <h6>Require Customer to input driver information</h6>
                      <br>
                      <div class="driver_switch">
                        <div class="sync_settings_enable driver">
                          <?php
                            if ($sync_driver_enable==false) {
                              ?> <input type="checkbox" id="sync_driver_switch" value="on" name="sync_driver_switch"/> <?php
                            } else {
                              ?> <input type="checkbox" id="sync_driver_switch" value="on" checked name="sync_driver_switch"/> <?php
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php } 
      if ($sync_restau_enable==true) { ?>
      <div class="card">
        <div class="card-header sync-card-header" id="headingThree">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-spoon"></i> 
              Restaurant Reservation
            </button>
          </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
          <div class="card-body">
            <div id="accordion-restau">
              <div class="setting-branch-location">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-1">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-1" aria-expanded="false" aria-controls="collapseThree-restau-1"><i class="fa fa-chevron-right"></i>
                      Branch locations
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-1" class="collapse" aria-labelledby="headingThree-restau-1" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Branch locations</h6>
                      <div class="container">
                        <div class="list-group">
                          <?php
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC",'sync_branch_locations' ) );
                            if ( ! $entries ) {
                              $wpdb->print_error(); 
                            } else {
                              foreach ( $entries as $key => $value) { ?>
                                <a href="#" class="list-group-item select-branch-location" data-id="<?php echo $value->id;?>" data-value="<?php echo $value->option_value;?>" ><?php echo $value->option_value;?></a>
                                <?php
                              }
                            }
                          ?>
                        </div>
                      </div>
                      <form id="sync_branch" class="sync_branch" method="POST" >
                        <?php wp_nonce_field('easync_restau_branch', 'easync_restau_branch_nonce'); ?>
                          <div class="item-row">
                            <input type="text" name="branch_name" class="branch_name" value=""/>
                            <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_restau_thank_you_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-2">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-2" aria-expanded="false" aria-controls="collapseThree-restau-2"><i class="fa fa-chevron-right"></i>
                      Thank you page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-2" class="collapse" aria-labelledby="headingThree-restau-2" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Select thank you page</h6>
                      <div class="container">
                        <form id="sync_restau_thank_u" class="sync_restau_thank_u" method="POST" >
                          <?php wp_nonce_field('easync_restau_thank_u', 'easync_restau_thank_u_nonce'); ?>
                          <select name="sync_restau_thank_you">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_page_thank_u'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                $selected = 'selected';
                                ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div> 
                    </div>
                  </div>
                </div> 
              </div>

              <div class="sync_restau_privacy_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-3">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-3" aria-expanded="false" aria-controls="collapseThree-restau-3"><i class="fa fa-chevron-right"></i>
                      Privacy policy page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-3" class="collapse" aria-labelledby="headingThree-restau-3" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Select privacy policy page</h6>
                      <div class="container">
                        <form id="sync_restau_privacy" class="sync_restau_privacy" method="POST" >
                          <?php wp_nonce_field('easync_restau_privacy', 'easync_restau_privacy_nonce'); ?>
                          <select name="sync_restau_privacy">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_page_privacy'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                $selected = 'selected';
                                ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div> 
                    </div>
                  </div> 
                </div>
              </div>

              <div class="sync_restau_terms_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-4">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-4" aria-expanded="false" aria-controls="collapseThree-restau-4"><i class="fa fa-chevron-right"></i>
                      Terms and conditions page
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-4" class="collapse" aria-labelledby="headingThree-restau-4" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Select terms and conditions page</h6>
                      <div class="container">
                        <form id="sync_restau_terms" class="sync_restau_terms" method="POST" >
                          <?php wp_nonce_field('easync_restau_terms', 'easync_restau_terms_nonce'); ?>
                          <select name="sync_restau_terms">
                            <option value="default">Default</option>
                            <?php
                            $pages = get_pages(); 
                            $table_name = $wpdb->prefix . "sync_options";
                            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_page_terms'));
                            foreach ($pages as $page_data) {
                              $title = $page_data->post_title;
                              $selected = '';
                              if($entries && $entries[0]->option_value == get_permalink($page_data))
                                  $selected = 'selected';
                                  ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                              }
                            ?>
                          </select>
                          <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="sync_restau_terms_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-4.5">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-4.5" aria-expanded="false" aria-controls="collapseThree-restau-4.5"><i class="fa fa-chevron-right"></i>
                      Menu banner
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-4.5" class="collapse" aria-labelledby="headingThree-restau-4.5" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Menu banner</h6>
                      <div class="container">
                        <form id="sync_restau_banner_image" class="sync_restau_banner_image" method="GET">
                          <?php wp_nonce_field('easync_restau_banner_image', 'easync_restau_banner_image_nonce'); ?>
                          <?php
                          $image_id = '';
                          $table_name = $wpdb->prefix . "sync_options";
                          $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC",'sync_restau_banner_image' ) );
                         if ( ! $entries ) {
                            $wpdb->print_error(); 
                          }else {
                            $image_id = $entries[0]->option_value;
                          }

                          if( intval( $image_id ) > 0 ) {
                              // Change with the image size you want to use
                              $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
                          } else {
                              // Some default image
                            $default_banner = plugin_dir_url(dirname( __FILE__ )) . '../images/food-banner.jpg';
                              $image = '<img id="myprefix-preview-image" src="'.$default_banne.'" />';
                          }
                          ?>
                           <?php echo $image; ?>
                           <input type="hidden" name="myprefix_image_id" id="myprefix_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
                           <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an image', 'mytextdomain' ); ?>" id="myprefix_media_manager"/>
                           <?php
                            $submit_banner = 'hidden="hidden"';
                            if(intval( $image_id ) > 0) {
                                $submit_banner = '';
                            }
                           ?>
                           <input type="submit" <?php echo $submit_banner ;?> value="Save" name="save" class="save-btn btn btn-success"/>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

               <div class="sync_restau_terms_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-4.6">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-4.6" aria-expanded="false" aria-controls="collapseThree-restau-4.6"><i class="fa fa-chevron-right"></i>
                      Email notification
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-4.6" class="collapse" aria-labelledby="headingThree-restau-4.6" data-parent="#accordion-restau">
                    <div class="card-body">
                      <div class="container">
                        <form id="sync_restau_emails" class="sync_restau_emails" method="POST" >
                          <?php wp_nonce_field('easync_restau_emails', 'easync_restau_email_heads_nonce'); ?>
                          <div class="set_notif">
                              <label for="select_notifs" class="select_notifLabel">Select Email Reminders (Can select more than one): </label>
                              <br>
                              <?php 
                                $options = $wpdb->prefix . 'sync_options';
                                $qry_check = $wpdb->get_results("SELECT option_value from $options where option_name = 'sync_restau_selected_reminders';");
                                $selected = explode("-", $qry_check[0]->option_value);
                                $query = $wpdb->get_results("SELECT option_value from $options where option_name IN ('restau_reminder7_email_head', 'restau_reminder7_email_body', 'restau_reminder7_email_footer') ;");
                                
                                if ( $selected[0] != 'true' ) { ?>
                                  <input type="checkbox" id="7days" name="7days">
                                <?php } else {?>
                                  <input type="checkbox" id="7days" name="7days" checked>
                                <?php } ?>

                                <label for="7days"> 7 days before reserved date  </label>
                                <br>

                                <?php if ( $selected[1] != 'true' ) { ?>
                                  <input type="checkbox" id="3days" name="3days">
                                <?php } else {?>
                                  <input type="checkbox" id="3days" name="3days" checked>
                                <?php } ?>

                                <label for="3days"> 3 days before reserved date  </label>
                                <br>

                                <?php if ( $selected[2] != 'true' ) { ?>
                                  <input type="checkbox" id="1days" name="1days">
                                <?php } else {?>
                                  <input type="checkbox" id="1days" name="1days" checked>
                                <?php } ?>
                                
                                <label for="1days"> 1 day before reserved date  </label>
                            </div>
                            <br>
                            <div class="email_section">
                              <label for="email_type" class="email_typeLabel"> Email Template: </label>
                              <select name="email_type" id="email_type">
                                <option disabled value="0" selected>Choose an email template... </option>
                                <option value="1">Request to Cancel Reservation Email (Client)</option>
                                <option value="2">Request to Cancel Reservation Email (Admin)</option>
                                <option value="3">Cancel Reservation Declined Email</option>
                                <option value="4">Cancel Reservation Approved Email</option>
                                <option value="5">Reservation Reminder Email (7 Days)</option>
                                <option value="6">Reservation Reminder Email (3 Days)</option>
                                <option value="7">Reservation Reminder Email (1 Day)</option>
                                <option value="8">Successful Reservation</option>
                              </select>
                              <br>

                              <label for="email-header-text">Email Header</label>
                              <textarea placeholder="If empty, default header will appear in email." name="head_text" id="email-header-text" rows="4" cols="30"></textarea><br>
                              <label id="body_label" for="email-body-text">Email Body</label>
                              <textarea placeholder="If empty, default body will appear in email." name="body_text" id="email-body-text" rows="4" cols="30"></textarea><br id="br_body">
                              <label for="email-footer-text">Email Footer</label>
                              <textarea placeholder="If empty, default footer will appear in email." name="footer_text" id="email-footer-text" rows="4" cols="30"></textarea></br>
                              <input type="submit" disabled value="Save" id= "save_email_cntnt" name="save" class="save-btn btn btn-success"/>
                            </div>
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="sync_restau_cancellation_page">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingOne-hotel-6">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseOne-restau-6" aria-expanded="false" aria-controls="collapseOne-restau-4"><i class="fa fa-chevron-right"></i>
                        Cancellation Settings
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne-restau-6" class="collapse" aria-labelledby="headingOne-restau-6" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Set Cancellation Settings</h6>
                      <div class="container">
                        <form id="sync_restau_cancellation" class="sync_restau_cancellation" method="POST" >
                          <?php wp_nonce_field('easync_restau_cancellation', 'easync_restau_cancellation_nonce'); ?>
                          <div class="cancel_form">
                              
                            <div class="content-left">
                              <label for="sync_restau_cancel">Select Cancellation Policy Page</label>
                              <select name="sync_restau_cancel" id="sync_restau_cancel">
                                <option value="default">Default</option>
                                <?php
                                $pages = get_pages(); 
                                $table_name = $wpdb->prefix . "sync_options";
                                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_page_cancellation'));
                                foreach ($pages as $page_data) {
                                  $title = $page_data->post_title;
                                  $selected = '';
                                  if($entries && $entries[0]->option_value == get_permalink($page_data))
                                      $selected = 'selected';
                                      ?> <option <?php echo $selected; ?> value="<?php echo get_permalink($page_data); ?>"><?php echo $title; ?></option><?php
                                  }
                                ?>
                              </select>
                              <label for="cancel_day">Days given to costumers to cancel booking (prior to booked date) </label>
                              <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_grace_period'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="cancel_day" id="cancel_day">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="cancel_day" id="cancel_day" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                                <label for="refund_rate">Cancellation Refund Rate (%)</label>
                                <?php 
                                  $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_restau_refund_rate'));
                                  if ( !$entries ) { ?>
                                    <input type="number" name="refund_rate" id="refund_rate">
                                  <?php }
                                  else { ?>
                                    <input type="number" name="refund_rate" id="refund_rate" value="<?php echo $entries[0]->option_value; ?>">
                                  <?php }
                                ?>
                                <input type="submit" value="Save" name="save" id= "save_cancel_dtls" class="save-btn btn btn-success"/>
                              
                            </div>
                          </div>
                        </form>  
                      </div>
                    </div>
                  </div>
                </div>  
              </div>

              <div class="setting-timeslot">
                <div class="card">
                  <div class="card-header sync-card-header" id="headingThree-restau-5">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-targett="#collapseThree-restau-5" aria-expanded="false" aria-controls="collapseThree-restau-5"><i class="fa fa-chevron-right"></i>
                      Time slot
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree-restau-5" class="collapse" aria-labelledby="headingThree-restau-5" data-parent="#accordion-restau">
                    <div class="card-body">
                      <h6>Time slot</h6>
                      <div class="container">
                        <?php
                              $table_name = $wpdb->prefix . "sync_options";
                          ?>
                          <?php
                            for ($i=1; $i <6 ; $i++) { 
                              ?>
                              <div class="<?php echo 'setting-timeslot-slot'.$i;?> item-row">
                                <form id="<?php echo 'sync_timeslot'.$i;?>" method="GET">
                                  <?php wp_nonce_field('easync_restau_timeslot_'.$i, 'easync_restau_timeslot_'.$i.'_nonce'); ?>
                                  <div class="<?php echo 'setting-timeslot-slot'.$i;?> item-row">
                                    <label>Slot <?php echo $i;?></label>
                                    <?php
                                    $option_name = 'sync_timeslot'.$i;
                                    $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ", $option_name));
                                    if ( $entries ) { ?>
                                      <input id="<?php echo 'timeslot'.$i;?>" type="text" placeholder="From" value="<?php echo explode("-", $entries[0]->option_value, 2)[0];?>" name="<?php echo 'timeslot'.$i;?>"><span class="fa fa-sort-down fa-1x"></span>
                                      <?php
                                    } else { ?>
                                      <input id="<?php echo 'timeslot'.$i;?>" type="text" placeholder="From" value="" name="<?php echo 'timeslot'.$i;?>"><span class="fa fa-sort-down fa-1x"></span>
                                      <?php
                                    }

                                    if ( $entries ) {
                                        ?> <input id="<?php echo 'timeslot1_'.$i;?>" type="text" placeholder="To" value="<?php echo explode("-", $entries[0]->option_value, 2)[1];?>" name="<?php echo 'timeslot1_'.$i;?>"><span class="fa fa-sort-down fa-1x"></span>
                                        <?php
                                    } else { ?>
                                        <input id="<?php echo 'timeslot1_'.$i;?>" type="text" placeholder="To" value="" name="<?php echo 'timeslot1_'.$i;?>"><span class="fa fa-sort-down fa-1x"></span>
                                        <?php
                                    } ?>
                                  </div>
                                  <div class="item-row buttons">
                                    <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
                                    <input type="button" value="Delete" id= "delete_timeslot<?php echo $i; ?>" name="delete" class="delete-btn btn btn-danger"/>
                                  </div>
                                </form> 
                              </div>
                          <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </section>
  <?php if(is_super_admin()) { ?>  
    <section id="content2">
    <div class="sync_product_currency_code">
        <h6>Product currency code</h6>
        <br>
        <div class="currency_container">
          <form id="sync_product_currency" class="sync_product_currency" method="POST" >
          <div class="select_curr">
            <select class="sync_currency_name" name="sync_currency_name">
              <?php
                $table_name = $wpdb->prefix . "sync_options";
                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_product_currency_code'));
                foreach ($sync_currency  as $key => $value) {
                  if ( $entries && $entries[0]->option_value==$key) {
                    ?>
                    <option selected value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php
                  }else{
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php
                  }
                }
              ?>
            </select>
          </div>
            <br>
            <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
          </form>
        </div>
    </div>
    <br><hr>
    <div class="sync_advance_paypal_container">
      <form id="sync_paypal_config" method="POST" action="">
        <h6>Paypal settings</h6>
        <br>
        <div class="sync_paypal">
          <?php
            $table_name = $wpdb->prefix . "sync_options";
            $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s", 'sync_paypal_setting'));
          ?>

          <div class="setting_sb_key">
            <label>Sandbox: </label>
            <input type="text" class="input_sb" name="sync_paypal_sandbox" value="<?php echo (!$entries) ? '' : explode("<>", $entries[0]->option_value, 2)[0]; ?>">
          </div>

          <br>

          <div class="setting_pr_key">
            <label>Production: </label>
            <input type="text" class="input_pr" name="sync_paypal_production" value="<?php echo (!$entries) ? '' : explode("<>", $entries[0]->option_value, 3)[1]; ?>">
          </div>
          
          <br>

          <div class="setting_type">
            <label>Use: </label>
            <select class="select_type" name="sync_paypal_use">
              <?php echo (!$entries) ? '<option>Select method</option>' : ''; ?>
              <option value="sandbox" <?php echo (explode("<>", $entries[0]->option_value, 4)[2] == 'sandbox') ? 'selected':''; ?>>Sandbox</option>
              <option value="production" <?php echo (explode("<>", $entries[0]->option_value, 4)[2] == 'production') ? 'selected':''; ?> >Production</option>
            </select>
          </div>

          <br>

          <input type="submit" name="save" class="save-btn btn btn-success" value="Save"/>
        </div>
      </form>
    </div>

    <br><hr>

    <div class="wrap">
      <div class="sync_captcha_form">

        <h6>Captcha Settings</h6>
        <br>
        <div class="captcha_switch">
          <div class="sync_settings_enable captcha">
            <?php
              if ($sync_captcha_enable==false) {
                ?>
                <input type="checkbox" id="sync_captcha_switch" value="on" name="sync_captcha_switch"/>
                <?php
              }else{
              ?>
              <input type="checkbox" id="sync_captcha_switch" value="on" checked name="sync_captcha_switch"/>
              <?php
              }
            ?>
          </div>
        </div>
        <br>
        <br>
        <?php
              if ($sync_captcha_enable==false) {
                ?>
                <div class="captcha_div" style="display:none;">
                <?php
              }else{
              ?>
                <div class="captcha_div">
              <?php
              }
            ?>
        
          <form id="sync_form_captcha" class="sync_product_currency" method="POST" >

            <?php
              $table_name = $wpdb->prefix . "sync_options";
              $site = $wpdb->get_results( $wpdb->prepare("SELECT option_value FROM $table_name WHERE option_name = %s", 'sync_captcha_key'));
              $secret = $wpdb->get_results( $wpdb->prepare("SELECT option_value FROM $table_name WHERE option_name = %s", 'sync_captcha_key_secret'));
            ?>

            <div class="sync_captcha_key">
              <label>Captcha Site Key: </label>
              <input type="text" name="captcha_key" id="captcha_key" value="<?php echo (!$site) ? '' : $site[0]->option_value; ?>">
            </div>
            <br>
            <div class="sync_captcha_key_secret">
              <label>Captcha Secret Key: </label>
              <input type="text" name="captcha_key_secret" id="captcha_key_secret" value="<?php echo (!$secret) ? '' : $secret[0]->option_value; ?>">
            </div>
            <br>
            <input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>
          </form>
        </div>
      </div>
    </div>

    <div class="setting-currency-location">

    <div id="currency-widget"></div>
  </section>
   <?php } ?>        
</main>

<div class="modall fade" id="sync_switch_toggle" tabindex="-1" role="dialog" aria-labelledby="sync_switch_toggleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p>Switching</p>   
      </div>
      <div class="modal-body">     
          <p class="sync-sure">Are you sure?</p>
      </div>
      <div class="modal-footer">
        <form id="" action="">
          <input type="hidden" name="sync_switch" value="">
          <button type="button" class="btn btn-default sync-cancel-switch" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-ok" >Change</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
jQuery(".btn.btn-default.sync-cancel-switch").click( function() {
  location.reload();
}); 
</script>

