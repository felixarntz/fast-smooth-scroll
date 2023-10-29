<?php
/**
 * Plugin main file.
 *
 * @package FastSmoothScroll
 * @author Felix Arntz <hello@felix-arntz.me>
 *
 * @wordpress-plugin
 * Plugin Name: Fast Smooth Scroll
 * Plugin URI: https://wordpress.org/plugins/fast-smooth-scroll/
 * Description: This lightweight plugin enhances user experience by enabling smooth scrolling for anchor links without the need for jQuery or other dependencies.
 * Version: 1.0.0
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
 * @since n.e.x.t
 */
function fast_smooth_scroll_print_style() {
	?>
	<style id="fast-smooth-scroll-css" type="text/css">html { scroll-behavior: smooth; }</style>
	<?php
}
add_action( 'wp_footer', 'fast_smooth_scroll_print_style' );

/**
 * Registers the JavaScript polyfills for when the browser doesn't support the CSS 'scroll-behavior' property.
 *
 * @since n.e.x.t
 */
function fast_smooth_scroll_register_scripts() {
	global $wp_scripts;

	$script_metadata = require plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	$polyfill_src    = SCRIPT_DEBUG ? 'src/index.js' : 'build/index.js';

	wp_register_script(
		'fast-smooth-scroll-scroll-behavior-polyfill',
		plugin_dir_url( __FILE__ ) . $polyfill_src,
		$script_metadata['dependencies'],
		$script_metadata['version'],
		array( 'in_footer' => true )
	);
	wp_register_script(
		'fast-smooth-scroll-polyfills',
		false,
		array(),
		null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		array( 'in_footer' => true )
	);
	wp_add_inline_script(
		'fast-smooth-scroll-polyfills',
		wp_get_script_polyfill(
			$wp_scripts,
			array(
				'document.documentElement && document.documentElement.style.scrollBehavior !== undefined && ( document.documentElement.style.scrollBehavior = "smooth" || true ) && document.documentElement.style.scrollBehavior === "smooth"' => 'fast-smooth-scroll-scroll-behavior-polyfill',
			)
		)
	);
}
add_action( 'init', 'fast_smooth_scroll_register_scripts' );

/**
 * Enqueues the JavaScript that is conditionally used only if the browser doesn't support the CSS 'scroll-behavior' property.
 *
 * @since n.e.x.t
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
	 * @since n.e.x.t
	 *
	 * @param bool $enqueue_scripts Whether to enqueue the JavaScript polyfills. Default true.
	 */
	if ( ! apply_filters( 'fast_smooth_scroll_enqueue_scripts', true ) ) {
		return;
	}

	wp_enqueue_script( 'fast-smooth-scroll-polyfills' );
}
add_action( 'wp_enqueue_scripts', 'fast_smooth_scroll_enqueue_scripts' );
