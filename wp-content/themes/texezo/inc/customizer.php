<?php
/**
 * texezo Theme Customizer
 *
 * @package texezo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function texezo_customize_register( $wp_customize ) {

	global $texezoPostsPagesArray, $texezoYesNo, $texezoSliderType, $texezoServiceLayouts, $texezoAvailableCats, $texezoBusinessLayoutType;

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'texezo_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'texezo_customize_partial_blogdescription',
		) );
	}
	
	$wp_customize->add_panel( 'texezo_general', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'      => __('General Settings', 'texezo'),
		'active_callback' => '',
	) );

	$wp_customize->get_section( 'title_tagline' )->panel = 'texezo_general';
	$wp_customize->get_section( 'background_image' )->panel = 'texezo_general';
	$wp_customize->get_section( 'background_image' )->title = __('Site background', 'texezo');
	$wp_customize->get_section( 'header_image' )->panel = 'texezo_general';
	$wp_customize->get_section( 'header_image' )->title = __('Header Settings', 'texezo');
	$wp_customize->get_control( 'header_image' )->priority = 20;
	$wp_customize->get_control( 'header_image' )->active_callback = 'texezo_show_wp_header_control';	
	$wp_customize->get_section( 'static_front_page' )->panel = 'business_page';
	$wp_customize->get_section( 'static_front_page' )->title = __('Select frontpage type', 'texezo');
	$wp_customize->get_section( 'static_front_page' )->priority = 9;
	$wp_customize->remove_section('colors');
	$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			'background_color', 
			array(
				'label'      => __( 'Background Color', 'texezo' ),
				'section'    => 'background_image',
				'priority'   => 9
			) ) 
	);
	//$wp_customize->remove_section('static_front_page');	
	//$wp_customize->remove_section('header_image');	

	/* Upgrade */	
	$wp_customize->add_section( 'business_upgrade', array(
		'priority'       => 8,
		'capability'     => 'edit_theme_options',
		'title'      => __('Upgrade to PRO', 'texezo'),
		'active_callback' => '',
	) );		
	$wp_customize->add_setting( 'texezo_show_sliderr',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new texezo_Customize_Control_Upgrade(
		$wp_customize,
		'texezo_show_sliderr',
		array(
			'label'      => __( 'Show headerr?', 'texezo' ),
			'settings'   => 'texezo_show_sliderr',
			'priority'   => 10,
			'section'    => 'business_upgrade',
			'choices' => '',
			'input_attrs'  => 'yes',
			'active_callback' => ''			
		)
	) );
	
	/* Usage guide */	
	$wp_customize->add_section( 'business_usage', array(
		'priority'       => 9,
		'capability'     => 'edit_theme_options',
		'title'      => __('Theme Usage Guide', 'texezo'),
		'active_callback' => '',
	) );		
	$wp_customize->add_setting( 'texezo_show_sliderrr',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new texezo_Customize_Control_Guide(
		$wp_customize,
		'texezo_show_sliderrr',
		array(

			'label'      => __( 'Show headerr?', 'texezo' ),
			'settings'   => 'texezo_show_sliderrr',
			'priority'   => 10,
			'section'    => 'business_usage',
			'choices' => '',
			'input_attrs'  => 'yes',
			'active_callback' => ''				
		)
	) );
	
	/* Header Section */
	$wp_customize->add_setting( 'texezo_show_slider',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_show_slider',
		array(
			'label'      => __( 'Show header?', 'texezo' ),
			'settings'   => 'texezo_show_slider',
			'priority'   => 10,
			'section'    => 'header_image',
			'type'    => 'select',
			'choices' => $texezoYesNo,
		)
	) );	
	$wp_customize->add_setting( 'header_type',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_slider_type_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'header_type',
		array(
			'label'      => __( 'Header type :', 'texezo' ),
			'settings'   => 'header_type',
			'priority'   => 10,
			'section'    => 'header_image',
			'type'    => 'select',
			'choices' => $texezoSliderType,
		)
	) );	
	
	
	/* Business page panel */
	$wp_customize->add_panel( 'business_page', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'      => __('Home/Front Page Settings', 'texezo'),
		'active_callback' => '',
	) );
	
	$wp_customize->add_section( 'business_page_layout_wooone', array(
		'priority'       => 60,
		'capability'     => 'edit_theme_options',
		'title'      => __('Woo One settings', 'texezo'),
		'active_callback' => 'texezo_front_page_sections',
		'panel'  => 'business_page',
	) );

	$wp_customize->add_setting( 'texezo_wooone_welcome_post',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_post_selection',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_wooone_welcome_post',
		array(
			'label'      => __( 'Welcome post :', 'texezo' ),
			'settings'   => 'texezo_wooone_welcome_post',
			'priority'   => 10,
			'section'    => 'business_page_layout_wooone',
			'type'    => 'select',
			'choices' => $texezoPostsPagesArray,
		)
	) );
	$wp_customize->add_setting( 'texezo_wooone_latest_heading',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_wooone_latest_heading',
		array(
			'label'      => __( 'Products Heading :', 'texezo' ),
			'settings'   => 'texezo_wooone_latest_heading',
			'priority'   => 20,
			'section'    => 'business_page_layout_wooone',
			'type'    => 'text',
		)
	) );
	$wp_customize->add_setting( 'texezo_wooone_latest_text',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_wooone_latest_text',
		array(
			'label'      => __( 'Products Text :', 'texezo' ),
			'settings'   => 'texezo_wooone_latest_text',
			'priority'   => 30,
			'section'    => 'business_page_layout_wooone',
			'type'    => 'text',
		)
	) );	

	$wp_customize->add_section( 'business_page_quote', array(
		'priority'       => 110,
		'capability'     => 'edit_theme_options',
		'title'      => __('Quote Settings', 'texezo'),
		'active_callback' => '',
		'panel'  => 'texezo_general',
	) );
	$wp_customize->add_setting( 'texezo_show_quote',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_show_quote',
		array(
			'label'      => __( 'Show quote?', 'texezo' ),
			'settings'   => 'texezo_show_quote',
			'priority'   => 10,
			'section'    => 'business_page_quote',
			'type'    => 'select',
			'choices' => $texezoYesNo,
		)
	) );
	$wp_customize->add_setting( 'texezo_quote_post',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_post_selection',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_quote_post',
		array(
			'label'      => __( 'Select post', 'texezo' ),
			'description' => __( 'Select a post/page you want to show in quote section', 'texezo' ),
			'settings'   => 'texezo_quote_post',
			'priority'   => 11,
			'section'    => 'business_page_quote',
			'type'    => 'select',
			'choices' => $texezoPostsPagesArray,
		)
	) );	
	
	$wp_customize->add_section( 'business_page_social', array(
		'priority'       => 120,
		'capability'     => 'edit_theme_options',
		'title'      => __('Social Settings', 'texezo'),
		'active_callback' => '',
		'panel'  => 'texezo_general',
	) );	
	$wp_customize->add_setting( 'texezo_show_social',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'texezo_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'texezo_show_social',
		array(
			'label'      => __( 'Show social?', 'texezo' ),
			'settings'   => 'texezo_show_social',
			'priority'   => 10,
			'section'    => 'business_page_social',
			'type'    => 'select',
			'choices' => $texezoYesNo,
		)
	) );
	$wp_customize->add_setting( 'business_page_facebook',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_facebook', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Facebook', 'texezo' ),
	  'description' => __( 'Enter your facebook url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_flickr',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_flickr', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Flickr', 'texezo' ),
	  'description' => __( 'Enter your flickr url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_gplus',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_gplus', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Gplus', 'texezo' ),
	  'description' => __( 'Enter your gplus url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_linkedin',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_linkedin', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Linkedin', 'texezo' ),
	  'description' => __( 'Enter your linkedin url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_reddit',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_reddit', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Reddit', 'texezo' ),
	  'description' => __( 'Enter your reddit url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_stumble',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_stumble', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Stumble', 'texezo' ),
	  'description' => __( 'Enter your stumble url.', 'texezo' ),
	) );
	$wp_customize->add_setting( 'business_page_twitter',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'business_page_twitter', array(
	  'type' => 'text',
	  'section' => 'business_page_social', // Add a default or your own section
	  'label' => __( 'Twitter', 'texezo' ),
	  'description' => __( 'Enter your twitter url.', 'texezo' ),
	) );	
	
}
add_action( 'customize_register', 'texezo_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function texezo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function texezo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function texezo_customize_preview_js() {
	wp_enqueue_script( 'texezo-customizer', esc_url( get_template_directory_uri() ) . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'texezo_customize_preview_js' );

require get_template_directory() . '/inc/variables.php';

function texezo_sanitize_yes_no_setting( $value ){
	global $texezoYesNo;
    if ( ! array_key_exists( $value, $texezoYesNo ) ){
        $value = 'select';
	}
    return $value;	
}

function texezo_sanitize_post_selection( $value ){
	global $texezoPostsPagesArray;
    if ( ! array_key_exists( $value, $texezoPostsPagesArray ) ){
        $value = 'select';
	}
    return $value;	
}

function texezo_front_page_sections(){
	
	$value = false;
	
	if( 'page' == get_option( 'show_on_front' ) ){
		$value = true;
	}
	
	return $value;
	
}

function texezo_show_wp_header_control(){
	
	$value = false;
	
	if( 'header' == get_theme_mod( 'header_type' ) ){
		$value = true;
	}
	
	return $value;
	
}

function texezo_show_header_one_control(){
	
	$value = false;
	
	if( 'header-one' == get_theme_mod( 'header_type' ) ){
		$value = true;
	}
	
	return $value;
	
}

function texezo_sanitize_slider_type_setting( $value ){

	global $texezoSliderType;
    if ( ! array_key_exists( $value, $texezoSliderType ) ){
        $value = 'select';
	}
    return $value;	
	
}

function texezo_sanitize_cat_setting( $value ){
	
	global $texezoAvailableCats;
	
	if( ! array_key_exists( $value, $texezoAvailableCats ) ){
		
		$value = 'select';
		
	}
	return $value;
	
}

function texezo_sanitize_layout_type( $value ){
	
	global $texezoBusinessLayoutType;
	
	if( ! array_key_exists( $value, $texezoBusinessLayoutType ) ){
		
		$value = 'select';
		
	}
	return $value;
	
}

add_action( 'customize_register', 'texezo_load_customize_classes', 0 );
function texezo_load_customize_classes( $wp_customize ) {
	
	class texezo_Customize_Control_Upgrade extends WP_Customize_Control {

		public $type = 'texezo-upgrade';
		
		public function enqueue() {

		}

		public function to_json() {
			
			parent::to_json();

			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
			//$this->json['default'] = $this->default;
			
		}	
		
		public function render_content() {}
		
		public function content_template() { ?>

			<div id="texezo-upgrade-container" class="texezo-upgrade-container">

				<ul>
					<li>More sliders</li>
					<li>More layouts</li>
					<li>Color customization</li>
					<li>Font customization</li>
				</ul>

				<p>
					<a href="https://www.themealley.com/business/">Upgrade</a>
				</p>
									
			</div><!-- .texezo-upgrade-container -->
			
		<?php }	
		
	}
	
	class texezo_Customize_Control_Guide extends WP_Customize_Control {

		public $type = 'texezo-guide';
		
		public function enqueue() {

		}

		public function to_json() {
			
			parent::to_json();

			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
			//$this->json['default'] = $this->default;
			
		}	
		
		public function render_content() {}
		
		public function content_template() { ?>

			<div id="texezo-upgrade-container" class="texezo-upgrade-container">

				<ol>
					<li>Select 'A static page' for "your homepage displays" in 'select frontpage type' section of 'Home/Front Page settings' tab.</li>
					<li>Enter details for various section like header, welcome, services, quote, social sections.</li>
				</ol>
									
			</div><!-- .texezo-upgrade-container -->
			
		<?php }	
		
	}	

	$wp_customize->register_control_type( 'texezo_Customize_Control_Upgrade' );
	$wp_customize->register_control_type( 'texezo_Customize_Control_Guide' );
	
	
}