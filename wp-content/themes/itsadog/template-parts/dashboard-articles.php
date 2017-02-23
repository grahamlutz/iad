<?php
/**
 * Template part for displaying the list of articles on the logged in homepage dashboard
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */
?>

<div class="articles-container">

<?php

	// TODO: set it up to pull articles based on dog's characteristics
	$args = array(
	        'post_type' => 'post'
	    );

	$post_query = new WP_Query($args);

	if($post_query->have_posts() ) {
	  while($post_query->have_posts() ) {
	    $post_query->the_post();
	    ?>
	    <!-- TODO: make a 5-column layout -->
	    <div class="col-md-3 article-box">
	    	<h2><?php the_title(); ?></h2>
	    </div>
	    <?php
	  }
	}
?>

</div>