<?php
/**
 * Template part for displaying 'Edit Dog's info button and popup.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo "dog" . $post_id ?>Modal">Edit <?php echo the_title() ?>'s information
</button>
<!-- Modal -->
<div class="modal fade" id="<?php echo "dog" . $post_id ?>Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo the_title() ?>'s Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- This is where we create a form to update the dog's info -->
		<?php

		$options = array(

			/* (string) Unique identifier for the form. Defaults to 'acf-form' */
			'id' => 'edit-dog-form',
			
			/* (array) An array of field group IDs/keys to override the fields displayed in this form */
			/* 38 is for localhost, 22 is for production */
			/* TODO: It would be nice to have a dynamic way of doing this... */
			'field_groups' => array( 38, 22 ),
			
			/* (boolean) Whether or not to show the post title text field. Defaults to false */
			'post_title' => true,
			
			/* (string) The URL to be redirected to after the form is submit. Defaults to the current URL with a GET parameter '?updated=true'.
			A special placeholder '%post_url%' will be converted to post's permalink (handy if creating a new post) */
			'return' => '',
			
			/* (string) Extra HTML to add before the fields */
			'html_before_fields' => '',
			
			/* (string) Extra HTML to add after the fields */
			'html_after_fields' => '',
			
			/* (string) The text displayed on the submit button */
			'submit_value' => __("Save Dog's Info", 'acf'),
			
			/* (string) A message displayed above the form after being redirected. Can also be set to false for no message */
			'updated_message' => __("Post updated", 'acf'),
			
			/* (string) Determines where field labels are places in relation to fields. Defaults to 'top'. 
			Choices of 'top' (Above fields) or 'left' (Beside fields) */
			'label_placement' => 'top',
			
			/* (string) Determines where field instructions are places in relation to fields. Defaults to 'label'. 
			Choices of 'label' (Below labels) or 'field' (Below fields) */
			'instruction_placement' => 'label',
			
		);

		acf_form( $options );

		acf_enqueue_uploader(); ?>
		<script type="text/javascript">
			(function($) {
				
				// setup fields
				acf.do_action('append', $('#popup-id'));
				
			});
		</script>
      </div>
    </div>
  </div>
</div>