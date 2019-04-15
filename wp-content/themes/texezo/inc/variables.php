<?php

$texezoPostsPagesArray = array(
	'select' => __('Select a post/page', 'texezo'),
);

$texezoPostsPagesArgs = array(
	
	// Change these category SLUGS to suit your use.
	'ignore_sticky_posts' => 1,
	'post_type' => array('post', 'page'),
	'orderby' => 'date',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	
);
$texezoPostsPagesQuery = new WP_Query( $texezoPostsPagesArgs );
	
if ( $texezoPostsPagesQuery->have_posts() ) :
							
	while ( $texezoPostsPagesQuery->have_posts() ) : $texezoPostsPagesQuery->the_post();
			
		$texezoPostsPagesId = get_the_ID();
		if(get_the_title() != ''){
				$texezoPostsPagesTitle = get_the_title();
		}else{
				$texezoPostsPagesTitle = get_the_ID();
		}
		$texezoPostsPagesArray[$texezoPostsPagesId] = $texezoPostsPagesTitle;
	   
	endwhile; wp_reset_postdata();
							
endif;

$texezoYesNo = array(
	'select' => __('Select', 'texezo'),
	'yes' => __('Yes', 'texezo'),
	'no' => __('No', 'texezo'),
);

$texezoSliderType = array(
	'select' => __('Select', 'texezo'),
	'header' => __('WP Custom Header', 'texezo'),
	'owl' => __('Owl Slider', 'texezo'),
);

$texezoServiceLayouts = array(
	'select' => __('Select', 'texezo'),
	'one' => __('One', 'texezo'),
	'two' => __('Two', 'texezo'),
);

$texezoAvailableCats = array( 'select' => __('Select', 'texezo') );

$texezo_categories_raw = get_categories( array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0, ) );

foreach( $texezo_categories_raw as $category ){
	
	$texezoAvailableCats[$category->term_id] = $category->name;
	
}

$texezoBusinessLayoutType = array( 
	'select' => __('Select', 'texezo'), 
	'two' => __('Two', 'texezo'),
	'woo-one' => __('Woocommerce One', 'texezo'),
);
