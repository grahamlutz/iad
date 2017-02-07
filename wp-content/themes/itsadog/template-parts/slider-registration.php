<?php
/**
 * Template part for displaying user registration section of logged out home page slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<div class="slider-section login-register-section">
  <div class="facebook-login-container">
		<h3>Login With</h3>
    <?php do_action('facebook_login_button');?>
  </div>
  <div class="or-divider">
		<hr width="1" size="50">
    <p>or</p>
		<hr width="1" size="50">
  </div>
  <div class="wordpress-login-container">
		<h3>Create Your Owner Profile</h3>
    <?php echo do_shortcode( '[rp_register_widget]' ); ?>
  </div>
</div>