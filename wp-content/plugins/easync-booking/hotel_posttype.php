<?php

if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'init', 'easyncHotelRoomInit' );

function easyncHotelRoomInit() {

$labels = array(
    'name'               => 'eaSYNC Hotel Room',
    'singular_name'      => 'eaSYNC Hotel Room',
    'add_new'            => 'Add New Room',
    'add_new_item'       => 'Add New Room',
    'edit_item'          => 'Edit Room',
    'new_item'           => 'New Room',
    'all_items'          => 'All Rooms',
    'view_item'          => 'View Room',
    'search_items'       => 'Search Rooms',
    'not_found'          => 'No Rooms Found',
    'not_found_in_trash' => 'No Rooms found in Trash', 
    'parent_item_colon'  => '',
    'menu_name'          => 'eaSYNC Hotel',
);

$capabilities =  array('post');
$capabilities_var = 'capabilities_type';
if(!is_super_admin()) {
    $labels = array(
        'name'               => _x( 'Sync Hotel Room', 'post type general name', 'sync_privilage' ),
        'singular_name'      => _x( 'Sync Hotel Room', 'post type singular name', 'sync_privilage' ),
        'menu_name'          => _x( 'eaSYNC Hotel', 'admin menu', 'sync_booking_privilage' ),
        'name_admin_bar'     => _x( 'eaSYNC Hotel Room', 'add new on admin bar', 'sync_privilage' ),
        'add_new'            => _x( 'Add New', 'room', 'sync_privilage' ),
        'add_new_item'       => __( 'Add New Room', 'sync_privilage' ),
        'new_item'           => __( 'New Room', 'sync_privilage' ),
        'edit_item'          => __( 'Edit Room', 'sync_privilage' ),
        'view_item'          => __( 'View Room', 'sync_privilage' ),
        'all_items'          => __( 'All Rooms', 'sync_privilage' ),
        'search_items'       => __( 'Search Rooms', 'sync_privilage' ),
        'parent_item_colon'  => __( '', 'sync_privilage' ),
        'not_found'          => __( 'No Room Found.', 'sync_privilage' ),
        'not_found_in_trash' => __( 'No Room found in Trash.', 'sync_privilage' ),
    );
   $capabilities = array(
            'edit_others_posts'     => 'edit_others_contacts',
            'delete_others_posts'   => 'delete_others_contacts',
            'delete_private_posts'  => 'delete_private_contacts',
            'edit_private_posts'    => 'edit_private_contacts',
            'read_private_posts'    => 'read_private_contacts',
            'edit_published_posts'  => 'edit_published_contacts',
            'publish_posts'         => 'publish_contacts',
            'delete_published_posts'=> 'delete_published_contacts',
            'edit_posts'            => 'edit_contacts'   ,
            'delete_posts'          => 'delete_contacts',
            'edit_post'             => 'edit_contact',
            'read_post'             => 'read_contact',
            'delete_post'           => 'delete_contact',

        );
   $capabilities_var = 'capabilities';
}
    
    $args = array(
        'labels'          => $labels,
        'public'          => false,
        'has_archive'     => false,
        'publicly_queryable' => false,
        'show_ui'         => true,
        $capabilities_var => $capabilities,
        'map_meta_cap' => true,
        'show_in_menu' => true,
        'hierarchical'    => false,
        'rewrite'         => array('slug' => 'Room'),
        'query_var'       => true,
        'menu_icon'       => 'dashicons-building',
        'supports'        => array(
            'title',
            'editor',
            //'excerpt',
            'trackbacks',
            //'comments',
            'revisions',
            'thumbnail',
            'author',
            //'page-attributes'
        )
    );
    register_post_type( 'easync_hotel_room', $args );
    
    // register taxonomy
    //register_taxonomy('sync_hotel_room_category', 'sync_hotel_room', array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array( 'slug' => 'sync-hotel-room-category' )));
}

add_action( 'add_meta_boxes', 'easyncHotelFieldsMetabox' );

function easyncHotelFieldsMetabox() {
    
    // add_meta_box(
    //     'sync_hotel_meta_box',
    //     'Description', 
    //     'Repeatable_meta_box_display',
    //     'sync_hotel_room',
    //     'normal',
    //     'high'
    // );
    add_meta_box(
        'easync_hotel_meta_box',
        'Price and more', 
        'easyncShowHotelFieldsMetaBox', 
        'easync_hotel_room',
        'normal',
        'high'
    );
}



