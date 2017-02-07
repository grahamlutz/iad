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
		<main id="logged-out-home" class="site-main" role="main">

      <?php

      if ( is_user_logged_in() ) { // AND Has Dog AND is entered in sweepstakes
          get_template_part( 'template-parts/dashboard' );
      } else {
          get_template_part( 'template-parts/slider' );
      }

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
