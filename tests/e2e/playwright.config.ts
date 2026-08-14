/**
 * External dependencies
 */
import { defineConfig } from '@playwright/test';

/**
 * WordPress dependencies
 */
const baseConfig = require( '@wordpress/scripts/config/playwright.config' );

const config = defineConfig( {
	...baseConfig,
	use: {
		...baseConfig.use,
		trace: 'retain-on-failure',
		/*
		 * The default WordPress Playwright config prefers reduced motion, which
		 * this plugin intentionally turns into instant jumps. Allow smooth scroll.
		 */
		contextOptions: {
			...baseConfig.use.contextOptions,
			reducedMotion: 'no-preference',
		},
	},
} );

export default config;
