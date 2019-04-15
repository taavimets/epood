<?php
/**
 * Function describe for fLibrary 
 * 
 * @package flibrary
 */

if ( ! function_exists( 'flibrary_load_css_and_scripts' ) ) :

	function flibrary_load_css_and_scripts() {

		wp_enqueue_style( 'fstore-stylesheet', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'flibrary-child-style', get_stylesheet_uri(), array( 'flibrary-stylesheet' ) );
	}

endif; // flibrary_load_css_and_scripts

add_action( 'wp_enqueue_scripts', 'flibrary_load_css_and_scripts' );

if ( ! class_exists( 'flibrary_Customize' ) ) :
	/**
	 * Singleton class for handling the theme's customizer integration.
	 */
	final class flibrary_Customize {

		// Returns the instance.
		public static function get_instance() {

			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}

			return $instance;
		}

		// Constructor method.
		private function __construct() {}

		// Sets up initial actions.
		private function setup_actions() {

			// Register panels, sections, settings, controls, and partials.
			add_action( 'customize_register', array( $this, 'sections' ) );

			// Register scripts and styles for the controls.
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
		}

		// Sets up the customizer sections.
		public function sections( $manager ) {

			// Load custom sections.

			// Register custom section types.
			$manager->register_section_type( 'fstore_Customize_Section_Pro' );

			// Register sections.
			$manager->add_section(
				new fstore_Customize_Section_Pro(
					$manager,
					'flibrary',
					array(
						'title'    => esc_html__( 'tLibrary', 'flibrary' ),
						'pro_text' => esc_html__( 'Upgrade', 'flibrary' ),
						'pro_url'  => esc_url( 'https://tishonator.com/product/tlibrary' )
					)
				)
			);
		}

		// Loads theme customizer CSS.
		public function enqueue_control_scripts() {

			wp_enqueue_script( 'fstore-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'customize-controls' ) );

			wp_enqueue_style( 'fstore-customize-controls', trailingslashit( get_template_directory_uri() ) . 'css/customize-controls.css' );
		}
	}
endif; // flibrary_Customize

// Doing this customizer thang!
flibrary_Customize::get_instance();

/**
 * Remove Parent theme Customize Up-Selling Section
 */
if ( ! function_exists( 'flibrary_remove_parent_theme_upsell_section' ) ) :

	function flibrary_remove_parent_theme_upsell_section( $wp_customize ) {

		// Remove Parent-Theme Upsell section
		$wp_customize->remove_section('fstore');
	}

endif; // flibrary_remove_parent_theme_upsell_section
add_action( 'customize_register', 'flibrary_remove_parent_theme_upsell_section', 100 );

/**
 * Remove Parent theme Customize Up-Selling Section
 */
if ( ! function_exists( 'flibrary_display_landing_section' ) ) :

	function flibrary_display_landing_section() {

		$title = get_theme_mod( 'flibrary_landing_title' );
		$content = get_theme_mod( 'flibrary_landing_content' );
		$background = get_theme_mod( 'flibrary_landing_background' );
?>
		<div id="header-landing-section"
			<?php if ( $background ) : ?>
					style="background-image: url('<?php echo esc_attr( $background ); ?>');"
			<?php endif; ?>>
			<div id="header-landing-section-content">
				<?php if ($title) : ?>
						<h2>
							<?php echo esc_html($title); ?>
						</h2>
				<?php endif; ?>

				<?php if ($content) : ?>
						<div class="landing-content">
							<?php echo esc_html($content); ?>
						</div>
				<?php endif; ?>
			</div>
		</div>

<?php
	}

endif; // flibrary_display_landing_section

if ( ! function_exists( 'flibrary_sanitize_checkbox' ) ) :

	function flibrary_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}

endif; // flibrary_sanitize_checkbox

if ( ! function_exists( 'flibrary_customize_register' ) ) :

	/**
	 * Register theme settings in the customizer
	 */
	function flibrary_customize_register( $wp_customize ) {

		/**
		 * Add Landing Section
		 */
		$wp_customize->add_section(
			'flibrary_landing_section',
			array(
				'title'       => __( 'Landing Section', 'flibrary' ),
				'capability'  => 'edit_theme_options',
			)
		);

		// Add display slider option
		$wp_customize->add_setting(
				'flibrary_landing_display',
				array(
						'default'           => 0,
						'sanitize_callback' => 'flibrary_sanitize_checkbox',
				)
		);

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'flibrary_landing_display',
								array(
									'label'          => __( 'Display Landing Section', 'flibrary' ),
									'section'        => 'flibrary_landing_section',
									'settings'       => 'flibrary_landing_display',
									'type'           => 'checkbox',
								)
							)
		);

		// Add Landing Section Title
		$wp_customize->add_setting(
			'flibrary_landing_title',
			array(
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'flibrary_landing_title',
	        array(
	            'label'          => __( 'Title', 'flibrary' ),
	            'section'        => 'flibrary_landing_section',
	            'settings'       => 'flibrary_landing_title',
	            'type'           => 'text',
	            )
	        )
		);

		// Add Landing Section Content
		$wp_customize->add_setting(
			'flibrary_landing_content',
			array(
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'flibrary_landing_content',
	        array(
	            'label'          => __( 'Content', 'flibrary' ),
	            'section'        => 'flibrary_landing_section',
	            'settings'       => 'flibrary_landing_content',
	            'type'           => 'textarea',
	            )
	        )
		);

		// Add Landing Section Background Image
		$wp_customize->add_setting( 'flibrary_landing_background',
			array(
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'flibrary_landing_background',
				array(
					'label'   	 => __( 'Background Image', 'flibrary' ),
					'section' 	 => 'flibrary_landing_section',
					'settings'   => 'flibrary_landing_background',
				)
			)
		);
	}

endif; // flibrary_customize_register

add_action('customize_register', 'flibrary_customize_register');
