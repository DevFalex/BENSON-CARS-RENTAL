<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="modal fade" id="car_thank_you_modal" tabindex="-1" role="dialog" aria-labelledby="thank-youLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <center><h2>Thank you for choosing <?php echo get_bloginfo( 'name' );?></h2></center>
                        <center><h3>For any concerns regarding your booking, please email us at <?php echo get_option('admin_email'); ?>.</h3></center>
                  </div>
            </div>
      </div>
</div>