/* global uni */
import StartingBlocks, { polyfills } from 'starting-blocks';

import WebpackAsyncBlockBuilder from 'services/WebpackAsyncBlockBuilder';

import HorizontalPage from 'pages/HorizontalPage';
import FrontPage from 'pages/FrontPage';

require('scripts/vendors/validate');

const production = 'production' !== process.env.NODE_ENV;

(() => {
	window.MAIN_EXECUTED = true;

	polyfills();

	const startingBlocks = new StartingBlocks({
		// manualDomAppend: true,
		debug: production ? 1 : 0,
	});

	window.addEventListener('mousemove', event => {
		uni.clientX = event.clientX;
		uni.clientY = event.clientY;
	});

	startingBlocks.provider('BlockBuilder', WebpackAsyncBlockBuilder);

	startingBlocks.instanceFactory('HorizontalPage', c => new HorizontalPage(c));
	startingBlocks.instanceFactory('FrontPage', c => new FrontPage(c));

	startingBlocks.boot();
})();
