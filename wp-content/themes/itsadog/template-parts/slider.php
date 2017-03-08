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

	// helper function for determining user lifecycle.
	// 0 = User logged out
	// 1 = User is logged in, has no dog
	// 2 = User is logged in, has dog
	// 3 = User is logged in, has dog, has registry

	$uid = get_current_user_id();
	$the_dog_query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );

	$get_user_progression_status = function ($user_id) {
		if(is_user_logged_in()) {
			if( get_user_meta( $user_id, 'entered_sweepstakes', true) == '1' || $the_dog_query->post_count > 1 ) {
				return 3;
			}
			$query = new WP_Query( array( 'author' => $user_id, 'post_type' => 'dog' ) );
			if($query->post_count > 0) {
				return 2;
			}
			return 1;
		} else {
			return 0;
		}
	};

	$progress = $get_user_progression_status($uid);

	if( $progress == 3 ){ 	// 3 = User is slogged in, has dog, has registry
		get_template_part( 'template-parts/dashboard' );
	} else {
		if( $progress == 0 ) {	// 0 = User logged out
			get_template_part( 'template-parts/slider', 'get-started' );
			get_template_part( 'template-parts/slider', 'registration' );
			get_template_part( 'template-parts/slider', 'add-dog' );
			get_template_part( 'template-parts/slider', 'registry' );
		} else if( $progress == 1 ) {	// 1 = User is logged in, has no dog
			get_template_part( 'template-parts/slider', 'add-dog' );
			get_template_part( 'template-parts/slider', 'registry' );
		} else if( $progress == 2 ) {	// 2 = User is logged in, has dog
			get_template_part( 'template-parts/slider', 'registry' );
		}
		get_template_part( 'template-parts/slider', 'social' );
	} 

?>
