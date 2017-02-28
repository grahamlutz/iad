<?php
/**
 * Template part for displaying logged in home page dashboard
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="logged-in-dashboard">
<?php
	
	$uid = get_current_user_id();

	// TODO: maybe set this up to check if they are on the list instead?
	if ( get_user_meta( $uid, 'entered_sweepstakes', true) !== '1' ) {
		get_template_part( 'template-parts/dashboard', 'subscribe' );
	}
	get_template_part( 'template-parts/dashboard', 'dog');
	get_template_part( 'template-parts/dashboard', 'articles');

?>
</div>