<?php

function custom_post_item() {
  $labels = array(
    'name'               => _x( 'Items', 'post type general name' ),
    'singular_name'      => _x( 'Item', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Item' ),
    'add_new_item'       => __( 'Add New Item' ),
    'edit_item'          => __( 'Edit Item' ),
    'new_item'           => __( 'New Item' ),
    'all_items'          => __( 'All Items' ),
    'view_item'          => __( 'View Items' ),
    'search_items'       => __( 'Search Items' ),
    'not_found'          => __( 'No items found' ),
    'not_found_in_trash' => __( 'No items found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Items'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our items and dog specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes' ),
    'taxonomies'    => array( 'category' ),
    'has_archive'   => true,
    'hierarchical'  => true,
  );
  register_post_type( 'item', $args );
}
add_action( 'init', 'custom_post_item' );