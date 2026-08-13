/**
 * WordPress dependencies
 */
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe( 'Smooth scroll', () => {
	let postId;

	test.beforeAll( async ( { requestUtils } ) => {
		const spacer = Array( 40 )
			.fill(
				'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>'
			)
			.join( '' );

		const post = await requestUtils.createPost( {
			title: 'Smooth Scroll E2E',
			content: [
				'<p><a href="#target-section">Jump to target section</a></p>',
				spacer,
				'<h2 id="target-section">Target Section</h2>',
				'<p>Destination content after the long scroll.</p>',
			].join( '' ),
			status: 'publish',
		} );

		postId = post.id;
	} );

	test.afterAll( async ( { requestUtils } ) => {
		await requestUtils.deleteAllPosts();
		postId = undefined;
	} );

	test( 'Clicking an in-page anchor link smooth-scrolls to the target', async ( {
		page,
	} ) => {
		await page.goto( `/?p=${ postId }` );

		const link = page.locator( 'a[href="#target-section"]' );
		const target = page.locator( '#target-section' );

		await expect( link ).toBeVisible();
		await expect( target ).toBeVisible();

		const layout = await page.evaluate( () => {
			const targetEl = document.getElementById( 'target-section' );
			return {
				scrollY: window.scrollY,
				viewportHeight: window.innerHeight,
				targetTop:
					targetEl.getBoundingClientRect().top + window.scrollY,
			};
		} );

		expect( layout.scrollY ).toBe( 0 );
		expect( layout.targetTop ).toBeGreaterThan( layout.viewportHeight );

		await page.evaluate( () => {
			window.__scrollSamples = [];
			window.__scrollSampleInterval = setInterval( () => {
				window.__scrollSamples.push( window.scrollY );
			}, 16 );
		} );

		await link.click();

		await page.waitForFunction( () => {
			const targetEl = document.getElementById( 'target-section' );
			if ( ! targetEl ) {
				return false;
			}
			const top = targetEl.getBoundingClientRect().top;
			return top >= -5 && top <= 50;
		} );

		const samples = await page.evaluate( () => {
			clearInterval( window.__scrollSampleInterval );
			return window.__scrollSamples;
		} );

		const increasingSamples = samples.filter( ( y, i, arr ) => {
			return i === 0 || y >= arr[ i - 1 ];
		} );

		const uniquePositions = [ ...new Set( samples ) ];
		expect( uniquePositions.length ).toBeGreaterThan( 2 );
		expect( increasingSamples.length ).toBe( samples.length );

		const finalScrollY = await page.evaluate( () => window.scrollY );
		expect( finalScrollY ).toBeGreaterThan( layout.viewportHeight / 2 );

		await expect( page ).toHaveURL( /#target-section$/ );
	} );
} );
