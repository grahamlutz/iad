<?php
/**
 * Template part for looping through registry items and displaying modal to popup and edit
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="col-md-7 registry-items-box">
	<?php 

	$post_id = get_the_ID();

	$args = array( 
        'post_type' => 'registry_product', 
        'taxonomy'  => 'registry_product_categories', 
        'orderby'   => 'id', 
        'order'     => 'ASC' 
    );

	$categories = get_categories( $args );

	foreach ($categories as $category) {

		$category_name = strtolower(str_replace(" ", "_", $category->name));
		?>

		<div class="col-md-3 product_category <?php echo $category_name; ?>">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".<?php echo $post_id . $category_name; ?>Modal">
			  <?php echo $category->name; // insert appropriate image here ?>
			</button>
			<?php
			//if ($category_name == )
			?>
		</div>

		<!-- Modal to display all items in seleced category -->
		<div class="modal fade <?php echo $post_id . $category_name; ?>Modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <?php

		      	$product_args = array(
	                            'post_type'     => 'registry_product',
	                            'orderby'       => 'id',
	                            'order'         => 'ASC',
	                            'post_status'   => 'publish',
	                            'tax_query'     => array(
													 array(
													  	'taxonomy' => 'registry_product_categories',
														'field'    => 'slug',
														'terms'    => $category->slug,
													),
												),
	                        );

	            $product_list = new WP_Query ( $product_args ); 

	            ?>

	            <?php while ( $product_list -> have_posts() ) : $product_list -> the_post();

	            	 $img_url = get_post_meta( get_the_ID(), 'item_image_url', true );
	            	 $asin_code = get_post_meta( get_the_ID(), 'asin_code', true ); 
	            	 $current_registry_product  = get_posts(array(
						'post_type' => 'dog',
						'meta_query' => array(
							array(
								'key' => $category->slug, // name of custom field
								'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
								'compare' => 'LIKE'
							)
						),
						'author' => get_current_user_id()
					));
	            ?>

	                <div class="product">
	                	<h3 class="title ellipsis"><?php the_title(); ?></h3>
	                    <a class="asin-code <?php echo $asin_code ?>" data-category="<?php echo $category->slug ?>" data-asin-code="<?php echo $asin_code ?>" href="">
	                    	<img src="<?php echo $img_url ?>" alt="">
	                    </a>
	                    <?php
	              //       if ($current_registry_product) {
	              //       	?>
	                         <!-- <p>this is in dog's regisry</p> -->
	                    	<?php
	              //       }
	              //       echo "<pre class='tada'>";
		            	// var_dump($current_registry_product);
		            	// echo "</pre>";
	                
	                    ?>
	                </div>

	            <?php endwhile; wp_reset_query(); 

		      ?>
		    </div>
		  </div> <!-- .modal-dialog -->
		</div> <!-- end .<?php echo $post_id . $category_name; ?>Modal -->

		<?php
	}

	?>
</div> <!-- end .registry-items-box -->