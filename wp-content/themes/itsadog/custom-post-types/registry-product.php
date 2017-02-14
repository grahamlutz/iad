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

function fetch_amazon_data( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    return;

    if ( 'page' == $_POST['registry_product'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) )
            return;
    }

    // Code that should be somewhere else

    function  generate_aws_request($params, $public_key, $private_key, $associate_tag) {

        $method = "GET";
        $host = "ecs.amazonaws.com"; // must be in lower case...learned that the hard way. 
        $uri = "/onca/xml";
        
        
        $params["Service"]          = "AWSECommerceService";
        $params["AWSAccessKeyId"]   = $public_key;
        $params["AssociateTag"]     = $associate_tag;
        $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
        $params["Version"]          = "2011-08-01";

        // This has to happen because amazon does it on their end.  Later, we hash 
        // this string and it has to match amazon's string
        ksort($params);
        
        $canonicalized_query = array();

        foreach ($params as $param=>$value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param."=".$value;
        }
        
        $canonicalized_query = implode("&", $canonicalized_query);
        $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));
        $signature = str_replace("%7E", "~", rawurlencode($signature));
        $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
        echo "<pre style='padding-left:300px'>";
        var_dump($request);
        echo "</pre>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $xml_response = curl_exec($ch);
        
        if ($xml_response === False) {
            return False;
        } else {
            $parsed_xml = simplexml_load_string($xml_response);
            return ($parsed_xml === False) ? False : $parsed_xml;
        }
    }

    class AmazonProductAPI
    {

        private $public_key     = "AKIAI2TW3MC7KCEC362Q";
        private $private_key    = "32nPZDVn0JACc9Wjt5Jr8NcA6UvKcsgM4LJETIyx";
        private $associate_tag  = "theongoautoof-20";

        private function verifyXmlResponse($response) {
            if ($response === False) {
                throw new Exception("Could not connect to Amazon");
            } else {
                if (isset($response->Items->Item->ItemAttributes->Title)) {
                    return ($response);
                } else {
                    throw new Exception("Invalid xml response.");
                }
            }
        }

        public function getProductByAsin($asin_code) {
            // if $responseGroup is parameter, 
                // if it's an array, convert from array to canonicalized string
                // set it as the value of $parameters["ResponseGroup"];
            $parameters = array("Operation"     => "ItemLookup",
                                "ItemId"        => $asin_code,
                                "IdType"        => "ASIN",
                                "ResponseGroup" => "Images,ItemAttributes"
                          );
                                
            $xml_response = generate_aws_request($parameters, $this->public_key, $this->private_key, $this->associate_tag);
            
            return $this->verifyXmlResponse($xml_response);
        }
    }

    // Code to run when saving custom post type registry_product
    $item = new AmazonProductAPI();
    
    // B01BSMAUHQ is the ASIN for some dog blanket. Only Run this is valid ASIN as argument.
    // Get this to dynamically use a custom fields with Item ASIN.
    $asin_value = get_post_meta( $post_id, 'asin_code', true);
    $result = $item->getProductByAsin($asin_value);

    // Turn XML into Array.
    $json = json_encode($result);
    $result_array = json_decode($json, true);

    echo "<pre style='padding-left:300px'>";
    var_dump($result_array["Items"]["Item"]["ItemAttributes"]["Title"]);
    echo "</pre>";

    $post = array();
    $post['ID'] = $post_id;
    $post['post_title' ] = $result_array["Items"]["Item"]["ItemAttributes"]["Title"];
    wp_update_post( $post );

    // Save item data as custom fields in registry_product post
    // $item_title = $result_array["Items"]["Item"]["ItemAttributes"]["Title"];
    // $item_image = $result_array["Items"]["Item"]["SmallImage"]['URL'];
    // update_post_meta( $post_id, 'item_image', $item_image );

}

add_action( 'save_post', 'fetch_amazon_data', 999 );

