<?php
/**
 * Template part for displaying registry customization section of logged out home page slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="slider-section customize-registry-section">
	<div class="customize-registry col-md-6">
	  <h2>Customize Registry</h2>
	  <?php

	  get_template_part( 'template-parts/edit', 'registry-items' );

	  ?>
	<div class="enter-to-win col-md-6">
	  <h2>Enter to Win:</h2>
		</div>
	  <ul>
	    <li></li>
	    <li></li>
	    <li></li>
	  </ul>
	  <button type="button" class="enter-sweepstakes" name="enter-sweepstakes">Enter Sweepstakes</button>
	  <p class="terms-of-service">*terms of service copy</p>
	</div>
</div>