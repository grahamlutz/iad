<?php
/**
 * Template Name: Edit Account Info
 * Description: Page template without sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

get_header();

?>

<div id="primary" class="content-area">
	<main id="edit-acount-info" class="site-main" role="main">

	<?php

	echo do_shortcode( '[rp_profile_edit] ' );

	?>
	
	</main>
</div> <!-- #primary -->