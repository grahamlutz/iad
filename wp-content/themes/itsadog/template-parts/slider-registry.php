<?php
/**
 * Template part for displaying registry customization section of logged out home page slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="slider-section customize-registry-section">
	<div class="customize-registry col-md-6">
	  <h2>Customize Registry</h2>
	  <div class="registry-items-box">
		<?php 

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

			<div class="product_category <?php echo $category_name; ?>">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".<?php echo $category_name; ?>Modal">
				  <?php echo $category->name; // insert appropriate image here ?>
				</button>
			</div>

			<!-- Modal to display all items in seleced category -->
			<div class="modal fade <?php echo $category_name; ?>Modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

		            <?php while ( $product_list -> have_posts() ) : $product_list -> the_post(); ?>

		                <div class="product">
		                	<h3 class="title"><?php the_title(); ?></h3>
		                    <!-- get_post_meta() and display -->
		                </div>

		            <?php endwhile; wp_reset_query(); 

			      ?>
			    </div>
			  </div>
			</div>

			<?php
		}

		?>
	  </div>
	</div>
	<div class="enter-to-win col-md-6">
	  <h2>Enter to Win:</h2>
		</div>
	  <ul>
	    <li></li>
	    <li></li>
	    <li></li>
	  </ul>
	  <button type="button" name="enter-sweepstakes">Enter Sweepstakes</button>
	  <p class="terms-of-service">*terms of service copy</p>
	</div>
</div>