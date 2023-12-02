module.exports = {
	plugins: {
		'postcss-import': {
			plugins: [ require( 'stylelint' ) ],
		},
		'postcss-preset-env': {
			stage: 2,
			features: {
				'nesting-rules': true
			}
		},
	}
};
