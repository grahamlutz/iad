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
	  <?php

	  $options = array(

		/* (string) Unique identifier for the form. Defaults to 'acf-form' */
		'id' => 'add-dog-form',
		
		/* (int|string) The post ID to load data from and save data to. Defaults to the current post ID. 
		Can also be set to 'new_post' to create a new post on submit */
		'post_id' => new_post,
		
		/* (array) An array of post data used to create a post. See wp_insert_post for available parameters.
		The above 'post_id' setting must contain a value of 'new_post' */
		'new_post' => array(
						'post_type'		=> 'dog',
						'post_status'		=> 'draft'
					),
		
		/* (array) An array of field group IDs/keys to override the fields displayed in this form */
		/* 38 is for localhost, 22 is for production */
		/* It would be nice to have a dynamic way of doing this... */
		'field_groups' => array( 38, 22 ),
		
		/* (array) An array of field IDs/keys to override the fields displayed in this form */
		//'fields' => array(1,2,3,4),
		
		/* (boolean) Whether or not to show the post title text field. Defaults to false */
		'post_title' => true,
		
		/* (boolean) Whether or not to show the post content editor field. Defaults to false */
		'post_content' => false,
		
		/* (boolean) Whether or not to create a form element. Useful when a adding to an existing form. Defaults to true */
		'form' => true,
		
		/* (array) An array or HTML attributes for the form element */
		//'form_attributes' => array(),
		
		/* (string) The URL to be redirected to after the form is submit. Defaults to the current URL with a GET parameter '?updated=true'.
		A special placeholder '%post_url%' will be converted to post's permalink (handy if creating a new post) */
		'return' => '',
		
		/* (string) Extra HTML to add before the fields */
		'html_before_fields' => '',
		
		/* (string) Extra HTML to add after the fields */
		'html_after_fields' => '',
		
		/* (string) The text displayed on the submit button */
		'submit_value' => __("Add Dog", 'acf'),
		
		/* (string) A message displayed above the form after being redirected. Can also be set to false for no message */
		'updated_message' => __("Post updated", 'acf'),
		
		/* (string) Determines where field labels are places in relation to fields. Defaults to 'top'. 
		Choices of 'top' (Above fields) or 'left' (Beside fields) */
		'label_placement' => 'top',
		
		/* (string) Determines where field instructions are places in relation to fields. Defaults to 'label'. 
		Choices of 'label' (Below labels) or 'field' (Below fields) */
		'instruction_placement' => 'label',
		
		/* (string) Determines element used to wrap a field. Defaults to 'div' 
		Choices of 'div', 'tr', 'td', 'ul', 'ol', 'dl' */
		'field_el' => 'div',
		
		/* (string) Whether to use the WP uploader or a basic input for image and file fields. Defaults to 'wp' 
		Choices of 'wp' or 'basic'. Added in v5.2.4 */
		'uploader' => 'basic',
		
		/* (boolean) Whether to include a hidden input field to capture non human form submission. Defaults to true. Added in v5.3.4 */
		'honeypot' => true
		
	);

	acf_form( $options );

	acf_enqueue_uploader(); ?>
	<script type="text/javascript">
	(function($) {
		
		// setup fields
		acf.do_action('append', $('#popup-id'));
		
	});
</script>

	</div> <!-- pet-profile-container -->
</div> <!-- slider-section -->

