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
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'dog', $args );
}
add_action( 'init', 'custom_post_dog' );


