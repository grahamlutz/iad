<?php

/**
 * itsadog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package itsadog
 */

if ( ! function_exists( 'itsadog_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function itsadog_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on itsadog, use a find and replace
	 * to change 'itsadog' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'itsadog', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'itsadog' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'itsadog_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'itsadog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function itsadog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'itsadog_content_width', 640 );
}
add_action( 'after_setup_theme', 'itsadog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function itsadog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'itsadog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'itsadog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'itsadog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function itsadog_scripts() {
	wp_enqueue_style( 'itsadog-style', get_stylesheet_uri() );

	wp_enqueue_script( 'itsadog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'itsadog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'itsadog_scripts' );

function itsadog_custom_scripts() {
	wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array() );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array() );
	wp_enqueue_style( 'itsadog-custom-style', get_template_directory_uri() . '/css/custom.css', array() );

	wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'itsadog_custom_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Dog Custom Post Type
 */

 require get_template_directory() . '/custom-post-types/dog.php';

/**
 * Item Custom Post Type
 */

 require get_template_directory() . '/custom-post-types/registry-product.php';

/**
* Security Fix for Advanced Custom Fields
*/

function my_kses_post( $value ) {

	// is array
	if( is_array($value) ) {
		return array_map('my_kses_post', $value);
	}


	// return
	return wp_kses_post( $value );

}

add_filter('acf/update_value', 'my_kses_post', 10, 1);

/**
  * Set uploaded dog image as featured imaged
  */

function acf_set_featured_image( $value, $post_id, $field  ){

    if($value != ''){
	    //Add the value which is the image ID to the _thumbnail_id meta data for the current post
	    update_post_meta($post_id, '_thumbnail_id', $value);
    }

    return $value;
}

add_filter('acf/update_value/name=dogs_image', 'acf_set_featured_image', 10, 3);

/**
  * helper function to set up default registry items when creating new dog post
  */

function set_default_registry_product ( $asin_code, $registry_category, $post_id ) {
	$args = array(
	          'post_type'   => 'registry_product',
	          'meta_query'  => array(
	            array(
	              'value' => $asin_code
	            )
	          )
	        );
	// the query
	$my_query = new WP_Query( $args ); 
	if( $my_query->have_posts() ) {
	  while( $my_query->have_posts() ) {
	    $my_query->the_post();
	    $id = array( get_the_ID() );
	    update_field( $registry_category, $id, $post_id );
	  } // end while
	} // end if
	wp_reset_postdata();
};

/**
 * Update Registry Products
 */

function update_registry_product() {

	$post_id = $_POST[ 'postId' ];
	$asin_code = $_POST[ 'asin' ];
	$registry_category = $_POST[ 'category' ];

	$args = array(
	          'post_type'   => 'registry_product',
	          'meta_query'  => array(
	            array(
	              'value' => $asin_code
	            )
	          )
	        );

	// the query
	$my_query = new WP_Query( $args ); 

	if( $my_query->have_posts() ) {
	  while( $my_query->have_posts() ) {
	    $my_query->the_post();

	    // get array of product ID's currently included in the registry in this category
		$product_IDs = getCurrentRegistryProductIDs($registry_category, $post_id);

		// if clicked item's ID is in array, remove it.
	    $item_key = array_search( get_the_ID(), $product_IDs );
	    if ( $item_key > -1 ) {
	    	unset( $product_IDs[$item_key] );

	    // else, add it to the array
	    } else {
	    	array_push( $product_IDs, get_the_ID() );
	    };

	    // Update dog's custom registry category field with new array of registry products.
	    update_field( $registry_category, $product_IDs, $post_id );

	    // get the newly updated products to send to front end
	    $current_products = get_field($registry_category, $post_id);

	    echo json_encode($current_products);
	    die();

	  } // end while
	} // end if
	wp_reset_postdata();
}	

add_action( 'wp_ajax_updateRgistryProduct', 'update_registry_product' );


// Returns array of products in dog's registry for that category

function getCurrentRegistryProductIDs($registry_category, $post_id) {
	// get registry item relationships custom field from dog post (array of registry_poduct posts)
    $current_products = get_field($registry_category, $post_id);
    // put registry_product item id's into an array
    $product_IDs = array();
    if ( count($current_products) > 0 ){
	    for ($i=0; $i < count($current_products); $i++) { 
	    	array_push( $product_IDs, $current_products[$i]->ID );
	    };
	}

	return $product_IDs;
}

function displayProduct( $product_list, $product_IDs, $category, $bool ) {
	while ( $product_list -> have_posts() ) : $product_list -> the_post();
 
    	$img_url   = get_post_meta( get_the_ID(), 'item_image_url', true );
    	$asin_code = get_post_meta( get_the_ID(), 'asin_code', true ); 
    	$amzn_url  = get_post_meta( get_the_ID(), 'item_url', true );

    	$item_key = array_search( get_the_ID(), $product_IDs );
    	$item_key++;
		
		if ( $item_key == $bool ) {
		?>
			<div class="product <?php echo $category->slug ?>" id="product<?php echo get_the_ID() ?>">
            	<h3 class="title ellipsis"><?php the_title(); ?></h3>
                <a class="asin-code <?php echo $asin_code ?>" data-category="<?php echo $category->slug ?>" data-asin-code="<?php echo $asin_code ?>" href="">
                	<img src="<?php echo $img_url ?>" alt="">
                </a>
                <a target="_blank" href="<?php echo $amzn_url ?>">View on Amazon</a>
            </div>
        <?php
		}
	endwhile; wp_reset_query(); 
}

/**
 * Variable transmission to javascript
 */

function localize_js_vars ()
{
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    </script>

    <?php
}
add_action( 'wp_head', 'localize_js_vars' );


function enter_sweepstakes () {
	update_user_meta( get_current_user_id(), 'entered_sweepstakes', true );
}
add_action( 'wp_ajax_enterSweepstakes', 'enter_sweepstakes' );

function mailchimp_subscribe() {
	include('inc/MailChimp.php');
	$MailChimp = new MailChimp('465d8dac5f4b90a67722fab43f2db7a4-us15');
	$list_id = '1bf4d95e45';
	$current_user = wp_get_current_user();
	$email_address = $current_user->user_email;

	$result = $MailChimp->post("lists/$list_id/members", [
	                'email_address' => $email_address,
	                'status'        => 'subscribed',
	            ]);

	if ($MailChimp->success()) {
    	print_r($result); 
    	update_user_meta( get_current_user_id(), 'subscribed', true );  
	} else {
	    echo $MailChimp->getLastError();
	}

	wp_send_json($result);
}
add_action( 'wp_ajax_mailChimpSubscribe', 'mailchimp_subscribe' );

function isUserSubscribed() {
	include('inc/MailChimp.php');
	$MailChimp = new MailChimp('465d8dac5f4b90a67722fab43f2db7a4-us15');
	$list_id = '1bf4d95e45';
	$current_user = wp_get_current_user();
	$email_address = $current_user->user_email;

	$user_id = md5($email_address);

	$result = $MailChimp->get('lists/' . $list_id . '/members/' . $user_id, [
				'email_address' => $email_address,
                'status'        => 'subscribed',
			]);

	if ($result["email_address"]) {
		return true;
	} 

	return false;
}

function getDogsAgeWeightBreed() {
	$listOfDogsVitals = array(); // Will hold deduped list of all dogs ages, weights, and breeds
	$the_dog_query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );
	if($the_dog_query->have_posts()){
	    while ( $the_dog_query->have_posts() ) {
	        $the_dog_query->the_post();
	        $post_id = get_the_ID();
	        // get list of post_meta values associated with dogs (age, weight, breed);
	        $dogs_age = get_post_meta( $post_id, 'dogs_age', true );
	        $dogs_weight = get_post_meta( $post_id, 'dogs_weight', true );
	        $dogs_breed = get_post_meta( $post_id, 'dogs_breed', true );
	        // put them in an array
	        array_push($listOfDogsVitals, $dogs_age);
	        array_push($listOfDogsVitals, $dogs_weight);
	        array_push($listOfDogsVitals, $dogs_breed);
	    }
	    wp_reset_postdata();
	}
	// Dedupe array();
	$listOfDogsVitals = array_unique($listOfDogsVitals);
	return $listOfDogsVitals;
}

