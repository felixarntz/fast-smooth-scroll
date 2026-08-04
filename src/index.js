( function () {
	if (
		! window.requestAnimationFrame ||
		! window.performance ||
		! window.performance.now ||
		! window.NodeList
	) {
		return;
	}

	// polyfill forEach
	// https://developer.mozilla.org/en-US/docs/Web/API/NodeList/forEach#Polyfill
	if ( ! window.NodeList.prototype.forEach ) {
		window.NodeList.prototype.forEach = function ( callback, thisArg ) {
			let i;
			const len = this.length;

			thisArg = thisArg || window;

			for ( i = 0; i < len; i++ ) {
				callback.call( thisArg, this[ i ], i, this );
			}
		};
	}

	function easeInOutQuad( start, target, progress ) {
		progress /= 0.5;
		if ( progress < 1 ) {
			return ( ( target - start ) / 2 ) * progress * progress + start;
		}
		progress--;
		return (
			( -( target - start ) / 2 ) * ( progress * ( progress - 2 ) - 1 ) +
			start
		);
	}

	function smoothScrollAnimation( start, target, duration ) {
		const startTime = window.performance.now();

		function animationStep( currentTime ) {
			const timeElapsed = currentTime - startTime;
			const progress = Math.min( timeElapsed / duration, 1 );

			window.scrollTo( 0, easeInOutQuad( start, target, progress ) );

			if ( progress < 1 ) {
				window.requestAnimationFrame( animationStep );
			}
		}

		window.requestAnimationFrame( animationStep );
	}

	function smoothScroll( event ) {
		if ( ! event.target ) {
			return;
		}

		event.preventDefault();

		const targetId = event.target.getAttribute( 'href' ).substring( 1 );
		const targetElement = document.getElementById( targetId );
		if ( ! targetElement ) {
			return;
		}
		let targetOffset = targetElement.offsetTop;
		if ( window.fastSmoothScrollOffset ) {
			targetOffset = targetOffset - window.fastSmoothScrollOffset;
		}

		smoothScrollAnimation( window.pageYOffset, targetOffset, 500 );
		window.location.hash = '#' + targetId;
	}

	const links = document.querySelectorAll( 'a[href^="#"]' );
	links.forEach( function ( link ) {
		link.addEventListener( 'click', smoothScroll );
	} );
} )();
