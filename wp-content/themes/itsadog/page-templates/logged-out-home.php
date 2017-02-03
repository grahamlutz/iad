<?php
/**
 * Template Name: Logged Out Homepage
 * Description: Page template without sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

get_header();

?>

	<div id="primary" class="content-area">
		<main id="logged-out-home" class="site-main" role="main">

      <div class="slider-section get-started-section">
				<div class="content-container">
					<p>Congratulations - It's a dog!</p>
          <p>Sign up and share your It's a Dog! pet registry</p>
          <p>and enter to win our sweepstakes.</p>
          <button type="button" name="get-started-btn">Get Started</button>
          <p>or</p>
          <button type="button" name="login-btn">Login</button>
				</div>
      </div>

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

      <div class="slider-section customize-registry-section">
        <div class="customize-registry">
          <h2>Customize Registry</h2>
          <div class="registry-items-box">

          </div>
        </div>
        <div class="enter-to-win">
          <h2>Enter to Win:</h2>
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
          <button type="button" name="enter-sweepstakes">Enter Sweepstakes</button>
          <p class="terms-of-service">*terms of service copy</p>
        </div>
      </div>

      <div class="slider-section try-free-section">
        <div class="image-container">
          <img src="" alt="">
        </div>
        <div class="right-content">
          <h3>Congrats! You're entered to win.</h3>
          <h3>Would you like to try a free dose of Nexgard?</h3>
          <button type="button" name="free-dose-yes">Yes</button>
          <p class="social-share-text">Create a free registry and get a free nexgard #itsadog</p>
          <div class="social-icon-container">
            <p>social</p>
            <a href="#"><img src="" alt=""></a>
            <a href="#"><img src="" alt=""></a>
            <a href="#"><img src="" alt=""></a>
            <a href="#"><img src="" alt=""></a>
            <a href="#"><img src="" alt=""></a>
          </div>
          <button type="button" name="add-another-dog">Add Another Dog</button>
        </div>
      </div>

			<?php
			// while ( have_posts() ) : the_post();
			//
			// 	get_template_part( 'template-parts/content', 'page' );
			//
			// 	// If comments are open or we have at least one comment, load up the comment template.
			// 	if ( comments_open() || get_comments_number() ) :
			// 		comments_template();
			// 	endif;
			//
			// endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
