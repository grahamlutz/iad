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

// When dog is created, fill in registry_product custom relationship fields with porducts based on dog size, breed, and age. 

function init_dog_registry( $post_id) {

    // Set defaults for registry item relationship fields

    // $dogs_weight = get_post_meta( $post_id, 'dog_weight', true);
    // $dogs_age    = get_post_meta( $post_id, 'dog_age', true);
    // $dogs_breed  = get_post_meta( $post_id, 'dog_breed', true);

    //Save item data as custom fields in registry_product post
    if (!get_post_meta($post_id, 'beds_and_blankets', true)) {
        set_registry_product( 'B01EMBB5V0', 'beds_and_blankets', $post_id );
    } else {
        return;
    }

    // If dog is under 40 lbs...
    // If dog is between 40-80 lbs...
    // If dog is over 80 lbs...
    // If dog is under 2..
    // If dog is between 2 and 8...
    // If dog is over 8...

}

add_action( 'save_post', 'init_dog_registry', 10);