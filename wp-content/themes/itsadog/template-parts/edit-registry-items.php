<?php
/**
 * Template part for looping through registry items and displaying modal to popup and edit
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package itsadog
 */

?>

<!-- Begin Edit Registry Modal -->

<button type="button" class="btn btn-primary" data-post-id="<?php echo $post_id ?>" data-toggle="modal" data-target="#<?php echo $post_id ?>Modal">
  Edit Registry
</button>


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
		                <a class="nav-link active" data-category="<?php echo $category_name; ?>" data-toggle="tab" href="#panel<?php echo $category_name; ?>" role="tab"><?php echo $category->name; ?></a>
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

						<div class="<?php echo $category_name; ?> tab-pane fade <?php if ($category_name == 'beds_and_blankets'){ echo "in active";} ?>" id="panel<?php echo $category_name; ?>" role="tabpanel" data-category="<?php echo $category_name; ?>">
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
				            
				            $product_IDs = getCurrentRegistryProductIDs( $category_name, $post_id );
			            	
				            ?>
							<div class="col-md-6 in-registry">
								<h3>In Registry</h3>
					            <?php while ( $product_list -> have_posts() ) : $product_list -> the_post();

					            	$img_url = get_post_meta( get_the_ID(), 'item_image_url', true );
					            	$asin_code = get_post_meta( get_the_ID(), 'asin_code', true ); 

					            	$item_key = array_search( get_the_ID(), $product_IDs );
					            	$item_key++;
									
									if ( $item_key ) {
									?>
										<div class="product <?php echo $category->slug ?>" id="product<?php echo get_the_ID() ?>">
						                	<h3 class="title ellipsis"><?php the_title(); ?></h3>
						                    <a class="asin-code <?php echo $asin_code ?>" data-category="<?php echo $category->slug ?>" data-asin-code="<?php echo $asin_code ?>" href="">
						                    	<img src="<?php echo $img_url ?>" alt="">
						                    </a>
						                </div>
						            <?php
									}
									?>
					            <?php endwhile; wp_reset_query(); 
					            ?>
					        </div> <!-- .in-registry -->
					        <div class="col-md-6 not-in-registry">
					        	<h3>Not in Registry</h3>
					            <?php while ( $product_list -> have_posts() ) : $product_list -> the_post();

					            	$img_url = get_post_meta( get_the_ID(), 'item_image_url', true );
					            	$asin_code = get_post_meta( get_the_ID(), 'asin_code', true ); 

					            	$item_key = array_search( get_the_ID(), $product_IDs );
					            	$item_key++;
					            ?>
									<?php
										if ( $item_key === false ) {
										?>
											<div class="product <?php echo $category->slug ?>" id="product<?php echo get_the_ID() ?>">
							                	<h3 class="title ellipsis"><?php the_title(); ?></h3>
							                    <a class="asin-code <?php echo $asin_code ?>" data-category="<?php echo $category->slug ?>" data-asin-code="<?php echo $asin_code ?>" href="">
							                    	<img src="<?php echo $img_url ?>" alt="">
							                    </a>
							                </div>
							            <?php
										}
									?>
					            <?php endwhile; wp_reset_query(); 
					            ?>
					        </div> <!-- .in-registry -->
			            </div> <!-- .tab-pane -->

						<?php
					};

					?>
		 
		        </div> <!-- .tab-content -->
		    </div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- .modal -->

<!-- End Edit Registry Modal -->