<div class="wooOneContainer">

	<div class="wooOneWelcomeContainer">
		
			<?php
			
				$texezoWelcomePostTitle = '';
				$texezoWelcomePostDesc = '';
				$texezoWelcomePostContent = '';

				if( '' != get_theme_mod('texezo_wooone_welcome_post') && 'select' != get_theme_mod('texezo_wooone_welcome_post') ){

					$texezoWelcomePostId = get_theme_mod('texezo_wooone_welcome_post');

					if( ctype_alnum($texezoWelcomePostId) ){

						$texezoWelcomePost = get_post( $texezoWelcomePostId );

						$texezoWelcomePostTitle = $texezoWelcomePost->post_title;
						$texezoWelcomePostDesc = $texezoWelcomePost->post_excerpt;
						$texezoWelcomePostContent = $texezoWelcomePost->post_content;

					}

				}			
			
			?>
			
			<h1><?php echo esc_html($texezoWelcomePostTitle); ?></h1>
			<div class="wooOneWelcomeContent">
				<p>
					<?php 
					
						if( '' != $texezoWelcomePostDesc ){
							
							echo esc_html($texezoWelcomePostDesc);
							
						}else{
							
							echo esc_html($texezoWelcomePostContent);
							
						}
					
					?>
				</p>
			</div><!-- .wooOneWelcomeContent -->	
		
	</div><!-- .wooOneWelcomeContainer -->
	
	
	<div class="new-arrivals-container">
		
		<?php 
					
			if( 'no' != get_theme_mod('texezo_show_wooone_heading') ): 
			
				$texezoWooOneLatestHeading = __('Latest Products', 'texezo');	
				$texezoWooOneLatestText = __('Some of our latest products', 'texezo');
			
					
				if( '' != get_theme_mod('texezo_wooone_latest_heading') ){
					$texezoWooOneLatestHeading = get_theme_mod('texezo_wooone_latest_heading');
				}
				
				if( '' != get_theme_mod('texezo_wooone_latest_text') ){
					$texezoWooOneLatestText = get_theme_mod('texezo_wooone_latest_text');
				}				
			
					
		?>
		<div class="new-arrivals-title">
		
			<h3><?php echo esc_html($texezoWooOneLatestHeading); ?></h3>
			<p><?php echo esc_html($texezoWooOneLatestText); ?></p>
		
		</div><!-- .new-arrivals-title -->
		<?php endif; ?>
		
		<?php
			
			$texezoWooOnePaged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
			
			$texezo_front_page_ecom = array(
				'post_type' => 'product',
				'paged' => $texezoWooOnePaged
			);
			$texezo_front_page_ecom_the_query = new WP_Query( $texezo_front_page_ecom );
			
			$texezo_front_page_temp_query = $wp_query;
			$wp_query   = NULL;
			$wp_query   = $texezo_front_page_ecom_the_query;
			
		?>		
		
		<div class="new-arrivals-content">
		<?php if ( have_posts() && post_type_exists('product') ) : ?>
		
		
			<div class="texezo-woocommerce-content">
			
				<ul class="products">
			
					<?php /* Start the Loop */ ?>
					<?php while ( $texezo_front_page_ecom_the_query->have_posts() ) : $texezo_front_page_ecom_the_query->the_post(); ?>			
					<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
				
				</ul><!-- .products -->
				
				<?php //the_posts_navigation(); ?>
				
				<?php texezo_pagination( $texezoWooOnePaged, $texezo_front_page_ecom_the_query->max_num_pages); // Pagination Function ?>
				
			</div><!-- .texezo-woocommerce-content -->
			
		<?php else : ?>
		
			<p><?php echo __('Please install wooCommerce and add products.', 'texezo') ?></p>

		<?php 
			
			endif; 
			wp_reset_postdata();
			$wp_query = NULL;
			$wp_query = $texezo_front_page_temp_query;
		?>			
		
		
		</div><!-- .new-arrivals-content -->		
	
	</div><!-- .new-arrivals-container -->	

</div>