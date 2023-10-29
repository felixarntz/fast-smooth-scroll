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
			var i;
			var len = this.length;

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
		var startTime = window.performance.now();

		function animationStep( currentTime ) {
			var timeElapsed = currentTime - startTime;
			var progress = Math.min( timeElapsed / duration, 1 );

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

		var targetId = event.target.getAttribute( 'href' ).substring( 1 );
		var targetElement = document.getElementById( targetId );
		if ( ! targetElement ) {
			return;
		}

		smoothScrollAnimation(
			window.pageYOffset,
			targetElement.offsetTop,
			500
		);
		window.location.hash = '#' + targetId;
	}

	var links = document.querySelectorAll( 'a[href^="#"]' );
	links.forEach( function ( link ) {
		link.addEventListener( 'click', smoothScroll );
	} );
} )();
