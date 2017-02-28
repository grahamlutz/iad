<?php
/**
 * Template Name: Manage Registry
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
	        <div class="row manage-dog-box">
		        <div class="col-md-5 dog <?php echo the_title() ?> dog<?php echo $post_id ?>">
		        	<div class="col-md-3 image-conatiner">
		        		<img src="<?php echo $img_url ?>" alt="" class="dog-image">
		        	</div>
		        	<div class=" col-md-9 dog-info">
			        	<div class="row">
			        		<p ><?php echo the_title() ?></p>
			        		<?php
			        		get_template_part( 'template-parts/dog', 'edit' );
			        		?>
							<p>Share your registry</p>
							<p>Delete Dog</p>
			        	</div>
			        	<div class="row">
			        		<p class="col-md-6">Registrered Items</p>
			        		<p data-toggle="modal" data-target="#<?php echo $post_id ?>Modal">
							  Edit Registry
							</p>
			        	</div>
		        	</div>
		        </div> <!-- .col-md-5 dog -->

		        <?php

		        get_template_part( 'template-parts/edit', 'registry-items' );

		        ?>
			</div> <!-- .manage-dog-box -->
		<?php
	    }
	}
	?>
	</main>
</div>  <!-- #primary -->

<?php

get_template_part( 'template-parts/dog', 'add' );
get_footer();