function getPostIDsWithScores($listOfDogsVitals) {
	$args = array(
	        'post_type' => 'post'
	    );

	$post_query = new WP_Query($args);
	$post_categories = array();

	if($post_query->have_posts() ) {
	  while($post_query->have_posts() ) {
	    $post_query->the_post();
	    $post_id = get_the_ID();
	    $categories = get_the_category();
	    $articlePoints = 0;
	    // loop list of post categories to check if the dogs meta value is present in the category array
	    foreach ($categories as $category) {
    		$isCategoryMatch = array_search($category->slug, $listOfDogsVitals);
	    	$isCategoryMatch++; // To make sure index 0 passes the following conditional check
	    	if ( $isCategoryMatch ) {
	    		$articlePoints++;
	    	}
	    }
	    // add post ID and associated points to array
		$posts_with_scores[$post_id] = $articlePoints;
	  }
	  wp_reset_postdata();
	}

	// sort array by articlePoints
	arsort($posts_with_scores);
	return $posts_with_scores;
}

// Returns associative array with each index being $post_id => $articlePoints, sorted by $articlePoints
function getSortedArticleIDs() {
	$listOfDogsVitals = getDogsAgeWeightBreed();
	$posts_with_scores = getPostIDsWithScores($listOfDogsVitals);
	return $posts_with_scores;
}

function setOpenGraph() {
    global $post;

    $img_src = get_the_post_thumbnail_url( $post->ID );
    // TODO: set default og:image
    // if (!$img_src) {
    // 	$img_src = "Set Default Image"
    // }
    // TODO: set real OG description
    $description = "test description";
    ?>
 
 	<meta property="fb:app_id" content="1850125755275228"/>
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $description; ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php the_permalink() ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src ?>"/>
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="Its a Dog!">
	<meta name="twitter:creator" content="">
	<meta name="twitter:title" content="It's a Dog!">
	<meta name="twitter:description" content="test">
	<meta name="twitter:image" content="<?php echo $img_src ?>">
 
<?php
}
add_action('wp_head', 'setOpenGraph', 5);
