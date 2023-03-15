<?php
namespace ElementorBlogLayouts;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		
		// Load WP jQuery if not included
		wp_enqueue_script('jquery');
		
		// Main
		wp_register_style( 'bloglayouts-vc-main-style', plugins_url( '/assets/css/style.css', __FILE__ ) );
		wp_register_style( 'fonts-vc',  plugins_url( 'assets/css/fonts.css', __FILE__ ));  
		wp_enqueue_style( 'bloglayouts-vc-main-style' );
		wp_register_script( 'blog-carousel',  plugins_url( 'assets/js/blog-carousel.js' , __FILE__ ), [ 'jquery' ], false, true );	
		
		// Carousel
		wp_register_style( 'owlcarousel',  plugins_url( 'assets/css/owl.carousel.css', __FILE__ ) );
		wp_register_style( 'owltheme',  plugins_url( 'assets/css/owl.theme.css', __FILE__ ) );
		wp_register_script( 'owlcarousel',  plugins_url( 'assets/js/vendor/owl.carousel.js' , __FILE__ ), [ 'jquery' ], false, true );
		
		// ANIMATE
		wp_register_style( 'animations',  plugins_url( 'assets/css/animations.min.css', __FILE__ ) );
		wp_register_script( 'appear',  plugins_url( 'assets/js/vendor/appear.min.js' , __FILE__ ), [ 'jquery' ], false, true );	
		wp_register_script( 'animate',  plugins_url( 'assets/js/vendor/animations.min.js' , __FILE__ ), [ 'jquery' ], false, true );		
			
		if(\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			wp_enqueue_style( 'fonts-vc' );
			wp_enqueue_style( 'owlcarousel' );
			wp_enqueue_style( 'owltheme' );				
			wp_enqueue_script( 'owlcarousel' );
			wp_enqueue_style( 'animations' );
			wp_enqueue_script( 'appear' );			
			wp_enqueue_script( 'animate' );	
			wp_enqueue_script( 'blog-carousel' );	
		}			
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/BlogCarousel/blog-carousel.php' );
		require_once( __DIR__ . '/widgets/Blog/blog.php' );
		require_once( __DIR__ . '/widgets/widgets-help-functions.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog_Layouts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog_Carousel_Layouts() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin::instance();
