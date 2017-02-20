<?php
/**
 * Template part for displaying logged out home page slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<?php



	//helper function for determining user lifecycle.
	$get_user_progression_status = function ($user_id) {
			if(is_user_logged_in()) {
				if(//has regisry)
					{
						return 3;
					}
				$query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );
				if($query->post_count > 0) {
						return 2;
					}
				return 1;
			} else {
				return 0;
			}
	}

	get_template_part( 'template-parts/slider', 'get-started' );

	get_template_part( 'template-parts/slider', 'registration' );

	get_template_part( 'template-parts/slider', 'add-dog' );

	get_template_part( 'template-parts/slider', 'registry' );

	get_template_part( 'template-parts/slider', 'social' );

?>
