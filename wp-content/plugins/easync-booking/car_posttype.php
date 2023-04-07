<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'init', 'easyncCarRentalInit' );
function easyncCarRentalInit() {
$labels = array(
        'name'               => 'eaSYNC Car Rental',
        'singular_name'      => 'eaSYNC Car Rental',
        'add_new'            => 'Add New Car',
        'add_new_item'       => 'Add New Car',
        'edit_item'          => 'Edit Car',
        'new_item'           => 'New Car',
        'all_items'          => 'All Cars',
        'view_item'          => 'View Car',
        'search_items'       => 'Search Cars',
        'not_found'          => 'No Cars Found',
        'not_found_in_trash' => 'No Cars found in Trash', 
        'parent_item_colon'  => '',
        'menu_name'          => 'eaSYNC Car',
    );
$capabilities =  array('post');
$capabilities_var = 'capabilities_type';
if(!is_super_admin()) {
    $labels = array(
        'name'               => _x( 'eaSYNC Car Rentals', 'post type general name', 'sync_privilage' ),
        'singular_name'      => _x( 'eaSYNC Rental', 'post type singular name', 'sync_privilage' ),
        'menu_name'          => _x( 'eaSYNC Car Rentals', 'admin menu', 'sync_privilage' ),
        'name_admin_bar'     => _x( 'eaSYNC Car Rental', 'add new on admin bar', 'sync_privilage' ),
        'add_new'            => _x( 'Add New', 'car', 'sync_privilage' ),
        'add_new_item'       => __( 'Add New Car', 'sync_privilage' ),
        'new_item'           => __( 'New Car', 'sync_privilage' ),
        'edit_item'          => __( 'Edit Car', 'sync_privilage' ),
        'view_item'          => __( 'View Car', 'sync_privilage' ),
        'all_items'          => __( 'All Cars', 'sync_privilage' ),
        'search_items'       => __( 'Search Cars', 'sync_privilage' ),
        'parent_item_colon'  => __( '', 'sync_privilage' ),
        'not_found'          => __( 'No Cars Found.', 'sync_privilage' ),
        'not_found_in_trash' => __( 'No Cars found in Trash.', 'sync_privilage' ),
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
        'labels'             => $labels,
        'has_archive'        => false,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        $capabilities_var    => $capabilities,
        'map_meta_cap' => true,
        'show_in_menu' => true,
        'hierarchical'       => false,
        'rewrite'            => array('slug' => 'Car'),
        'query_var'          => true,
        'menu_icon'          => 'dashicons-car',
        'supports'           => array(
            'title',
            'excerpt',
            'thumbnail',
            'author',
        )
    );
    register_post_type( 'easync_car_rental', $args );

}

add_action( 'add_meta_boxes', 'easyncCarFieldsMetabox' );

function easyncCarFieldsMetabox() {
    add_meta_box(
        'easync_car_meta_box',
        'Price and more', 
        'easyncShowCarFieldsMetaBox', 
        'easync_car_rental',
        'normal',
        'high'
    );
}


function easyncShowCarFieldsMetaBox() {
    global $post, $sync_product_currency, $wpdb;  
    $meta = get_post_meta( $post->ID, 'easync_car', true ); 
    ?>
    <input type="hidden" name="sync_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

    <p>
        <label for="easync_car[avail]">Available</label>
        <br>
        <select style="width:100%;" name="easync_car[avail]" id="easync_car[avail]">
            <option value="Yes" 
            <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <p>
        <label for="easync_car[number_car]">Total cars</label>
        <br>
        <input style="width:100%;" style="width:100%;" type="number" min="0" name="easync_car[number_car]" id="easync_car[number_car]" class="regular-text" 
        value="<?php if(!empty($meta['number_car'])) echo $meta['number_car']; else echo '0'; ?>" >
    </p>  

    <p>
        <label for="easync_car[price]">Car Price Per Day (without ',') Currency: <?php echo $sync_product_currency; ?></label>
        <br>
        <input style="width:100%;" style="width:100%;" type="number" min="0" name="easync_car[price]" step="0.01" id="easync_car[price]" class="regular-text" 
        value="<?php if(!empty($meta['price'])) echo $meta['price']; else echo '0'; ?>" >
    </p>
    
    <p>
        <label for="easync_car[type]">Car Type</label>
        <br>
      
        <select style="width:100%;" name="easync_car[type]" id="easync_car[type]">
            <?php
                $table_name = $wpdb->prefix . "sync_options";
                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_types'));
                if ( ! $entries ) {
                    $wpdb->print_error(); 
                }else {
                    foreach ( $entries as $key => $value) {
                        if(!empty($meta['type']) && $value->option_value==$meta['type']) {
                            ?><option selected value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }else{
                            ?><option value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }
                    }
                }
            ?>
        </select>
    </p>

    <p>
        <label for="easync_car[model]">Car model</label>
        <br>
        <select style="width:100%;" name="easync_car[model]" id="easync_car[model]">
            <?php
                $table_name = $wpdb->prefix . "sync_options";
                $entries = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE option_name = %s ORDER BY id DESC", 'sync_car_model'));
                if ( ! $entries ) {
                    $wpdb->print_error(); 
                }else {
                    foreach ( $entries as $key => $value) {
                        if(!empty($meta['model']) && $value->option_value==$meta['model']) {
                            ?><option selected value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }else{
                            ?><option value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }
                    }
                }
            ?>
        </select>
    </p>

    <p>
        <label for="easync_car[plate_number]">Car Plate Number</label>
        <br>
        <input style="width:100%;" style="width:100%;" type="text" name="easync_car[plate_number]" id="easync_car[plate_number]" class="regular-text" 
        value="<?php if(!empty($meta['plate_number'])) echo $meta['plate_number']; else echo ''; ?>" >
    </p>

     <label>Car features:</label>
    <?php
    $car_features_gpminvoice_group = get_post_meta($post->ID, 'easync_car_features_group', true);
     wp_nonce_field( 'gpm_car_features_repeatable_meta_box_nonce', 'gpm_car_features_repeatable_meta_box_nonce' );
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
         if ( $car_features_gpminvoice_group ) :
          foreach ( $car_features_gpminvoice_group as $field ) {
        ?>
        <tr>
          <td width="95%">
            <input style="width:100%;" type="text"  placeholder="Title" name="car_features[]" value="<?php if($field['car_features'] != '') echo esc_attr( $field['car_features'] ); ?>" />
            </td>
          <td width="5%"><a class="button remove-row button-disabled" href="#1">Remove</a></td>
        </tr>
        <?php
        }
        else :
        // show a blank one
        ?>
        <tr>
          <td width="95%"> 
            <input style="width:100%;" type="text" placeholder="Item" title="Title" name="car_features[]" />
            </td>
          <td width="5%"><a class="button cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="special-empty-row screen-reader-text">
          <td width="95%">
            <input style="width:100%;" type="text" placeholder="Item" name="car_features[]"/>
           </td>
          <td width="5%"><a class="button special-remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>
    <p><a id="special-add-row" class="button" href="#">New</a></p>


    <p>
        <label for="easync_car[notes]">Notes</label>
        <br>
        <textarea style="width:100%;" name="easync_car[notes]" rows="5" cols="30" id="easync_car[notes]" style="width:500px;"><?php if(!empty($meta['notes'])) echo $meta['notes']; ?></textarea>
    </p>

    <label>Special request(checkbox generated to frontend):</label>
    <?php
        $special_gpminvoice_group = get_post_meta($post->ID, 'sync_car_specialrequest_group', true);
        wp_nonce_field( 'gpm_car_specialrequest_repeatable_meta_box_nonce', 'gpm_car_specialrequest_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(  jQuery ){
            jQuery( '#car_special-add-row' ).on('click', function() {
                var row =  jQuery( '.car-special-empty-row.screen-reader-text' ).clone(true);
                row.removeClass( 'empty-row screen-reader-text' );
                row.insertBefore( '#car-special-repeatable-fieldset-one tbody>tr:last' );
                return false;
            });

            jQuery( '.car-special-remove-row' ).on('click', function() {
                jQuery(this).parents('tr').remove();
                return false;
            });


        });
    </script>
    <table id="car-special-repeatable-fieldset-one" width="100%">
      <tbody>
        <?php
         if ( $special_gpminvoice_group ) :
          foreach ( $special_gpminvoice_group as $field ) {
        ?>
        <tr>
          <td width="95%">
            <input style="width:100%;" type="text"  placeholder="Title" name="specialrequest[]" value="<?php if($field['specialrequest'] != '') echo esc_attr( $field['specialrequest'] ); ?>" />
            </td>
          <td width="5%"><a class="button remove-row button-disabled" href="#1">Remove</a></td>
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
          <td width="5%"><a class="button cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="car-special-empty-row screen-reader-text">
          <td width="95%">
            <input style="width:100%;" type="text" placeholder="Item" name="specialrequest[]"/>
           </td>
          <td width="5%"><a class="button car-special-remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>

    <p><a id="car_special-add-row" class="button" href="#">New</a></p>

    <p>
        <label for="easync_car[writemsg]">Enable 'Others' Option (for special requests)</label>
        <br>
        <select style="width: 100%" name="easync_car[writemsg]" id="easync_car[writemsg]">
            <option value="Yes" 
            <?php if(!empty($meta['writemsg'])) selected( $meta['writemsg'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['writemsg'])) selected( $meta['writemsg'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <?php
}

add_action( 'save_post', 'easyncSaveCarMeta' );
function easyncSaveCarMeta( $post_id ) {   

    if ( !wp_verify_nonce( sanitize_text_field($_POST['sync_meta_box_nonce']), basename(__FILE__) ) ) {
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
    
    $old = get_post_meta( $post_id, 'easync_car', true );

   // $new = $_POST['easync_car']; ----> old
    
    $new = array();
    $Items = $_POST['easync_car'];
    $new['avail'] = stripslashes( strip_tags( sanitize_text_field($Items['avail']) ) );
    $new['number_car'] = stripslashes( strip_tags( intval($Items['number_car']) ) );
    $new['price'] = stripslashes( strip_tags( $Items['price'] ) );
    $new['type'] = stripslashes( strip_tags( sanitize_text_field($Items['type']) ) );
    $new['model'] = stripslashes( strip_tags( sanitize_text_field($Items['model']) ) );
    $new['plate_number'] = stripslashes( strip_tags( intval($Items['plate_number']) ) );
    $new['notes'] = strtoupper( stripslashes( strip_tags( sanitize_text_field($Items['notes']) ) ) );
    $new['writemsg'] = stripslashes( strip_tags( sanitize_text_field($Items['writemsg']) ) );

    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'easync_car', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'easync_car', $old );
    }

    if ( !isset($_POST['gpm_car_features_repeatable_meta_box_nonce']) ||
    ! wp_verify_nonce( $_POST['gpm_car_features_repeatable_meta_box_nonce'], 'gpm_car_features_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'easync_car_features_group', true);
    $new = array();
    $Items = $_POST['car_features'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['car_features'] = stripslashes( strip_tags( sanitize_text_field($Items[$i]) ) );
        endif;
    }

    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'easync_car_features_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'easync_car_features_group', $old );

    
    if ( !isset($_POST['gpm_car_specialrequest_repeatable_meta_box_nonce'])  ||
    ! wp_verify_nonce($_POST['gpm_car_specialrequest_repeatable_meta_box_nonce'], 'gpm_car_specialrequest_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'sync_car_specialrequest_group', true);
    $new = array();
    $Items = $_POST['specialrequest'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['specialrequest'] = stripslashes( strip_tags( sanitize_text_field( $Items[$i]) ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'sync_car_specialrequest_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'sync_car_specialrequest_group', $old );

}
?>