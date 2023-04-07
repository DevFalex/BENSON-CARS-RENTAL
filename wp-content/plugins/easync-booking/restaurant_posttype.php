<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'init', 'easyncRestauInit' );

function easyncRestauInit() {

$labels = array(
    'name'               => 'eaSYNC Restaurant',
    'singular_name'      => 'eaSYNC Restaurant',
    'add_new'            => 'Add New Menu',
    'add_new_item'       => 'Add New Menu',
    'edit_item'          => 'Edit Menu',
    'new_item'           => 'New Menu',
    'all_items'          => 'All Menu',
    'view_item'          => 'View Menu',
    'search_items'       => 'Search Menus',
    'not_found'          =>  'No Menus Found',
    'not_found_in_trash' => 'No Menus found in Trash', 
    'parent_item_colon'  => '',
    'menu_name'          => 'eaSYNC Restaurant',
);
$capabilities =  array('post');
$capabilities_var = 'capabilities_type';
if(!is_super_admin()) {
    $labels = array(
        'name'               => _x( 'eaSYNC Restaurant', 'post type general name', 'sync_privilage' ),
        'singular_name'      => _x( 'eaSYNC Restaurant', 'post type singular name', 'sync_privilage' ),
        'menu_name'          => _x( 'eaSYNC Restaurant', 'admin menu', 'sync_privilage' ),
        'name_admin_bar'     => _x( 'eaSYNC Restaurant', 'add new on admin bar', 'sync_privilage' ),
        'add_new'            => _x( 'Add New', 'menu', 'sync_privilage' ),
        'add_new_item'       => __( 'Add New Menu', 'sync_privilage' ),
        'new_item'           => __( 'New Menu', 'sync_privilage' ),
        'edit_item'          => __( 'Edit Menu', 'sync_privilage' ),
        'view_item'          => __( 'View Menu', 'sync_privilage' ),
        'all_items'          => __( 'All Menu', 'sync_privilage' ),
        'search_items'       => __( 'Search Menus', 'sync_privilage' ),
        'parent_item_colon'  => __( '', 'sync_booking_privilage' ),
        'not_found'          => __( 'No Menu Found.', 'sync_privilage' ),
        'not_found_in_trash' => __( 'No Menu found in Trash.', 'sync_privilage' ),
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
        'rewrite'         => array('slug' => 'Restau'),
        'query_var'       => true,
        'menu_icon'       => 'dashicons-carrot',
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
    register_post_type( 'easync_restau', $args );
    $capabilities =  array(
        'manage_terms'=> 'manage_categories',
          'edit_terms'=> 'manage_categories',
          'delete_terms'=> 'manage_categories',
          'assign_terms' => 'read'
    );
    // register taxonomy
    register_taxonomy('easync_food_category', 'easync_restau', array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'public' => true, 'capabilities' => $capabilities, 'show_ui' => true, 'rewrite' => array( 'slug' => 'easync-food-category' )));

    $parent_term = term_exists( 'easync_food_category' ); // array is returned if taxonomy is given
    $parent_term_id = $parent_term; // get numeric term id
    
    wp_insert_term(
      'Appetizers', // the term 
      'easync_food_category', // the taxonomy
      array(
        'description'=> '',
        'slug' => 'appetizers',
        'parent'=> $parent_term_id
      )
    );

    wp_insert_term(
      'Main Course', // the term 
      'easync_food_category', // the taxonomy
      array(
        'description'=> '',
        'slug' => 'main-course',
        'parent'=> $parent_term_id
      )
    );

    wp_insert_term(
      'Dessert', // the term 
      'easync_food_category', // the taxonomy
      array(
        'description'=> '',
        'slug' => 'dessert',
        'parent'=> $parent_term_id
      )
    );

    wp_insert_term(
      'Drinks', // the term 
      'sync_food_category', // the taxonomy
      array(
        'description'=> '',
        'slug' => 'drinks',
        'parent'=> $parent_term_id
      )
    );
}

add_action( 'add_meta_boxes', 'easyncRestauFieldsMetabox' );

function easyncRestauFieldsMetabox() {
    add_meta_box(
        'easync_restau_meta_box',
        'Price and more', 
        'easyncShowRestauFieldsMetaBox', 
        'easync_restau',
        'normal',
        'high'
    );

}


function easyncShowRestauFieldsMetaBox() {
    global $post, $sync_product_currency;  
    $meta = get_post_meta( $post->ID, 'sync_restau', true ); 
    ?>
    <input type="hidden" name="sync_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

    <p>
        <label for="sync_restau[avail]">Available</label>
        <br>
        <select style="width:100%;" name="sync_restau[avail]" id="sync_restau[avail]">
            <option value="Yes" 
            <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'Yes' ); else echo 'Yes'; ?>>Yes</option>
            <option value="No" <?php if(!empty($meta['avail'])) selected( $meta['avail'], 'No' ); else echo 'No'; ?>>No</option>
        </select>
    </p>

    <p>
        <label for="sync_restau[price]">Menu Price (without ',') Currency: <?php echo $sync_product_currency; ?></label>
        <br>
        <input style="width:100%;" type="number" step="0.01" min="0" name="sync_restau[price]" step="0.01" id="sync_restau[price]" class="regular-text" 
        value="<?php if(!empty($meta['price'])) echo $meta['price']; else echo '0'; ?>" >
    </p>

    <p>
        <label for="sync_restau[notes]">Notes</label>
        <br>
        <textarea style="width:100%;" name="sync_restau[notes]" rows="5" cols="30" id="sync_restau[notes]" style="width:500px;"><?php if(!empty($meta['notes'])) echo $meta['notes']; ?></textarea>
    </p>
      
    <?php

}

?><?php

add_action( 'save_post', 'easyncSaveRestauMeta' );

function easyncSaveRestauMeta( $post_id ) {   

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
    
    $old = get_post_meta( $post_id, 'sync_restau', true );
    //$new = sanitize_text_field($_POST['sync_restau']);
    $new = array();
    $Items = $_POST['sync_restau'];
    $new['avail'] = stripslashes( strip_tags( sanitize_text_field($Items['avail']) ) );
    $new['price'] = stripslashes( strip_tags( $Items['price'] ) );
    $new['notes'] = stripslashes( strip_tags( sanitize_text_field($Items['notes']) ) );

    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'sync_restau', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'sync_restau', $old );
    }
}

