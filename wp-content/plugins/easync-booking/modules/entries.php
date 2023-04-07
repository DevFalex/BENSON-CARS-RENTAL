<?php 
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $post, $sync_hotel_enable, $sync_car_enable, $sync_restau_enable;
?>

<h3 class="sync-entries-title">Customer Entries</h3>
<main class="sync_backend_entries">
  <div class="sync_color_define">
      <p>Active</p>
      <p>Inactive</p>
      <p>Pending</p>
      <p>Trash</p>
      <p>Cancelled</p>
  </div>

  <?php
    if($sync_hotel_enable==true) {
  ?>
  <input id="tab1" type="radio" name="tabs" class="sync_tab" checked>
  <label for="tab1"><i class="fa fa-bed"></i> Hotel Room</label>
  <?php
    }
    if($sync_car_enable==true) {
        if($sync_hotel_enable==false) {
        ?>
            <input id="tab2" type="radio" name="tabs" checked class="sync_tab">
        <?php
        }else{
        ?>
            <input id="tab2" type="radio" name="tabs" class="sync_tab">
        <?php  
        }  
  ?>
  <label for="tab2"><i class="fa fa-car"></i> Car Rent</label>
  <?php
    }
    if($sync_restau_enable==true) {
        if($sync_car_enable==false){
        ?>
            <input id="tab3" type="radio" name="tabs" checked class="sync_tab">
        <?php
        }else{
        ?>
            <input id="tab3" type="radio" name="tabs" class="sync_tab">
        <?php
    }
  ?>  
  <label for="tab3"><i class="fa fa-spoon"></i> Restaurant Reservation</label>
  <?php
    }
    if($sync_hotel_enable==true) {
  ?>   
  <section id="content1">
    <div class="sync_search_calendar">
        <button class="fc-prev-button fc-button fc-state-default fc-corner-left" id="prev-year">Prev year</button>
        <button class="fc-prev-button fc-button fc-state-default fc-corner-right" id="next-year">Next year</button>
        <select class="fc-prev-button fc-button fc-state-default fc-corner-left" id="months-tab">
            <option data-month="0">Select month</option>
            <?php
                $table_name = $wpdb->prefix . "sync_hotel_entries";
                $entries = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE status = %s ORDER BY id DESC", 'pending'));
                $data['count'] = $wpdb->num_rows;
                if ( ! $entries ) {
                $wpdb->print_error(); 
            }else {
                $month = array();
                foreach ($entries as $key => $item) {
                    $month[$key] = substr($item->arrival_date, 0, 2);
                }
                foreach (array_unique($month) as $key => $value) {
                   $monthNum  = $value;
                   $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                   $monthName = $dateObj->format('F'); // March
                   ?><option data-month="<?php echo $monthNum-1; ?>"><?php echo $monthName; ?></option><?php
                }
            }
            ?>
        </select>
    </div>
    <div id='sync_hotel_calendar'></div>
  </section>
  <?php
    }
    if($sync_car_enable==true) {
  ?>  
  <section id="content2">
    <div class="sync_search_calendar">
        <button class="fc-prev-button fc-button fc-state-default fc-corner-left" id="prev-year2">Prev year</button>
        <button class="fc-prev-button fc-button fc-state-default fc-corner-right" id="next-year2">Next year</button>
        <select class="fc-prev-button fc-button fc-state-default fc-corner-left" id="months-tab2">
            <option data-month="0">Select month</option>
            <?php
                $table_name = $wpdb->prefix . "sync_rent_car_entries";
                $entries = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE status = %s ORDER BY id DESC", 'pending'));
                $data['count'] = $wpdb->num_rows;
                if ( ! $entries ) {
                $wpdb->print_error(); 
            }else {
                $month = array();
                foreach ($entries as $key => $item) {
                    $month[$key] = substr($item->pick_date, 0, 2);
                }
                foreach (array_unique($month) as $key => $value) {
                   $monthNum  = $value;
                   $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                   $monthName = $dateObj->format('F'); // March
                   ?><option data-month="<?php echo $monthNum-1; ?>"><?php echo $monthName; ?></option><?php
                }
            }
            ?>
        </select>
    </div>
    <div id='sync_car_rental_calendar'></div>
  </section>
  <?php
    }
    if($sync_restau_enable==true) {
  ?>   
  <section id="content3">
    <div class="sync_search_calendar">
        <button class="fc-prev-button fc-button fc-state-default fc-corner-left" id="prev-year3">Prev year</button>
        <button class="fc-prev-button fc-button fc-state-default fc-corner-right" id="next-year3">Next year</button>
        <select class="fc-prev-button fc-button fc-state-default fc-corner-left" id="months-tab3">
            <option data-month="0">Select month</option>
            <?php
                $table_name = $wpdb->prefix . "sync_restau_entries";
                $entries = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE status = %s ORDER BY id DESC", 'pending'));
                $data['count'] = $wpdb->num_rows;
                if ( ! $entries ) {
                $wpdb->print_error(); 
            }else {
                $month = array();
                foreach ($entries as $key => $item) {
                    $month[$key] = substr($item->pick_date, 0, 2);
                }
                foreach (array_unique($month) as $key => $value) {
                   $monthNum  = $value;
                   $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                   $monthName = $dateObj->format('F'); // March
                   ?><option data-month="<?php echo $monthNum-1; ?>"><?php echo $monthName; ?></option><?php
                }
            }
            ?>
        </select>
    </div>
    <div id='sync_restau_calendar'></div>
  </section>
  <?php
    }
  ?> 
<input type="hidden" data-value="" class="sync_calendar_single_view">      
</main>
<div class="modall fade" id="single_view_entry_modal" tabindex="-1" role="dialog" aria-labelledby="single-view-entryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-bodyy">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="modal-header">
                  <h4 class="modal-title">Full Details</h4>
                </div>
                <div class="data-container">         
                </div>
                <div class="modal-footer">
                    <form id="sync_reserved_event" method="POST" action="">
                        <input type="hidden" name="reserve_event_id" value="">
                        <input type="hidden" name="reserve_event_option" value="">
                        <input type="hidden" name="type" value="">
                        <button id="sync_activator" class="btn btn-primary sync_color_orange"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


