import { AbstractPage } from 'starting-blocks';
import VirtualScroll from 'virtual-scroll';
import { elements } from 'scripts/config';
import gsap from 'gsap';

// const imagesLoaded = require('imagesloaded');

/**
 * Horizontal page
 *
 * @extends {HorizontalPage}
 * @class
 */
export default class HorizontalPage extends AbstractPage {
	constructor(container) {
		super(container, 'HorizontalPage');

		this.scroll = null;
		// this.targetY = 0;
		// this.ease = 0.1;

		elements.html.style.setProperty('overflow', '100%');
		elements.html.style.setProperty('height', '100%');

		elements.body.style.setProperty('overflow', 'hidden');
		elements.body.style.setProperty('width', '100%');
		elements.body.style.setProperty('height', '100%');
	}

	async init() {
		this.$track = this.rootElement.querySelector('.js-track');
		this.$footer = this.rootElement.querySelector('.js-footer');

		this.scrollWidth = 0;
		this.clientWidth = 0;

		if (this.$footer) {
			this.onResize();
		}

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

			if (this.$footer) {
				const x = (this.$track.scrollLeft * 100) / (this.scrollWidth - this.clientWidth);

				gsap.to(this.$footer, {
					x,
				});
			}
		});
	}

	onResize() {
		super.onResize();

		this.scrollWidth = this.$track.scrollWidth;
		this.clientWidth = document.body.clientWidth;
	}
}
