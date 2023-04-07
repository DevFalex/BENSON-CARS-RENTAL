<?php
if( ! defined( 'ABSPATH' ) ) exit;
global $wpdb, $sync_hotel_coupon_enable, $sync_car_coupon_enable, $sync_restau_coupon_enable ?>

<h3 class="sync-entries-title">Cancellation Requests</h3>
<main class="sync_backend_cancellation">
  <div class="sync-cancellation-container">

    <input id="cancel_tab1" type="radio" name="tabs" class="sync_tab" checked>
    <label for="cancel_tab1"> Room Bookings </label>
    <input id="cancel_tab2" type="radio" name="tabs" class="sync_tab">
    <label for="cancel_tab2"> Car Rentals </label>
    <input id="cancel_tab3" type="radio" name="tabs" class="sync_tab">
    <label for="cancel_tab3"> Restaurant Reservations </label>

    <section id="hotel_tab">
      <div class="request_div">
        <select name="select_request" id="select_request">
          <option value="0" disabled selected>Select Request... </option>
          <option value="Pending">Pending Requests</option>
          <option value="Approved">Cancelled Requests</option>
        </select>
      </div>
      <div class="sync-table-cancel">
        <table class="table table-striped table-sm" id="hotel_table">
            <thead class="table_head" style="display: none;">
                <tr>
                <th scope="col">Reference Number</th>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Arrival</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="hotel_request_details">
              <tr class="request_details">
              </tr> 
            </tbody>
        </table>
            <h4 class="disp_no_data_hotel" style="text-align:center; display:none;"> --- No Data --- </h4>
      </div>
    </section>

    <section id="car_tab" style="display:none;">
      <div class="request_div_car">
        <select name="select_request_car" id="select_request_car">
          <option value="0" disabled selected>Select Request... </option>
          <option value="Pending">Pending Requests</option>
          <option value="Approved">Cancelled Requests</option>
        </select>
      </div>
      <div class="sync-table-cancel">
        <table class="table table-striped table-sm" id="car_table">
            <thead class="table_head_car" style="display: none;">
                <tr>
                  <th scope="col">Reference Number</th>
                  <th scope="col">Name</th>
                  <th scope="col">Phone Number</th>
                  <th scope="col">Pickup Date</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="car_request_details">
             
            </tbody>
        </table>
          <h4 class="disp_no_data_car" style="text-align:center; display:none;"> --- No Data --- </h4>

      </div>
    </section>

    <section id="restau_tab" style="display:none;">
      <div class="request_div_restau">
        <select name="select_request_restau" id="select_request_restau">
          <option value="0" disabled selected>Select Request... </option>
          <option value="Pending">Pending Requests</option>
          <option value="Approved">Cancelled Requests</option>
        </select>
      </div>
      <div class="sync-table-cancel">
        <table class="table table-striped table-sm" id="restau_table">
            <thead class="table_head_restau" style="display: none;">
                <tr>
                  <th scope="col">Reference Number</th>
                  <th scope="col">Name</th>
                  <th scope="col">Phone Number</th>
                  <th scope="col">Reservation Date</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="restau_request_details">
             
            </tbody>
        </table>
          <h4 class="disp_no_data_restau" style="text-align:center; display:none;"> --- No Data --- </h4>

      </div>
    </section>
  </div>

  <div class="modall fade" id="sync_view_request_hotel" tabindex="-1" role="dialog" aria-labelledby="sync_switch_toggleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">     
          <div class='request_container'>
            <div class="request_title">
            </div>
            <div class="display_body">
              <div class="detail_labels">
                <span>Name: </span>
                <span>Phone Number: </span>
                <span>Email: </span>
                <span>Number of Nights: </span>
                <span>Arrival: </span>
                <span>Departure: </span>
                <span>Number of Guest/s: </span>
                <span>Refund Amount: </span>
                <span>Facility Request: </span>
                <span>Other Request: </span>
                
              </div>
              <div class="request_details">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success sync-approve-request" id="" >Approve</button>
            <button type="button" class="btn btn-danger sync-decline-request" id="" >Decline</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modall sync-transform fade sync-modal-booking-info" id="request_approved" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_hotel" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Approved.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel booking is approved. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modall sync-transform fade sync-modal-booking-info" id="request_declined" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_hotel" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Declined.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel booking is declined. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- car modals -->

  <div class="modall fade" id="sync_view_request_car" tabindex="-1" role="dialog" aria-labelledby="sync_switch_toggleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">     
          <div class='request_container'>
            <div class="request_title">
            </div>
            <div class="display_body">
              <div class="detail_labels">
                <span>Name: </span>
                <span>Phone Number: </span>
                <span>Email: </span>
                <span>Number of Days: </span>
                <span>Pickup Date: </span>
                <span>Return Date: </span>
                <span>Refund Amount: </span>
                <span>Facility Request: </span>
                <span>Other Request: </span>
                
              </div>
              <div class="request_details">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success sync-approve-request" id="" >Approve</button>
            <button type="button" class="btn btn-danger sync-decline-request" id="" >Decline</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modall sync-transform fade sync-modal-booking-info" id="request_approved_car" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_car" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Approved.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel car rental is approved. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modall sync-transform fade sync-modal-booking-info" id="request_declined_car" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_car" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Declined.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel car rental is declined. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- restau modals -->

  <div class="modall fade" id="sync_view_request_restau" tabindex="-1" role="dialog" aria-labelledby="sync_switch_toggleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">     
          <div class='request_container'>
            <div class="request_title">
            </div>
            <div class="display_body">
              <div class="detail_labels">
                <span>Phone Number: </span>
                <span>Email: </span>
                <span>Reservation Date: </span>
                <span>Timeslot: </span>
                <span>Branch: </span>
                <span>Refund Amount: </span>
                <span>Menu Reserved: </span>
                
              </div>
              <div class="request_details">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success sync-approve-request" id="" >Approve</button>
            <button type="button" class="btn btn-danger sync-decline-request" id="" >Decline</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modall sync-transform fade sync-modal-booking-info" id="request_approved_restau" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_restau" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Approved.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel reservation is approved. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modall sync-transform fade sync-modal-booking-info" id="request_declined_restau" tabindex="-1" role="dialog" aria-labelledby="customer-infoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document" data-keyboard="false">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_restau" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-bodyy">
          <div class="cancel_content">
            <div class="cancel_body">
              <h1>Request for Cancellation Declined.</h1>
              <div class="sub_content">
                <span class="content">The request to cancel reservation is declined. An email will be sent to the requestor.</span>
              </div>
              <br>
              <div class="button_close" style="text-align:center;">
                <input class="close_modal reload-page" type="button" value="Close">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<script>

