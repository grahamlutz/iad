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

	get_template_part( 'template-parts/dashboard', 'subscribe' );
	get_template_part( 'template-parts/dashboard', 'dog');
	get_template_part( 'template-parts/dashboard', 'articles');

?>
</div>