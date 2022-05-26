/**
 * Common
 *
 * @file   webpack.common.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

// Node modules
const path = require('path');

/**
 * Resolve
 *
 * @param {string} dir Dir.
 * @return {string} Dir.
 */
function resolve(dir) {
	return path.join(__dirname, '..', dir);
}

// Plugins
const webpack = require('webpack');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');
const dotenv = require('dotenv').config({ path: resolve('.env') });

// Manifest plugin
const manifestPlugin = new WebpackManifestPlugin({
	publicPath: 'dist/',
});


module.exports = {
	output: {
		path: resolve('dist'),
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
	},
	optimization: {
		splitChunks: {
			// include all types of chunks
			chunks: 'all',
			name: 'vendors'
		},
	},
	resolve: {
		alias: {
			'@': resolve('src'),

			// scripts
			scripts: resolve('src/scripts'),
			common: resolve('src/scripts/common'),
			pages: resolve('src/scripts/pages'),
			services: resolve('src/scripts/services'),
			utils: resolve('src/scripts/utils'),
			blocks: resolve('src/scripts/blocks'),
			polyfills: resolve('src/scripts/polyfills'),
			abstracts: resolve('src/scripts/abstracts'),
			vendors: resolve('src/scripts/vendors'),
			videos: resolve('src/videos'),

			// stylesheets
			stylesheets: resolve('src/stylesheets'),

			// img
			jpg: resolve('src/img/jpg'),
			png: resolve('src/img/png'),
			svg: resolve('src/img/svg'),
			icons: resolve('src/icons'),
		},
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
			},
			{
				test: /\.(woff2?|eot|ttf|otf|woff|svg)?$/,
				exclude: [/img/, /icons/],
				type: 'asset/resource',
				generator: {
					filename: 'fonts/[name][ext][query]',
				},
			},
			{
				test: /\.svg$/,
				exclude: [/img/, /fonts/],
				use: [
					{
						loader: 'svg-sprite-loader',
						options: {
							spriteFilename: 'icons.svg',
							extract: true,
						},
					},
					'svg-transform-loader',
					'svgo-loader',
				],
			},
			{
				test: /\.svg$/,
				exclude: [/fonts/, /icons/],
				type: 'asset/resource',
				generator: {
					filename: 'img/svg/[name][ext]',
				},
				use: 'svgo-loader',
			},
			{
				test: /\.(mp4|webm|ogg|mp3|wav|flac|aac|ogv)(\?.*)?$/,
				use: [
					{
						loader: 'url-loader',
						options: {
							limit: 100000,
							name: '[name].[ext]',
							publicPath: resolve('src/videos'),
							outputPath: 'videos/',
						},
					},
				],
			},
			{
				test: /\.(gif)$/i,
				exclude: [/animations/],
				type: 'asset/resource',
				generator: {
					filename: 'img/gif/[name][ext]',
				},
				use: [
					{
						loader: 'image-webpack-loader',
						options: {
							gifsicle: {
								interlaced: false,
							},
						},
					},
				],
			},
			{
				test: /\.(png)$/i,
				exclude: [/animations/],
				type: 'asset/resource',
				generator: {
					filename: 'img/png/[name][ext]',
				},
				use: [
					{
						loader: 'image-webpack-loader',
						options: {
							optipng: {
								enabled: false,
							},
							pngquant: {
								quality: [0.65, 0.9],
								speed: 4,
							},
						},
					},
				],
			},
			{
				test: /\.(jpe?g)$/i,
				exclude: [/animations/],
				type: 'asset/resource',
				generator: {
					filename: 'img/jpg/[name][ext]',
				},
				use: [
					{
						loader: 'image-webpack-loader',
						options: {
							mozjpeg: {
								progressive: true,
								quality: [65],
							},
						},
					},
				],
			},
		],
	},
	plugins: [
		manifestPlugin,
		new SpriteLoaderPlugin({ plainSprite: true }),
		new WebpackNotifierPlugin({
			title: 'Webpack',
			excludeWarnings: true,
			alwaysNotify: true,
		}),
		new webpack.DefinePlugin({
			'process.env': dotenv.parsed,
		}),
	],
};
