<?php
require_once "AmazonProductAPI.php";


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
    'taxonomies'    => array( 'registry_product_categories' ),
    'has_archive'   => true,
    'hierarchical'  => true,
  );
  register_post_type( 'registry_product', $args );
}
add_action( 'init', 'custom_post_registry_product' );

function registry_product_category() {
    register_taxonomy(
        'registry_product_categories',  //The name of the taxonomy.
        'registry_product',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Categories',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'themes', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'registry_product_category');

function fetch_amazon_data( $meta_id, $post_id, $meta_key, $meta_value) {

    //TODO: also check for valid asin_code


    if($meta_key != 'asin_code' || empty($meta_value)) {
      return;
    }

    // Code to run when saving custom post type registry_product
    $item = new AmazonProductAPI();
    try {
      $result = $item->getProductByAsin($meta_value);
    } catch (Exception $e) {
      return;
    }

    $post = array();
    $post['ID'] = $post_id;
    $post['post_title'] = (string) $result->Items->Item->ItemAttributes->Title;
    wp_update_post($post);

    // Save item data as custom fields in registry_product post
    $item_image_url = (string) $result->Items->Item->SmallImage->URL;
    update_post_meta( $post_id, 'item_image_url', $item_image_url);
}

add_action( 'updated_post_meta', 'fetch_amazon_data', 10, 4);
add_action( 'added_post_meta', 'fetch_amazon_data', 10, 4);
