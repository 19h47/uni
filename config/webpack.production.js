/**
 * Production
 *
 * @file   webpack.production.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

const glob = require('glob');
const path = require('path');

const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');

const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');
const purgecssWordpress = require('purgecss-with-wordpress');

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
							sassOptions: {
								sourceMap: false,
								precision: 10,
							},
						},
					},
				],
			},
		],
	},
	plugins: [
		new CleanWebpackPlugin({
			cleanOnceBeforeBuildPatterns: [path.join(__dirname, '..', 'dist')],
		}),
		new MiniCssExtractPlugin({
			filename: 'css/main.[chunkhash:8].css',
		}),
		new CompressionPlugin(),
		// new PurgecssPlugin({
		// 	paths: glob.sync(
		// 		[
		// 			path.join(__dirname, '..', '../*'),
		// 			path.join(__dirname, '..', '../woocommerce/**/*'),
		// 			path.join(__dirname, '..', '../templates/**/*'),
		// 			path.join(__dirname, '..', '../template-parts/**/*'),
		// 		],
		// 		{ nodir: true },
		// 	),
		// 	safelist: purgecssWordpress.safelist,
		// 	defaultExtractor: content => content.match(/[^<>"'`\s]*[^<>"'`\s:]/g) || [],
		// }),
	],
});
