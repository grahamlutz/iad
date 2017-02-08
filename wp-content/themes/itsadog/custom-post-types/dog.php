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
    'hierarchical'  => true,
  );
  register_post_type( 'dog', $args );
}
add_action( 'init', 'custom_post_dog' );

//add_action( 'add_meta_boxes', 'dog_details_box' );

function dog_details_box() {
    add_meta_box(
        'dog_age_box',
        'Dog\'s Birthday',
        'dog_age_box_content',
        'dog',
        'normal',
        'low'
    );
    add_meta_box(
        'dogs_weight_box',
        'Dog\'s Weight',
        'dog_weight_box_content',
        'dog',
        'normal',
        'low'
    );
    add_meta_box(
        'dogs_breed_box',
        'Dog\'s Breed',
        'dog_breed_box_content',
        'dog',
        'normal',
        'low'
    );
}

function dog_breed_box_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'dog_box_content_nonce' );
 ?>
 <label for="dog-breed"><?php _e( "Add dog's breed.", 'example' ); ?></label>
  <br />
  <input type="text" name="dog-breed" id="dog-breed" value="<?php echo esc_attr( get_post_meta( $post->ID, 'dog_breed', true ) ); ?>" placeholder="<?php echo esc_attr( get_post_meta( $post->ID, 'dog_breed', true ) ); ?>" size="30" />
 <?php

}

function dog_age_box_content( $post ) {
 wp_nonce_field( plugin_basename( __FILE__ ), 'dog_box_content_nonce' );
 echo "<form id='form1' runat='server'>
   <div>

     Month<br />
     <select name='dog-month' id='monthddl'>
       <option value='1'>1</option>
       <option value='2'>2</option>
       <option value='3'>3</option>
       <option value='4'>4</option>
       <option value='5'>5</option>
       <option value='6'>6</option>
       <option value='7'>7</option>
       <option value='8'>8</option>
       <option value='9'>9</option>
       <option value='10'>10</option>
       <option value='11'>11</option>
       <option value='12'>12</option>
     </select>

     <br /><br /><br />
     Year<br />

     <select name='dog-year' id='yearddl'>
       <option value='1990'>1990</option>
       <option value='1991'>1991</option>
       <option value='1992'>1992</option>
       <option value='1993'>1993</option>
       <option value='1994'>1994</option>
       <option value='1995'>1995</option>
       <option value='1996'>1996</option>
       <option value='1997'>1997</option>
       <option value='1998'>1998</option>
       <option value='1999'>1999</option>
       <option value='2000'>2000</option>
       <option value='2001'>2001</option>
       <option value='2002'>2002</option>
       <option value='2003'>2003</option>
       <option value='2004'>2004</option>
       <option value='2005'>2005</option>
       <option value='2006'>2006</option>
       <option value='2007'>2007</option>
       <option value='2008'>2008</option>
       <option value='2009'>2009</option>
       <option value='2010'>2010</option>
       <option value='2011'>2011</option>
       <option value='2012'>2012</option>
       <option value='2013'>2013</option>
       <option value='2014'>2014</option>
       <option value='2015'>2015</option>
       <option value='2016'>2016</option>
       <option value='2017'>2017</option>
     </select>

   </div>
 </form>";
}

function dog_weight_box_content( $post ) {

 wp_nonce_field( plugin_basename( __FILE__ ), 'dog_box_content_nonce' );
 ?>
 <label for="dog-weight"><?php _e( "Add dog's weight.", 'example' ); ?></label>
  <br />
  <input type="text" name="dog-weight" id="dog-weight" value="<?php echo esc_attr( get_post_meta( $post->ID, 'dog_weight', true ) ); ?>" placeholder="<?php echo esc_attr( get_post_meta( $post->ID, 'dog_weight', true ) ); ?>" size="30" />
 <?php
}

add_action( 'save_post', 'save_dog_boxes', 999 );
function save_dog_boxes( $post_id ) {

 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
 return;

 if ( !wp_verify_nonce( $_POST['dog_box_content_nonce'], plugin_basename( __FILE__ ) ) )
 return;

 if ( 'page' == $_POST['dog'] ) {
   if ( !current_user_can( 'edit_page', $post_id ) )
   return;
 } else {
   if ( !current_user_can( 'edit_post', $post_id ) )
   return;
 }

 $dog_weight = $_POST['dog-weight'];
 update_post_meta( $post_id, 'dog_weight', $dog_weight );
 $dog_month = $_POST['dog-month'];
 update_post_meta( $post_id, 'dog_month', $dog_month );
 $dog_year = $_POST['dog-year'];
 update_post_meta( $post_id, 'dog_year', $dog_year );
 $dog_breed = $_POST['dog-breed'];
 update_post_meta( $post_id, 'dog_breed', $dog_breed );

}
