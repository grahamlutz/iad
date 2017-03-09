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

$posts_with_scores = getSortedArticleIDs(); 

foreach ( $posts_with_scores as $post_id => $articlePoints) {
		$article = get_post($post_id, ARRAY_A);
		$title = $article['post_title'];
		?>
	    <!-- TODO: make a 5-column layout -->
	    <div class="col-md-3 article-box">
	    	<h2><?php echo $title ?></h2>
	    </div>
	    <?php
	}

?>

</div>