<?php
/**
 * Simple Photo Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Simple Photo Blog
 */

if ( ! function_exists( 'ajs_spb_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ajs_spb_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Simple Photo Blog, use a find and replace
	 * to change 'ajs_spb' to the name of your theme in all the template files.
	 * You will also need to update the Gulpfile with the new text domain
	 * and matching destination POT file.
	 */
	load_theme_textdomain( 'ajs_spb', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'ajs_spb' ),
	) );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ajs_spb_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image'));

	// Add styles to the post editor
	add_editor_style( array( 'editor-style.css', ajs_spb_font_url() ) );

}
endif; // ajs_spb_setup
add_action( 'after_setup_theme', 'ajs_spb_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ajs_spb_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ajs_spb_content_width', 640 );
}
add_action( 'after_setup_theme', 'ajs_spb_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ajs_spb_widgets_init() {

	// Define sidebars
	$sidebars = array(
		'sidebar-1'  => esc_html__( 'Sidebar 1', 'ajs_spb' ),
	//	'sidebar-2'  => esc_html__( 'Sidebar 2', 'ajs_spb' ),
	//	'sidebar-3'  => esc_html__( 'Sidebar 3', 'ajs_spb' ),
	);

	// Loop through each sidebar and register
	foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'description'   => sprintf ( esc_html__( 'Widget area for %s', 'ajs_spb' ), $sidebar_name ),
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

}
add_action( 'widgets_init', 'ajs_spb_widgets_init' );

/*
* Convert decimal shutter speeds to fractions
*
* @since 1.0
 */
function ajs_spb_convert_decimal_to_fraction($imagemeta) {
	if ((1 / $imagemeta['image_meta']['shutter_speed']) > 1) {
	echo "1/";
		if (number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1) ==  number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0)) {
			echo number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0, '.', '') . ' sec';
		} else {
			echo number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1, '.', '') . ' sec';
		}
	} else {
		echo $imagemeta['image_meta']['shutter_speed'].' sec';
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load styles and scripts.
 */
require get_template_directory() . '/inc/scripts.php';