jQuery(document).ready(function() {

  jQuery("#cancel_tab1").change( function () {

    var tmp_hotel = jQuery("#cancel_tab1").is(':checked');
    if (tmp_hotel == true ) {
      jQuery("#hotel_tab").show();
      jQuery("#car_tab").hide();
      jQuery("#restau_tab").hide();
    } 
    else {
      jQuery("#hotel_tab").hide();
    }
  });
  
  jQuery("#cancel_tab2").change( function () {

    var tmp_car =  jQuery("#cancel_tab2").is(':checked');

    if (tmp_car == true ) {
      jQuery("#car_tab").show();
      jQuery("#restau_tab").hide();
      jQuery("#hotel_tab").hide();
    } 
    else {
      jQuery("#car_tab").hide();
    }
  });
  
  jQuery("#cancel_tab3").change( function () {

    var tmp_restau =  jQuery("#cancel_tab3").is(':checked');

    if (tmp_restau == true ) {
      jQuery("#restau_tab").show();
      jQuery("#car_tab").hide();
      jQuery("#hotel_tab").hide();
    } 
    else {
      jQuery("#restau_tab").hide();
    }
  });
  
});

jQuery("#select_request").change( function() {
  var stat = jQuery(this).val();

  if (stat == 'Approved') {
    jQuery("#sync_view_request_hotel .modal-footer").hide();
  }
  else {
    jQuery("#sync_view_request_hotel .modal-footer").show();
  }

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_hotel_requests", stat: stat},
    success: function(data){

      if (data != "") {
        jQuery(".sync-table-cancel .disp_no_data_hotel").hide();
        jQuery("#hotel_table .table_head").show();
        jQuery("#hotel_table .hotel_request_details").empty();
        jQuery("#hotel_table .hotel_request_details").append("<tr class='request_details'><td>"+ data[0].reference_num +"</td><td>"+ data[0].name +"</td><td>"+ data[0].phone_number +"</td><td>"+ data[1].arrival_date +"</td><td><button type='button' id='view_request' value='"+data[0].id+"' class='view-btn btn btn-success'>View</button></td></tr>");
      }

      if (data == "") {
        jQuery("#hotel_table .hotel_request_details tr").empty();
        jQuery(".sync-table-cancel .disp_no_data_hotel").show();
        jQuery("#hotel_table .table_head").show();
      }

    }
  });
});

