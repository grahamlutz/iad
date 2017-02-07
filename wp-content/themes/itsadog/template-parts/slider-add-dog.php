<?php
/**
 * Template part for displaying add dog section of logged out home page slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="slider-section add-dog-seciton">
	<div class="photo-upload-container">
				<i class="fa fa-plus" aria-hidden="true"></i>
				<p>Upload a photo of your dog</p>
	</div>
	<div class="filter-container">
				<p>set filter</p>
				<div class="filter-icon filter-1">

				</div>
				<div class="filter-icon filter-2">

				</div>
				<div class="filter-icon filter-3">

				</div>
				<div class="filter-icon filter-4">

				</div>
	</div>
	<div class="pet-profile-container">
	  <h2>Pet Profile</h2>
	  <form class="pet-profile" action="index.html" method="post">
	    <input type="text" name="name" value="">
	    <input type="text" name="weight" value="">
	    <input type="text" name="month" value=""><input type="text" name="year" value="">
	    <input type="text" name="breed" value="">
	    <button type="submit" name="button">Add Dog</button>
	  </form>
	</div>
</div>