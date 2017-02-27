<?php
/**
 * Template part for displaying the half-width dog info box on the logged in homepage dashboard
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

$the_query = new WP_Query( array( 'author' => get_current_user_id(), 'post_type' => 'dog' ) );

	if($the_query->have_posts()){
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        $post_id = get_the_ID();
	        $img_url = get_the_post_thumbnail_url();
	        ?>

	        <div class="col-md-6 dog <?php echo the_title() ?> dog<?php echo $post_id ?>">
	        	<div class="col-md-3 image-conatiner">
	        		<img src="<?php echo $img_url ?>" alt="" class="dog-image">
	        	</div>
	        	<div class=" col-md-9 dog-info">
		        	<div class="row">
		        		<h3 class="col-md-6"><?php echo the_title() ?>'s Profile</h3>




		        		

		        		<!-- get_template_part( 'template-parts/dog', 'edit' ); -->
		        		<!-- If I use get_template_part(), then $post_id doesn't work in the modal... -->
		        		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dog<?php echo $post_id ?>Modal">Edit <?php echo the_title() ?>'s information
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

									/* (int|string) The post ID to load data from and save data to. Defaults to the current post ID. 
									Can also be set to 'new_post' to create a new post on submit */
									'post_id' => $post_id,
									
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

		        	





		        	</div>
		        	<div class="row">
		        		<p class="col-md-6">Registrered Items</p>
		        		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $post_id ?>Modal">
						  Edit Registry
						</button>
		        	</div>
		        	<div class="row">
		        		<p>Placeholder for progress bar</p>
		        	</div>
	        	</div>
	        </div>
	        
	        <!-- Registry Modal -->
			<div class="modal fade" id="<?php echo $post_id ?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?php echo $post_id ?>ModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        
					<!-- Category tabs -->
					<div class="row">
					    <div class="col-md-3">
						
						<?php

							$args = array( 
					            'post_type' => 'registry_product', 
					            'taxonomy'  => 'registry_product_categories', 
					            'orderby'   => 'id', 
					            'order'     => 'ASC' 
					        );

							$categories = get_categories( $args );

							?>

							<ul class="nav nav-tabs md-pills pills-primary flex-column" role="tablist">

							<?php

							foreach ($categories as $category) {

								$category_name = strtolower(str_replace(" ", "_", $category->name));

								?>

								<li class="nav-item">
					                <a class="nav-link active" data-toggle="tab" href="#panel<?php echo $category_name; ?>" role="tab"><?php echo $category->name; ?></a>
					            </li>

								<?php
							};
						?>

					        </ul>
					    </div>
					    <div class="col-md-7">
					        <!-- Tab panels -->
					        <div class="tab-content vertical">
					        	<?php

					        	foreach ($categories as $category) {

									$category_name = strtolower(str_replace(" ", "_", $category->name));

									?>

									<div class="tab-pane fade <?php if ($category_name == 'beds_and_blankets'){ echo "in active";} ?>" id="panel<?php echo $category_name; ?>" role="tabpanel">
						                <br>
						                <?php

								      	$product_args = array(
							                            'post_type'     => 'registry_product',
							                            'orderby'       => 'id',
							                            'order'         => 'ASC',
							                            'post_status'   => 'publish',
							                            'tax_query'     => array(
																			 array(
																			  	'taxonomy' => 'registry_product_categories',
																				'field'    => 'slug',
																				'terms'    => $category->slug,
																			),
																		),
							                        );

							            $product_list = new WP_Query ( $product_args ); 

							            ?>

							            <?php while ( $product_list -> have_posts() ) : $product_list -> the_post();

							            	 $img_url = get_post_meta( get_the_ID(), 'item_image_url', true );
							            	 $asin_code = get_post_meta( get_the_ID(), 'asin_code', true ); 
							            ?>

							                <div class="product">
							                	<h3 class="title ellipsis"><?php the_title(); ?></h3>
							                    <a class="asin-code <?php echo $asin_code ?>" data-category="<?php echo $category->slug ?>" data-asin-code="<?php echo $asin_code ?>" href="">
							                    	<img src="<?php echo $img_url ?>" alt="">
							                    </a>
							                </div>

							            <?php endwhile; wp_reset_query(); 

								      ?>
						            </div>

									<?php
								};

								?>
					 
					        </div>
					    </div>
					</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>

	        <?php
	    }
	    wp_reset_postdata();
	}
