<?php
/**
 * Tests for the plugin main file.
 *
 * @package FastSmoothScroll\Tests
 * @author Felix Arntz <hello@felix-arntz.me>
 */

class Fast_Smooth_Scroll_Tests extends WP_UnitTestCase {

	public function test_hooks() {
		$this->assertSame( 10, has_action( 'wp_footer', 'fast_smooth_scroll_print_style' ) );
		$this->assertSame( 10, has_action( 'init', 'fast_smooth_scroll_register_scripts' ) );
		$this->assertSame( 10, has_action( 'wp_enqueue_scripts', 'fast_smooth_scroll_enqueue_scripts' ) );
	}

	public function test_fast_smooth_scroll_print_style() {
		$output = get_echo( 'fast_smooth_scroll_print_style' );

		if ( ! method_exists( $this, 'assertMatchesRegularExpression' ) ) {
			$this->assertRegExp( '/>\s*html\s*\{\s*scroll-behavior:\s*smooth;\s*\}\s*</', $output );
			return;
		}
		$this->assertMatchesRegularExpression( '/>\s*html\s*\{\s*scroll-behavior:\s*smooth;\s*\}\s*</', $output );
	}

	public function test_fast_smooth_scroll_register_scripts() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		fast_smooth_scroll_register_scripts();

		$polyfill_registered = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'registered' );
		$polyfill_enqueued   = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'enqueued' );
		$loader_registered   = wp_script_is( 'fast-smooth-scroll-polyfills', 'registered' );
		$loader_enqueued     = wp_script_is( 'fast-smooth-scroll-polyfills', 'enqueued' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		// Ensure that scripts have been registered but not enqueued.
		$this->assertTrue( $polyfill_registered );
		$this->assertFalse( $polyfill_enqueued );
		$this->assertTrue( $loader_registered );
		$this->assertFalse( $loader_enqueued );
	}

	public function test_fast_smooth_scroll_enqueue_scripts() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		fast_smooth_scroll_register_scripts();
		fast_smooth_scroll_enqueue_scripts();

		$polyfill_enqueued = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'enqueued' );
		$loader_enqueued   = wp_script_is( 'fast-smooth-scroll-polyfills', 'enqueued' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		// Ensure that only the loader is enqueued, as the polyfill will be conditionally added via the loader.
		$this->assertFalse( $polyfill_enqueued );
		$this->assertTrue( $loader_enqueued );
	}

	public function test_fast_smooth_scroll_enqueue_scripts_filter() {
		global $wp_scripts;

		// Add filter to prevent enqueuing the scripts.
		add_filter( 'fast_smooth_scroll_enqueue_scripts', '__return_false' );

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		fast_smooth_scroll_register_scripts();
		fast_smooth_scroll_enqueue_scripts();

		$polyfill_registered = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'registered' );
		$polyfill_enqueued   = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'enqueued' );
		$loader_registered   = wp_script_is( 'fast-smooth-scroll-polyfills', 'registered' );
		$loader_enqueued     = wp_script_is( 'fast-smooth-scroll-polyfills', 'enqueued' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		// Ensure that scripts have been registered but not enqueued.
		$this->assertTrue( $polyfill_registered );
		$this->assertFalse( $polyfill_enqueued );
		$this->assertTrue( $loader_registered );
		$this->assertFalse( $loader_enqueued );
	}
}
