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

	acf_form_head(); 

	get_template_part( 'template-parts/slider', 'get-started' );

	get_template_part( 'template-parts/slider', 'registration' );

	get_template_part( 'template-parts/slider', 'add-dog' );

	get_template_part( 'template-parts/slider', 'registry' );

	get_template_part( 'template-parts/slider', 'social' );

?>