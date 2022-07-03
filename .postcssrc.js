module.exports = {
	plugins: {
		'postcss-import': {
			plugins: [
				require("stylelint"),
			  ],
		},
		'postcss-advanced-variables': {},
		'postcss-preset-env': {},
		'postcss-nested': {},
		'autoprefixer': {},
		'postcss-custom-media': {},
		'postcss-generate-asset-php': {},
	}
};
