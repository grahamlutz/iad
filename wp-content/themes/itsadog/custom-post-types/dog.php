<?php

function custom_post_dog() {
  $labels = array(
    'name'               => _x( 'Dogs', 'post type general name' ),
    'singular_name'      => _x( 'Dog', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Dog' ),
    'edit_item'          => __( 'Edit Dog' ),
    'new_item'           => __( 'New Dog' ),
    'all_items'          => __( 'All Dogs' ),
    'view_item'          => __( 'View Dog' ),
    'search_items'       => __( 'Search Dogs' ),
    'not_found'          => __( 'No dogs found' ),
    'not_found_in_trash' => __( 'No dogs found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Dogs'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our dogs and dog specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes' ),
    'taxonomies'    => array( 'category' ),
    'has_archive'   => true,
    'hierarchical'  => true,
  );
  register_post_type( 'dog', $args );
}
add_action( 'init', 'custom_post_dog' );


// add_action( 'save_post', 'save_dog_boxes', 999 );
// function save_dog_boxes( $post_id ) {

//  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
//  return;

//  if ( !wp_verify_nonce( $_POST['dog_box_content_nonce'], plugin_basename( __FILE__ ) ) )
//  return;

//  if ( 'page' == $_POST['dog'] ) {
//    if ( !current_user_can( 'edit_page', $post_id ) )
//    return;
//  } else {
//    if ( !current_user_can( 'edit_post', $post_id ) )
//    return;
//  }

//  $dog_weight = $_POST['dog-weight'];
//  update_post_meta( $post_id, 'dog_weight', $dog_weight );
//  $dog_month = $_POST['dog-month'];
//  update_post_meta( $post_id, 'dog_month', $dog_month );
//  $dog_year = $_POST['dog-year'];
//  update_post_meta( $post_id, 'dog_year', $dog_year );
//  $dog_breed = $_POST['dog-breed'];
//  update_post_meta( $post_id, 'dog_breed', $dog_breed );

// }
