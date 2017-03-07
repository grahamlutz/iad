<?php
/**
 * Template Name: Homepage
 * Description: Page template without sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

get_header();

?>

	<div id="primary" class="content-area">
		<main id="home" class="site-main" role="main">

      <?php

      function user_has_dog($user_id) {
        $result = new WP_Query(array(
          'author'=>$user_id,
          'post_type'=>'dog',
          'post_status'=>'publish',
          'posts_per_page'=>1,
        ));
        return (count($result->posts)!=0);
      }

      // if ( is_user_logged_in() && user_has_dog($user->ID) ) { // && is entered in sweepstakes
      //     get_template_part( 'template-parts/dashboard' );
      // } else {
         get_template_part( 'template-parts/slider' );
      // }

      ?>

			<?php
			// while ( have_posts() ) : the_post();
			//
			// 	get_template_part( 'template-parts/content', 'page' );
			//
			// 	// If comments are open or we have at least one comment, load up the comment template.
			// 	if ( comments_open() || get_comments_number() ) :
			// 		comments_template();
			// 	endif;
			//
			// endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
