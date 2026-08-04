/**
 * External dependencies
 */
const wpConfig = require( '@wordpress/scripts/config/.eslintrc.js' );

const config = {
	...wpConfig,
	rules: {
		...( wpConfig?.rules || {} ),
		'no-var': 'off',
	},
	overrides: [
		...( wpConfig?.overrides || [] ),
		{
			files: [ 'tests/e2e/specs/**/*.js' ],
			rules: {
				'react-hooks/rules-of-hooks': 'off',
			},
		},
	],
};

module.exports = config;
