<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'init', 'easyncRestauTableInit' );

function easyncRestauTableInit() {

    $labels = array(
        'name'               => 'eaSYNC Restaurant Tables',
        'singular_name'      => 'eaSYNC Restaurant Table',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New',
        'edit_item'          => 'Edit Table',
        'new_item'           => 'New Table',
        'all_items'          => 'All Table',
        'view_item'          => 'View Table',
        'search_items'       => 'Search Table',
        'not_found'          =>  'No Table Found',
        'not_found_in_trash' => 'No Table found in Trash', 
        'parent_item_colon'  => '',
        'menu_name'          => 'eaSYNC Restaurant Tables',
    );
    $capabilities =  array('post');
    $capabilities_var = 'capabilities_type';
    if(!is_super_admin()) {
        $labels = array(
            'name'               => _x( 'eaSYNC Restaurant Table', 'post type general name', 'sync_privilage' ),
            'singular_name'      => _x( 'eaSYNC Restaurant Table', 'post type singular name', 'sync_privilage' ),
            'menu_name'          => _x( 'eaSYNC Restaurant Table', 'admin table', 'sync_privilage' ),
            'name_admin_bar'     => _x( 'eaSYNC Restaurant Table', 'add new on admin bar', 'sync_privilage' ),
            'add_new'            => _x( 'Add New', 'table', 'sync_privilage' ),
            'add_new_item'       => __( 'Add New Table', 'sync_privilage' ),
            'new_item'           => __( 'New Table', 'sync_privilage' ),
            'edit_item'          => __( 'Edit Table', 'sync_privilage' ),
            'view_item'          => __( 'View Table', 'sync_privilage' ),
            'all_items'          => __( 'All Table', 'sync_privilage' ),
            'search_items'       => __( 'Search Tables', 'sync_privilage' ),
            'parent_item_colon'  => __( '', 'sync_booking_privilage' ),
            'not_found'          => __( 'No Table Found.', 'sync_privilage' ),
            'not_found_in_trash' => __( 'No Table found in Trash.', 'sync_privilage' ),
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
        'show_in_menu' => true, 
        $capabilities_var => $capabilities,
        'map_meta_cap' => true,
        'hierarchical'    => false,
        'rewrite'         => array('slug' => 'Table'),
        'query_var'       => true,
        'menu_icon'       => 'dashicons-admin-post',
        'supports'        => array(
            'title',
            'editor',
            //'excerpt',
            'trackbacks',
            //'comments',
            'revisions',
            'thumbnail',
            'author'
            //'page-attributes'
        )
    );
    register_post_type( 'easync_restau_table', $args );

    add_action( 'add_meta_boxes', 'easyncRestauTableFieldsMetabox' );

    function easyncRestauTableFieldsMetabox() {
        add_meta_box(
            'easync_restau_table_meta_box',
            'Seats and more', 
            'easyncShowRestauTableFieldsMetaBox', 
            'easync_restau_table',
            'normal',
            'high'
        );
    }
}

function easyncShowRestauTableFieldsMetaBox() {
    global $post, $wpdb;  
    $meta = get_post_meta( $post->ID, 'sync_restau_table', true ); 
    ?>
    <input type="hidden" name="sync_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

    <p>
        <label for="sync_restau_table[avail]">Available</label>
        <br>
        <select style="width:100%;" name="sync_restau_table[avail]" id="sync_restau_table[avail]">
            <option value="Yes" 
            <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <p>
        <label for="sync_restau_table[total]">Total Tables: </label>
        <br>
        <input style="width:100%;" type="number" min="1" name="sync_restau_table[total]" id="sync_restau_table[total]" class="regular-text" 
        value="<?php if(!empty($meta['total'])) echo $meta['total']; else echo '1'; ?>" >
    </p>

    <p>
        <label for="sync_restau_table[seats]">Number of seats: </label>
        <br>
        <input style="width:100%;" type="number" min="0" name="sync_restau_table[seats]" id="sync_restau_table[seats]" class="regular-text" 
        value="<?php if(!empty($meta['seats'])) echo $meta['seats']; else echo '0'; ?>" >
    </p>

    <p>
        <label for="sync_restau_table[branch]">Branch Location</label>
        <br>
      
        <select style="width:100%;" name="sync_restau_table[branch]" id="sync_restau_table[branch]">
            <?php
                $table_name = $wpdb->prefix . "sync_options";
                $entries = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name = 'sync_branch_locations' ORDER BY id DESC;" );
                if ( ! $entries ) {
                    $wpdb->print_error(); 
                }else {
                    foreach ( $entries as $key => $value) {
                        if(!empty($meta['branch']) && $value->option_value==$meta['branch']) {
                            ?><option selected value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }else{
                            ?><option value="<?php echo $value->option_value;?>"><?php echo $value->option_value;?></option><?php
                        }
                    }
                }
            ?>
        </select>
    </p>

    <label>Table Images:</label><br><br>
    <?php
    $table_images_gpminvoice_group = get_post_meta($post->ID, 'sync_table_images_group', true);
     wp_nonce_field( 'gpm_table_images_repeatable_meta_box_nonce', 'gpm_table_images_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function(  jQuery ){
        $count = jQuery("#table-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new").attr('data-key');
         jQuery( '#table-images-add-row' ).on('click', function() {
            
            var row =  jQuery( '.table-images-empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#table-images-repeatable-fieldset-one tbody>tr:last' );

            $count++;

            var secondlast = jQuery("#table-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new");
            var secondlastinput = jQuery("#table-images-repeatable-fieldset-one tr:last").prev().find("td .custom_postimage_wrapper.add-new input");
            
            secondlast.attr('id', $count+'_wrapper');
            secondlast.attr('data-key', $count);
            secondlastinput.attr('id', $count);
            return false;
        });

         jQuery( '.table-images-remove-row' ).on('click', function() {
             jQuery(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="table-images-repeatable-fieldset-one" width="30%">
      <tbody>
        <?php
        $counter = 0;
         if ( $table_images_gpminvoice_group ) :
          foreach ( $table_images_gpminvoice_group as $key => $field ) {
            $counter = $key;
        ?>
        <tr>
          <td width="15%">

            <div class="custom_postimage_wrapper" id="<?php echo $key; ?>_wrapper" style="margin-bottom:20px;">
                <img src="<?php echo ($field['table_images']!=''?wp_get_attachment_image_src( $field['table_images'])[0]:''); ?>" style="width:100%;display: <?php echo ($field['table_images']!=''?'block':'none'); ?>" alt="">
                <a class="addimage button" onclick="custom_postimage_add_image('<?php echo $key; ?>');"><?php _e('update image','yourdomain'); ?></a><br>
                <input type="hidden" name="table_images[]" id="<?php echo $key; ?>" value="<?php echo $field['table_images']; ?>" />
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
                <input type="hidden" name="table_images[]" id="1" value="" />
            </div>
            </td>
          <td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="table-images-empty-row screen-reader-text">
          <td>
             <div class="custom_postimage_wrapper add-new" id="" data-key="<?php echo ($counter==0 ? 0 : $counter)?>" style="margin-bottom:20px;">
                <img src="" style="width:100%;display: 'none'" alt="">
                <a class="addimage button new" ><?php _e('add image','yourdomain'); ?></a><br>
                <input type="hidden" name="table_images[]" id="" value="" />
            </div>
           </td>
          <td><a class="button table-images-remove-row" href="#">Remove</a></td>
        </tr>
      </tbody>
    </table>
    <p><a id="table-images-add-row" class="button" href="#">New</a></p>

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
      
    <?php
}

add_action( 'save_post', 'easyncSaveRestauTableMeta' );

function easyncSaveRestauTableMeta( $post_id ) {   

    if ( !wp_verify_nonce( sanitize_text_field($_POST['sync_meta_box_nonce']), basename(__FILE__) ) ) {
        return $post_id; 
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'page' === sanitize_text_field($_POST['post_type']) ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }  
    }
    
    $old = get_post_meta( $post_id, 'sync_restau_table', true );
    //$new = sanitize_text_field($_POST['sync_restau']);
    $new = array();
    $Items = $_POST['sync_restau_table'];
    $new['avail'] = stripslashes( strip_tags( sanitize_text_field($Items['avail']) ) );
    $new['total'] = stripslashes( strip_tags( $Items['total'] ) );
    $new['seats'] = stripslashes( strip_tags( $Items['seats'] ) );
    $new['branch'] = stripslashes( strip_tags( sanitize_text_field($Items['branch']) ) );

    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'sync_restau_table', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'sync_restau_table', $old );
    }

    if ( !isset($_POST['gpm_table_images_repeatable_meta_box_nonce']) ||
    ! wp_verify_nonce($_POST['gpm_table_images_repeatable_meta_box_nonce'], 'gpm_table_images_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'sync_table_images_group', true);
    $new = array();
    $Items = $_POST['table_images'];
     $count = count( $Items );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $Items[$i] != '' ) :
            $new[$i]['table_images'] = stripslashes( strip_tags( sanitize_text_field($Items[$i]) ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'sync_table_images_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'sync_table_images_group', $old );
}