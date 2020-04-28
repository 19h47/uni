import { AbstractPage } from 'starting-blocks';
import VirtualScroll from 'virtual-scroll';
import { elements } from 'scripts/config';

// const imagesLoaded = require('imagesloaded');

/**
 * Y Scroll page
 *
 * @extends {HorizontalPage}
 * @class
 */
export default class HorizontalPage extends AbstractPage {
	constructor(container) {
		super(container, 'HorizontalPage');

		this.scroll = null;
		this.targetY = 0;

		elements.html.style.setProperty('overflow', '100%');
		elements.html.style.setProperty('height', '100%');

		elements.body.style.setProperty('overflow', 'hidden');
		elements.body.style.setProperty('width', '100%');
		elements.body.style.setProperty('height', '100%');
	}

	async init() {
		this.$track = this.rootElement.querySelector('.js-track');
		// this.$section = document.querySelector('.js-section');

		this.initPlugins();

		await super.init();
	}

	initPlugins() {
		this.scroll = new VirtualScroll();
	}

	initEvents() {
		super.initEvents();

		this.scroll.on(event => {
			const { deltaY } = event;

			this.$track.scrollLeft -= deltaY;
		});
	}
}
