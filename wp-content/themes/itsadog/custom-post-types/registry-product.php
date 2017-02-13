<?php

function custom_post_registry_product() {
  $labels = array(
    'name'               => _x( 'Registry Products', 'post type general name' ),
    'singular_name'      => _x( 'Registry Product', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Registry Product' ),
    'add_new_item'       => __( 'Add New Registry Product' ),
    'edit_item'          => __( 'Edit Registry Product' ),
    'new_item'           => __( 'New Registry Product' ),
    'all_items'          => __( 'All Registry Products' ),
    'view_item'          => __( 'View Registry Products' ),
    'search_items'       => __( 'Search Registry Products' ),
    'not_found'          => __( 'No Registry Products found' ),
    'not_found_in_trash' => __( 'No Registry Products found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Registry Products'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our Registry Products and Registry Product specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes' ),
    'taxonomies'    => array( 'category' ),
    'has_archive'   => true,
    'hierarchical'  => true,
  );
  register_post_type( 'registry_product', $args );
}
add_action( 'init', 'custom_post_registry_product' );