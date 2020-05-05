/**
 *
 * @file   webpack.production.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

const glob = require('glob');
const path = require('path');

const merge = require('webpack-merge');
const common = require('./webpack.common.js');

const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');

module.exports = merge(common, {
	output: {
		filename: 'js/[name].[chunkhash:8].js',
	},
	mode: 'production',
	devtool: false,
	watch: false,
	module: {
		rules: [
			{
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							publicPath: '../',
						},
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: false,
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sassOptions: Object.assign({
								sourceMap: false,
								precision: 10,
							}),
						},
					},
				],
			},
		],
	},
	plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin({
			filename: 'css/main.[chunkhash:8].css',
		}),
		new CompressionPlugin(),
		new PurgecssPlugin({
			paths: glob.sync(path.join(__dirname, '..', 'views/**/*.html.twig')),
			whitelist: [
				'Archive',
				'Page',
				'Front-page',
				'is-disabled',
				'is-off',
				'is-focus',
				'is-current',
				'is-selected',
				'is-loading',
				'is-active',
				'is-in-view',
				'is-selected',
				'has-background',
				'menu--is-open',
				'modal--is-open',
				'Menu--footer',
				'menu-mobile--is-open',
				'page-template-horizontal-page',
				'product-type-variable',
				'select',
				'Single-product',
				'iframe',
				'input',
				'button',
				'current-lang',
				'error-message',
				'success-message',
				'screen-reader-text',
				'span',
				'a',
			],
			whitelistPatternsChildren: [
				/^Cart/,
				/^Form/,
				/^leaflet-/,
				/^tippy-/,
				/^wp-block-/,
				/^flickity-/,
				/^wpcf7-/,
				/^Form__list/,
				/^Share__link--/,
				/^noUi/,
				/^Calendar/,
				/^grecaptcha/,
				/^Product/,
				/^jetpack/,
			],
		}),
	],
});
