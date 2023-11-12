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

		$pattern = '/>\s*html\s*\{\s*scroll-behavior:\s*smooth;\s*\}\s*/';
		if ( ! method_exists( $this, 'assertMatchesRegularExpression' ) ) {
			$this->assertRegExp( $pattern, $output );
			return;
		}
		$this->assertMatchesRegularExpression( $pattern, $output );

		if ( ! method_exists( $this, 'assertStringContainsString' ) ) {
			$this->assertTrue( false !== strpos( $output, '@media (prefers-reduced-motion: reduce) {' ) );
			return;
		}
		$this->assertStringContainsString( '@media (prefers-reduced-motion: reduce) {', $output );
	}

	public function test_fast_smooth_scroll_print_style_prints_offset_with_filter() {
		add_filter( 'fast_smooth_scroll_offset', array( $this, 'return_120' ) );
		$output = get_echo( 'fast_smooth_scroll_print_style' );

		$pattern = '/>\s*html\s*\{\s*scroll-behavior:\s*smooth;\s*scroll-padding-top:\s*120px;\s*\}\s*/';
		if ( ! method_exists( $this, 'assertMatchesRegularExpression' ) ) {
			$this->assertRegExp( $pattern, $output );
			return;
		}
		$this->assertMatchesRegularExpression( $pattern, $output );
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

	public function test_fast_smooth_scroll_register_scripts_does_not_print_offset_script_by_default() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		fast_smooth_scroll_register_scripts();

		$polyfill_inline_script  = $this->get_inline_script_data( 'fast-smooth-scroll-scroll-behavior-polyfill', 'before' );
		$polyfills_inline_script = $this->get_inline_script_data( 'fast-smooth-scroll-polyfills', 'before' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		if ( ! method_exists( $this, 'assertStringNotContainsString' ) ) {
			$this->assertFalse( strpos( $polyfill_inline_script, 'var fastSmoothScrollOffset = ' ) );
			$this->assertFalse( strpos( $polyfills_inline_script, 'var fastSmoothScrollOffset = ' ) );
			return;
		}
		$this->assertStringNotContainsString( 'var fastSmoothScrollOffset = ', $polyfill_inline_script );
		$this->assertStringNotContainsString( 'var fastSmoothScrollOffset = ', $polyfills_inline_script );
	}

	public function test_fast_smooth_scroll_register_scripts_prints_offset_script_with_filter() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		add_filter( 'fast_smooth_scroll_offset', array( $this, 'return_120' ) );
		fast_smooth_scroll_register_scripts();

		$polyfill_inline_script  = $this->get_inline_script_data( 'fast-smooth-scroll-scroll-behavior-polyfill', 'before' );
		$polyfills_inline_script = $this->get_inline_script_data( 'fast-smooth-scroll-polyfills', 'before' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		if ( ! method_exists( $this, 'assertStringContainsString' ) ) {
			$this->assertTrue( false !== strpos( $polyfill_inline_script, 'var fastSmoothScrollOffset = 120;' ) );
			$this->assertTrue( false !== strpos( $polyfills_inline_script, 'var fastSmoothScrollOffset = 120;' ) );
			return;
		}
		$this->assertStringContainsString( 'var fastSmoothScrollOffset = 120;', $polyfill_inline_script );
		$this->assertStringContainsString( 'var fastSmoothScrollOffset = 120;', $polyfills_inline_script );
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

	public function test_fast_smooth_scroll_enqueue_scripts_with_debug_polyfill_param() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		// Set the query parameter. It shouldn't change any behavior by itself.
		$_GET['fast_smooth_scroll_debug_polyfill'] = '1';

		fast_smooth_scroll_register_scripts();
		fast_smooth_scroll_enqueue_scripts();

		$polyfill_enqueued      = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'enqueued' );
		$loader_enqueued        = wp_script_is( 'fast-smooth-scroll-polyfills', 'enqueued' );
		$polyfill_inline_script = $this->get_inline_script_data( 'fast-smooth-scroll-scroll-behavior-polyfill', 'before' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		// Ensure that still only the loader is enqueued, as the query parameter can only be used by administrators.
		$this->assertFalse( $polyfill_enqueued );
		$this->assertTrue( $loader_enqueued );
		$this->assertSame( '', $polyfill_inline_script );
	}

	public function test_fast_smooth_scroll_enqueue_scripts_with_debug_polyfill_param_and_administrator() {
		global $wp_scripts;

		// Store original `$wp_scripts`, then reset it.
		$orig_wp_scripts = wp_scripts();
		$wp_scripts      = null;

		// Set the current user to an administrator, and set the query parameter. This should force load the polyfill.
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$_GET['fast_smooth_scroll_debug_polyfill'] = '1';

		fast_smooth_scroll_register_scripts();
		fast_smooth_scroll_enqueue_scripts();

		$polyfill_enqueued      = wp_script_is( 'fast-smooth-scroll-scroll-behavior-polyfill', 'enqueued' );
		$loader_enqueued        = wp_script_is( 'fast-smooth-scroll-polyfills', 'enqueued' );
		$polyfill_inline_script = $this->get_inline_script_data( 'fast-smooth-scroll-scroll-behavior-polyfill', 'before' );

		// Restore original `$wp_scripts`.
		$wp_scripts = $orig_wp_scripts;

		// Ensure that the polyfill is now force enqueued instead of the loader, and the extra inline script is added.
		$this->assertTrue( $polyfill_enqueued );
		$this->assertFalse( $loader_enqueued );
		$this->assertSame( 'document.documentElement.style.scrollBehavior = "auto";', $polyfill_inline_script );
	}

	public function test_fast_smooth_scroll_get_offset() {
		$this->assertSame( 0, fast_smooth_scroll_get_offset() );

		add_filter( 'fast_smooth_scroll_offset', array( $this, 'return_120' ) );
		$this->assertSame( 120, fast_smooth_scroll_get_offset() );
	}

	public function return_120() {
		return 120;
	}

	/**
	 * Workaround (almost polyfill) for `WP_Scripts::get_inline_script_data()` (introduced in WordPress 6.3).
	 *
	 * @param string $handle   Name of the script to get data for.
	 * @param string $position Optional. Whether to add the inline script before the handle or after. Default 'after'.
	 * @return string Inline script, which may be empty string.
	 */
	private function get_inline_script_data( $handle, $position = 'after' ) {
		$wp_scripts = wp_scripts();

		if ( method_exists( $wp_scripts, 'get_inline_script_data' ) ) {
			return $wp_scripts->get_inline_script_data( $handle, $position );
		}

		$data = $wp_scripts->get_data( $handle, $position );
		if ( empty( $data ) || ! is_array( $data ) ) {
			return '';
		}
		return trim( implode( "\n", $data ), "\n" );
	}
}
