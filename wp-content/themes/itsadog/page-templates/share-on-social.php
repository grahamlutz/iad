<?php
/**
 * Template Name: Share on Social
 * Description: Page template without sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

get_header();

?>

<div id="primary" class="content-area">
	<main id="manage-registry" class="site-main" role="main">

	<?php

	$post_id;
	$the_query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );

	if($the_query->have_posts()){
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        $post_id = get_the_ID();
	        $img_url = get_the_post_thumbnail_url();

	        // For each dog, create a box with image, name, and info that is col-md-5ish. 

	        ?>
	        <div class="row manage-dog-box <?php echo $post_id ?>">
	        	<div class="col-md-5 image-conatiner">
	        		<img src="<?php echo $img_url ?>" alt="" class="dog-image">
	        	</div>
	        	<div class=" col-md-7 dog-info">
		        	<div class="row">
		        		<p >Share on Social!</p>
						<textarea>Check out my registry! #itsadog</textarea>
		        	</div>
		        	<div class="row">
		        		<div class="facebook col-md-6">
		        			<button data-dog-id="<?php echo $post_id ?>" data-dog-name="<?php echo the_title() ?>" class="btn btn-primary">Facebook</button>
		        		</div>
		        		<div class="instagram col-md-6">
		        			<button class="btn btn-primary">Instagram</button>
		        		</div>
		        		<div class="twitter col-md-6">
		        			<button class="btn btn-primary">Twitter</button>
		        		</div>
		        		<div class="email col-md-6">
		        			<button class="btn btn-primary">Email</button>
		        		</div>
		        	</div>
	        	</div>
			</div> <!-- .manage-dog-box -->
		<?php
	    }
	}
	?>
	</main>
</div>  <!-- #primary -->

<?php

get_footer();