function easyncShowHotelFieldsMetaBox() {
    global $post, $sync_product_currency;  
    $meta = get_post_meta( $post->ID, 'easync_hotel', true ); 
    ?>
    <input type="hidden" name="sync_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

    <p>
        <label for="easync_hotel[avail]">Available</label>
        <br>
        <select style="width:100%;" name="easync_hotel[avail]" id="easync_hotel[avail]">
            <option value="Yes" 
            <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <p>
        <label for="easync_hotel[number_room]">Total rooms</label>
        <br>
        <input style="width:100%;" type="number" min="0" name="easync_hotel[number_room]" id="easync_hotel[number_room]" class="regular-text" 
        value="<?php if(!empty($meta['number_room'])) echo $meta['number_room']; else echo '0'; ?>" >
    </p>  

    <p>
        <label for="easync_hotel[number_bed]">Number of Beds</label>
        <br>
        <input style="width:100%;" type="number" min="0" name="easync_hotel[number_bed]" id="easync_hotel[number_bed]" class="regular-text" 
        value="<?php if(!empty($meta['number_bed'])) echo $meta['number_bed']; else echo '0'; ?>" >
    </p>  

    <p>
        <label for="easync_hotel[measurement]">Room Measurement</label>
        <br>
        <input style="width:100%;" type="text" name="easync_hotel[measurement]" id="easync_hotel[measurement]" class="regular-text"
        value="<?php if(!empty($meta['measurement'])) echo $meta['measurement']; else echo ''; ?>" >
    </p>  

    <p>
        <label for="easync_hotel[price]">Room Price (without ',') Currency: <?php echo $sync_product_currency; ?></label>
        <br>
        <input style="width:100%;" type="number" min="0" name="easync_hotel[price]" step="0.01" id="easync_hotel[price]" class="regular-text" 
        value="<?php if(!empty($meta['price'])) echo $meta['price']; else echo '0'; ?>" >
    </p>

    <p>
        <label for="easync_hotel[capacity]">Number of guests allowed</label>
        <br>
        <input style="width:100%;" type="number" min="1" name="easync_hotel[capacity]" id="easync_hotel[capacity]" class="regular-text" 
        value="<?php if(!empty($meta['capacity'])) echo $meta['capacity']; else echo '1'; ?>" >
    </p>

    <label>Amenities:</label>
    <?php
    $gpminvoice_group = get_post_meta($post->ID, 'sync_customdata_group', true);
     wp_nonce_field( 'gpm_repeatable_meta_box_nonce', 'gpm_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function(  jQuery ){
         jQuery( '#add-row' ).on('click', function() {
            var row =  jQuery( '.empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

         jQuery( '.remove-row' ).on('click', function() {
             jQuery(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="repeatable-fieldset-one" width="100%">
      <tbody>
        <?php
         if ( $gpminvoice_group ) :
          foreach ( $gpminvoice_group as $field ) {
        ?>
        <tr>
          <td width="95%">
            <input style="width:100%;" type="text"  placeholder="Title" name="TitleItem[]" value="<?php if($field['TitleItem'] != '') echo esc_attr( $field['TitleItem'] ); ?>" /></td> 
          <td width="5%"><a class="button remove-row" href="#1">Remove</a></td>
        </tr>
        <?php
        }
        else :
        // show a blank one
        ?>
        <tr>
          <td width="95%"> 
            <input style="width:100%;" type="text" placeholder="Item" title="Title" name="TitleItem[]" /></td>
          <td width="5%"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="empty-row screen-reader-text">
          <td width="95%">
            <input style="width:100%;" type="text" placeholder="Item" name="TitleItem[]"/></td>
          <td width="5%"><a class="button remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>
    <p><a id="add-row" class="button" href="#">New</a></p>

    <label>Special request(checkbox generated to frontend):</label>
    <?php
    $special_gpminvoice_group = get_post_meta($post->ID, 'sync_specialrequest_group', true);
     wp_nonce_field( 'gpm_specialrequest_repeatable_meta_box_nonce', 'gpm_specialrequest_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function(  jQuery ){
         jQuery( '#special-add-row' ).on('click', function() {
            var row =  jQuery( '.special-empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#special-repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

         jQuery( '.special-remove-row' ).on('click', function() {
             jQuery(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="special-repeatable-fieldset-one" width="100%">
      <tbody>
        <?php
         if ( $special_gpminvoice_group ) :
          foreach ( $special_gpminvoice_group as $field ) {
        ?>
        <tr>
          <td width="95%">
            <input style="width:100%;" type="text"  placeholder="Title" name="specialrequest[]" value="<?php if($field['specialrequest'] != '') echo esc_attr( $field['specialrequest'] ); ?>" />
            </td>
          <td width="5%"><a class="button remove-row" href="#1">Remove</a></td>
        </tr>
        <?php
        }
        else :
        // show a blank one
        ?>
        <tr>
          <td width="95%"> 
            <input style="width:100%;" type="text" placeholder="Item" title="Title" name="specialrequest[]" />
            </td>
          <td width="5%"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="special-empty-row screen-reader-text">
          <td width="95%">
            <input style="width:100%;" type="text" placeholder="Item" name="specialrequest[]"/>
           </td>
          <td width="5%"><a class="button special-remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>
    <p><a id="special-add-row" class="button" href="#">New</a></p>


    <label>Room Images:</label>
    <?php
    $room_images_gpminvoice_group = get_post_meta($post->ID, 'sync_room_images_group', true);
     wp_nonce_field( 'gpm_room_images_repeatable_meta_box_nonce', 'gpm_room_images_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function(  jQuery ){
        $count = jQuery("#room-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new").attr('data-key');
         jQuery( '#room-images-add-row' ).on('click', function() {
            
            var row =  jQuery( '.room-images-empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#room-images-repeatable-fieldset-one tbody>tr:last' );

            $count++;

            var secondlast = jQuery("#room-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new");
            var secondlastinput = jQuery("#room-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new input");
            
            secondlast.attr('id', $count+'_wrapper');
            secondlast.attr('data-key', $count);
            secondlastinput.attr('id', $count);
            return false;
        });

         jQuery( '.room-images-remove-row' ).on('click', function() {
             jQuery(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="room-images-repeatable-fieldset-one" width="30%">
      <tbody>
        <?php
        $counter = 0;
         if ( $room_images_gpminvoice_group ) :
          foreach ( $room_images_gpminvoice_group as $key => $field ) {
            $counter = $key;
        ?>
        <tr>
          <td width="15%">

            <div class="custom_postimage_wrapper" id="<?php echo $key; ?>_wrapper" style="margin-bottom:20px;">
                <img src="<?php echo ($field['room_images']!=''?wp_get_attachment_image_src( $field['room_images'])[0]:''); ?>" style="width:100%;display: <?php echo ($field['room_images']!=''?'block':'none'); ?>" alt="">
                <a class="addimage button" onclick="custom_postimage_add_image('<?php echo $key; ?>');"><?php _e('update image','yourdomain'); ?></a><br>
                <input type="hidden" name="room_images[]" id="<?php echo $key; ?>" value="<?php echo $field['room_images']; ?>" />
            </div>

            </td>
          <td width="15%"><a class="button remove-row" href="#1">Remove</a></td>
        </tr>
        <?php
        }
        else :
        // show a blank one
        ?>
        <tr>
          <td> 
            <div class="custom_postimage_wrapper add-new" id="1_wrapper" data-key="1" style="margin-bottom:20px;">
                <img src="" style="width:100%;display:'none'); ?>" alt="">
                <a class="addimage button new" ><?php _e('add image','yourdomain'); ?></a><br>
                <input type="hidden" name="room_images[]" id="1" value="" />
            </div>
            </td>
          <td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="room-images-empty-row screen-reader-text">
          <td>
             <div class="custom_postimage_wrapper add-new" id="" data-key="<?php echo ($counter==0 ? 0 : $counter)?>" style="margin-bottom:20px;">
                <img src="" style="width:100%;display: 'none'" alt="">
                <a class="addimage button new" ><?php _e('add image','yourdomain'); ?></a><br>
                <input type="hidden" name="room_images[]" id="" value="" />
            </div>
           </td>
          <td><a class="button room-images-remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>
    <p><a id="room-images-add-row" class="button" href="#">New</a></p>

    <script>
        jQuery(document).ready(function(e) {
            jQuery('.addimage.button.new').on('click', function(e){
               var key = jQuery(this).parent().attr('data-key');
               custom_postimage_add_image(key);
            });
        });
    function custom_postimage_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('select image','yourdomain'); ?>',
            button: {
                text: '<?php _e('select image','yourdomain'); ?>'
            },
            multiple: false
        });
        custom_postimage_uploader.on('select', function() {

            var attachment = custom_postimage_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
        });
        custom_postimage_uploader.on('open', function(){
            var selection = custom_postimage_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_postimage_uploader.open();
        jQuery('#'+key+'_wrapper a').text('update image');
        return false;
    }
    </script>



    <p>
        <label for="easync_hotel[writemsg]">Enable 'Others' Option (for special requests)</label>
        <br>
        <select style="width: 100%" name="easync_hotel[writemsg]" id="easync_hotel[writemsg]">
            <option value="Yes" 
            <?php if(!empty($meta['writemsg'])) selected( $meta['writemsg'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['writemsg'])) selected( $meta['writemsg'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <p>
        <label for="easync_hotel[notes]">Notes</label>
        <br>
        <textarea style="width:100%;" name="easync_hotel[notes]" rows="5" cols="30" id="easync_hotel[notes]" style="width:500px; resize:none;"><?php if(!empty($meta['notes'])) echo $meta['notes']; ?></textarea>
    </p>

    
    <?php

}


add_action( 'save_post', 'easyncSaveHotelMeta' );

function easyncSaveHotelMeta( $post_id ) {   

    if ( !wp_verify_nonce( $_POST['sync_meta_box_nonce'], basename(__FILE__) ) ) {
        return $post_id; 
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'page' === $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }  
    }
    
    $old = get_post_meta( $post_id, 'easync_hotel', true );
    $new = array();
    $Items = $_POST['easync_hotel'];
    $new['avail'] = stripslashes( strip_tags( sanitize_text_field($Items['avail']) ) );
    $new['number_room'] = stripslashes( strip_tags( intval($Items['number_room']) ) );
    $new['number_bed'] = stripslashes( strip_tags( intval($Items['number_bed']) ) );
    $new['measurement'] = stripslashes( strip_tags( sanitize_text_field($Items['measurement']) ) );
    $new['price'] = stripslashes( strip_tags( $Items['price'] ) );
    $new['capacity'] = stripslashes( strip_tags( intval($Items['capacity']) ) );
    $new['writemsg'] = stripslashes( strip_tags( sanitize_text_field($Items['writemsg']) ) );
    $new['notes'] = stripslashes( strip_tags( sanitize_text_field($Items['notes']) ) );

    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'easync_hotel', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'easync_hotel', $old );
    }

    if (!isset($_POST['gpm_repeatable_meta_box_nonce'])  ||
    ! wp_verify_nonce( $_POST['gpm_repeatable_meta_box_nonce'], 'gpm_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'sync_customdata_group', true);
    $new = array();
    $Items = $_POST['TitleItem'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['TitleItem'] = stripslashes( strip_tags( sanitize_text_field( $Items[$i]) ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'sync_customdata_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'sync_customdata_group', $old );



    if ( !isset($_POST['gpm_specialrequest_repeatable_meta_box_nonce'])  ||
    ! wp_verify_nonce($_POST['gpm_specialrequest_repeatable_meta_box_nonce'], 'gpm_specialrequest_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'sync_specialrequest_group', true);
    $new = array();
    $Items = $_POST['specialrequest'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['specialrequest'] = stripslashes( strip_tags( sanitize_text_field( $Items[$i]) ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'sync_specialrequest_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'sync_specialrequest_group', $old );



    if ( !isset($_POST['gpm_room_images_repeatable_meta_box_nonce']) ||
    ! wp_verify_nonce($_POST['gpm_room_images_repeatable_meta_box_nonce'], 'gpm_room_images_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'sync_room_images_group', true);
    $new = array();
    $Items = $_POST['room_images'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['room_images'] = stripslashes( strip_tags( sanitize_text_field($Items[$i]) ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'sync_room_images_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'sync_room_images_group', $old );

}