jQuery("#select_request_car").change( function() {
  var stat = jQuery(this).val();

  if (stat == 'Approved') {
    jQuery("#sync_view_request_car .modal-footer").hide();
  }
  else {
    jQuery("#sync_view_request_car .modal-footer").show();
  }

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_car_requests", stat: stat},
    success: function(data){

      if (data != "") {
        jQuery(".sync-table-cancel .disp_no_data_car").hide();
        jQuery("#car_table .table_head_car").show();
        jQuery("#car_table .car_request_details").empty();
        for (let i = 0; i < data.length; i+=2) {
          jQuery("#car_table .car_request_details").append("<tr class='request_details'><td>"+ data[i].reference_num +"</td><td>"+ data[i].name +"</td><td>"+ data[i].phone_number +"</td><td>"+ data[i+1].pick_date +"</td><td><button type='button' id='view_request_car' value='"+data[i].id+"' class='view-btn btn btn-success'>View</button></td></tr>");
        }
      }

      if (data == "") {
        jQuery("#car_table .car_request_details tr").empty();
        jQuery(".sync-table-cancel .disp_no_data_car").show();
        jQuery("#car_table .table_head_car").show();
      }

    }
  });
});

jQuery("#select_request_restau").change( function() {
  var stat = jQuery(this).val();

  if (stat == 'Approved') {
    jQuery("#sync_view_request_restau .modal-footer").hide();
  }
  else {
    jQuery("#sync_view_request_restau .modal-footer").show();
  }

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_restau_requests", stat: stat},
    success: function(data){

      if (data != "") {
        jQuery(".sync-table-cancel .disp_no_data_restau").hide();
        jQuery("#restau_table .table_head_restau").show();
        jQuery("#restau_table .restau_request_details").empty();
        for (let i = 0; i < data.length; i+=2) {
          jQuery("#restau_table .restau_request_details").append("<tr class='request_details'><td>"+ data[i].reference_num +"</td><td>"+ data[i].name +"</td><td>"+ data[i].phone_number +"</td><td>"+ data[i+1].pick_date +"</td><td><button type='button' id='view_request_restau' value='"+data[i].id+"' class='view-btn btn btn-success'>View</button></td></tr>");
        }
      }

      if (data == "") {
        jQuery("#restau_table .restau_request_details tr").empty();
        jQuery(".sync-table-cancel .disp_no_data_restau").show();
        jQuery("#restau_table .table_head_restau").show();
      }

    }
  });
});

jQuery(document).on('click', '#view_request', function() {
  var id = jQuery(this).val();
  jQuery('#sync_view_request_hotel').modal('show');

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_request_details", id: id},
    success: function(data){
      
      if (data[0].status == 'Approved') {
        jQuery("#sync_view_request_hotel .modal-footer").hide();
      }
      else {
        jQuery("#sync_view_request_hotel .modal-footer").show();
      }

      jQuery('#sync_view_request_hotel .sync-approve-request').attr('id', data[0].id);
      jQuery('#sync_view_request_hotel .sync-decline-request').attr('id', data[0].id);
      jQuery("#sync_view_request_hotel .modal-body .request_details").empty();
      jQuery("#sync_view_request_hotel .modal-body .request_title").empty();

      jQuery("#sync_view_request_hotel .modal-body .request_title").append("<h3>"+ data[2] +"</h3><span>"+ data[0].reference_num +"</span>");
      jQuery("#sync_view_request_hotel .modal-body .request_details").append("<span>"+ data[0].name +"</span><span>"+ data[0].phone_number +"</span><span>"+ data[0].email_add +"</span><span>"+ data[1].night_number +"</span><span>"+ data[1].arrival_date +"</span><span>"+ data[1].departure_date +"</span><span>"+ data[1].guest_number +"</span><span>"+ data[3] +" "+data[4]+"</span><span>"+ data[1].facility_request +"</span><span>"+ data[1].other_req +"</span>");

    }
  });
});

