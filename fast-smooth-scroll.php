<?php
/**
 * Plugin main file.
 *
 * @package FastSmoothScroll
 * @author Felix Arntz <hello@felix-arntz.me>
 *
 * @wordpress-plugin
 * Plugin Name: Fast Smooth Scroll
 * Plugin URI: https://github.com/felixarntz/fast-smooth-scroll
 * Description: This lightweight plugin enhances user experience by enabling smooth scrolling for anchor links without the need for jQuery or other dependencies.
 * Version: 1.0.0-beta.1
 * Requires at least: 5.0
 * Requires PHP: 5.2
 * Author: Felix Arntz
 * Author URI: https://felix-arntz.me
 * License: GNU General Public License v2 (or later)
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fast-smooth-scroll
 * Tags: smooth scroll, smooth scrolling, scroll animation, scroll behavior, performance, anchor links, user experience, lightweight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Prints the inline style tag to set the CSS 'scroll-behavior' property.
 *
 * @since 1.0.0
 */
function fast_smooth_scroll_print_style() {
	$html_rules = array( 'scroll-behavior: smooth' );

	$scroll_offset = fast_smooth_scroll_get_offset();
	if ( $scroll_offset ) {
		$html_rules[] = 'scroll-padding-top: ' . (int) $scroll_offset . 'px';
	}

	?>
	<style id="fast-smooth-scroll-css" type="text/css">html { <?php echo esc_js( implode( '; ', $html_rules ) . ';' ); ?> }</style>
	<?php
}
add_action( 'wp_footer', 'fast_smooth_scroll_print_style' );

/**
 * Registers the JavaScript polyfills for when the browser doesn't support the CSS 'scroll-behavior' property.
 *
 * @since 1.0.0
 */
function fast_smooth_scroll_register_scripts() {
	global $wp_scripts;

	$script_metadata = require plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	$polyfill_src    = SCRIPT_DEBUG ? 'src/index.js' : 'build/index.js';

	$scroll_offset = fast_smooth_scroll_get_offset();
	if ( $scroll_offset ) {
		$data_script = 'var fastSmoothScrollOffset = ' . (int) $scroll_offset . ';';
	}

	wp_register_script(
		'fast-smooth-scroll-scroll-behavior-polyfill',
		plugin_dir_url( __FILE__ ) . $polyfill_src,
		$script_metadata['dependencies'],
		$script_metadata['version'],
		array( 'in_footer' => true )
	);
	if ( isset( $data_script ) ) {
		wp_add_inline_script( 'fast-smooth-scroll-scroll-behavior-polyfill', $data_script, 'before' );
	}

	wp_register_script(
		'fast-smooth-scroll-polyfills',
		false,
		array(),
		null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		array( 'in_footer' => true )
	);
	if ( isset( $data_script ) ) {
		wp_add_inline_script( 'fast-smooth-scroll-polyfills', $data_script, 'before' );
	}
	wp_add_inline_script(
		'fast-smooth-scroll-polyfills',
		wp_get_script_polyfill(
			$wp_scripts,
			array(
				'document.documentElement && document.documentElement.style.scrollBehavior !== undefined && ( document.documentElement.style.scrollBehavior = "smooth" || true ) && document.documentElement.style.scrollBehavior === "smooth" && ( document.documentElement.style.removeProperty( "scroll-behavior" ) || true )' => 'fast-smooth-scroll-scroll-behavior-polyfill',
			)
		)
	);
}
add_action( 'init', 'fast_smooth_scroll_register_scripts' );

/**
 * Enqueues the JavaScript that is conditionally used only if the browser doesn't support the CSS 'scroll-behavior' property.
 *
 * @since 1.0.0
 */
function fast_smooth_scroll_enqueue_scripts() {
	/**
	 * Filters whether the JavaScript polyfills for missing CSS 'scroll-behavior' property support should be enqueued.
	 *
	 * By default, this is the case, which ensures older browsers without support for the CSS property will load a
	 * JavaScript based replacement.
	 *
	 * While this replacement is still a very lightweight and performant implementation that follows modern JavaScript
	 * development best practices, there may still be situations where you want to disable it completely, depending on
	 * the browser support of the website's end users.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $enqueue_scripts Whether to enqueue the JavaScript polyfills. Default true.
	 */
	if ( ! apply_filters( 'fast_smooth_scroll_enqueue_scripts', true ) ) {
		return;
	}

	/*
	 * Administrators can force the polyfill to load by adding a query parameter `fast_smooth_scroll_debug_polyfill=1`
	 * to any URL. In this case, the polyfill is unconditionally enqueued.
	 * It also overrides the default scroll behavior to 'auto' to simulate the experience without 'smooth' scrolling
	 * configured via CSS.
	 */
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( current_user_can( 'manage_options' ) && ! empty( $_GET['fast_smooth_scroll_debug_polyfill'] ) ) {
		wp_add_inline_script(
			'fast-smooth-scroll-scroll-behavior-polyfill',
			'document.documentElement.style.scrollBehavior = "auto";',
			'before'
		);
		wp_enqueue_script( 'fast-smooth-scroll-scroll-behavior-polyfill' );
		return;
	}

	wp_enqueue_script( 'fast-smooth-scroll-polyfills' );
}
add_action( 'wp_enqueue_scripts', 'fast_smooth_scroll_enqueue_scripts' );

/**
 * Returns the scroll offset to use.
 *
 * @since 1.0.0
 *
 * @return int Scroll offset in pixels.
 */
function fast_smooth_scroll_get_offset() {
	/**
	 * Filters the scroll offset to use.
	 *
	 * @since 1.0.0
	 *
	 * @param int $offset Scroll offset in pixels. Will only be applied if greater than 0. Default 0.
	 */
	return (int) apply_filters( 'fast_smooth_scroll_offset', 0 );
}
