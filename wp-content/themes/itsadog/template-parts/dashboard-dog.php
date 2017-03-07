<?php
/**
 * Template part for displaying the half-width dog info box on the logged in homepage dashboard
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

$the_query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );

	if($the_query->have_posts()){
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        $post_id = get_the_ID();
	        $img_url = get_the_post_thumbnail_url();
	        ?>

	        <div class="col-md-6 dog <?php echo the_title() ?> dog<?php echo $post_id ?>" data-dog-id="<?php echo $post_id ?>">
	        	<div class="col-md-3 image-conatiner">
	        		<img src="<?php echo $img_url ?>" alt="" class="dog-image">
	        	</div>
	        	<div class=" col-md-9 dog-info">
		        	<div class="row">
		        		<h3 class="col-md-6"><?php echo the_title() ?>'s Profile</h3>

						<?php get_template_part( 'template-parts/dog', 'edit' ); ?>

		        	</div>
		        	<div class="row">
		        		<p class="col-md-6">Registrered Items</p>

						<?php get_template_part( 'template-parts/edit', 'registry-items' ); ?>

		        	</div>
		        	<div class="row">
		        		<p>Placeholder for progress bar</p>
		        	</div>
	        	</div>
	        </div>
	        <?php
	    }
	    wp_reset_postdata();
	} else {
		?>
		<div class="container">
			<p>Your dog is being reviewed</p>
		</div>
		<?php
	}
