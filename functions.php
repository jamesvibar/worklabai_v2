<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}


/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		parent::__construct();
	}

	public function register_shortcodes() {
		require "inc/shortcodes.php";
	}

	public function register_post_types() {

	}

	public function register_taxonomies() {

	}

	public function register_menus() {
		register_nav_menus( array(
			'main_menu' => __( 'Primary Menu', 'worklabai' ),
			'footer_menu' => __( 'Footer Menu', 'worklabai' ),
		) );
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
	
		// $context['ENV'] = getenv(WP_ENV);
		$context['main_menu'] = new Timber\Menu('main_menu');
		$context['footer_menu'] = new Timber\Menu('footer_menu');
		$context['options'] = get_fields('option');
		$context['site'] = $this;
		// Footer Education Drip
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3
		);
		$context['education_posts'] = new Timber\PostQuery($args);
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		// add_theme_support(
		// 	'post-formats', array(
		// 		'aside',
		// 		'image',
		// 		'video',
		// 		'quote',
		// 		'link',
		// 		'gallery',
		// 		'audio',
		// 	)
		// );

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( new Twig_SimpleFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}
new StarterSite();

/**
 * Theme specific functions for WorkLabAI starts from here...
 */

// Register theme scripts and files
add_action( 'wp_enqueue_scripts', 'wpworklabai_register_scripts' );
function wpworklabai_register_scripts() {
	wp_enqueue_style('main-css', get_template_directory_uri() . '/dist/all.css', [], time());
	wp_enqueue_script('main-js', get_template_directory_uri() . '/dist/all.js', [], time(), true);
}

// Advanced Custom Fields Theme Options
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Theme Settings');
}

/**
 * Pre get posts for custom WP Queries
 */

 // Education Center
 add_action('pre_get_posts', 'worklabai_category_education_personal_business');
 function worklabai_category_education_personal_business( $query ) {
		if
		( $query->is_main_query() && 
			!is_admin() && 
			( is_category('education-center') || 
				is_category('personal') || 
				is_category('business') 
			) ) 
		{
			$query->set("posts_per_page", 3);
		}
 }