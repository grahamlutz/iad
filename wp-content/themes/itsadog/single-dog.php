<?php
/**
 * The template for displaying all dog posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package itsadog
 */

get_header(); ?>

	<div id="primary" class=" container content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			?>
			<div class="row">
				<h2><?php the_field( 'dogs_breed', get_the_ID() ); ?></h2>
			</div>
			<div class="row">
				<div class="col-md-4">
					<?php
					the_post_thumbnail();
					?>
				</div>
				<div class="col-md-8 registry-items-box">
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
								<h2><?php echo $category->name;?></h2>
								<div class="item-display">
							      <?php 

							      	$product_id = get_post_meta( get_the_ID(), $category_name, true );
							      	$asin_code = get_post_meta( $product_id[0], 'asin_code', true);
							      	$img_url = get_post_meta( $product_id[0], 'item_image_url', true );
							      	$product_link = get_post_meta( $product_id[0], 'item_url', true );

							      	// Get the full product info? 
							     	// require_once "custom-post-types/AmazonProductAPI.php";
							     	// $item = new AmazonProductAPI();
								    // try {
								    //   $result = $item->getProductByAsin($asin_code);
								    // } catch (Exception $e) {
								    //   return;
								    // }
							      ?>
							      <a href="<?php echo $product_link ?>">
							      	<img src="<?php echo $img_url ?>"?>
							      	<p>Buy Now!</p>
							      </a>
							    </div>
							</div>
						
						<?php
					}

					?>
				</div> <!-- end .registry-items-box -->
			</div>
		<?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();