jQuery(document).on('click', '#view_request_car', function() {
  var id = jQuery(this).val();
  jQuery('#sync_view_request_car').modal('show');

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_request_details_car", id: id},
    success: function(data){
      
      if (data[0].status == 'Approved') {
        jQuery("#sync_view_request_car .modal-footer").hide();
      }
      else {
        jQuery("#sync_view_request_car .modal-footer").show();
      }

      jQuery('#sync_view_request_car .sync-approve-request').attr('id', data[0].id);
      jQuery('#sync_view_request_car .sync-decline-request').attr('id', data[0].id);
      jQuery("#sync_view_request_car .modal-body .request_details").empty();
      jQuery("#sync_view_request_car .modal-body .request_title").empty();

      jQuery("#sync_view_request_car .modal-body .request_title").append("<h3>"+ data[2] +"</h3><span>"+ data[0].reference_num +"</span>");
      jQuery("#sync_view_request_car .modal-body .request_details").append("<span>"+ data[0].name +"</span><span>"+ data[0].phone_number +"</span><span>"+ data[0].email_add +"</span><span>"+ data[1].number_days +"</span><span>"+ data[1].pick_date +"</span><span>"+ data[1].return_date +"</span><span>"+data[3]+ " "+data[4]+"</span><span>"+ data[1].facility_request +"</span><span>"+ data[1].other_req +"</span>");
      
    }
  });
});

jQuery(document).on('click', '#view_request_restau', function() {
  var id = jQuery(this).val();
  jQuery('#sync_view_request_restau').modal('show');

  jQuery.ajax({
    type: "POST",
    dataType: "json",    
    url: easync_admin_ajax_directory.ajaxurl,
    data: { action: "view_request_details_restau", id: id},
    success: function(data){
      
      if (data[0].status == 'Approved') {
        jQuery("#sync_view_request_restau .modal-footer").hide();
      }
      else {
        jQuery("#sync_view_request_restau .modal-footer").show();
      }

      jQuery('#sync_view_request_restau .sync-approve-request').attr('id', data[4]);
      jQuery('#sync_view_request_restau .sync-decline-request').attr('id', data[4]);
      jQuery("#sync_view_request_restau .modal-body .request_details").empty();
      jQuery("#sync_view_request_restau .modal-body .request_title").empty();

      jQuery("#sync_view_request_restau .modal-body .request_title").append("<h3>"+ data[1][0].name +"</h3><span>"+ data[1][0].reference_number +"</span>");
      jQuery("#sync_view_request_restau .modal-body .request_details").append("<span>"+ data[1][0].phone +"</span><span>"+ data[1][0].email +"</span><span>"+ data[1][0].pick_date +"</span><span>"+ data[1][0].timeslot +"</span><span>"+ data[1][0].branch +"</span><span>"+data[4]+ " "+data[3]+"</span><span>"+data[2]+"</span>");
      
      for( let i = 0; i < data[1][0].length; i++) {
        jQuery("#sync_view_request_restau .modal-body .request_details").append("<span>" + data[1][0][i] + "</span>");
      }
    }
  });
});

jQuery('#request_approved .reload-page').click( function () {
  location.reload(); 
}) 

jQuery('#request_declined .reload-page').click( function () {
  location.reload(); 
}) 

jQuery('#request_approved_car .reload-page').click( function () {
  location.reload(); 
}) 

jQuery('#request_declined_car .reload-page').click( function () {
  location.reload(); 
}) 

jQuery('#request_approved_restau .reload-page').click( function () {
  location.reload(); 
}) 

jQuery('#request_declined_restau .reload-page').click( function () {
  location.reload(); 
}) 

</script>


