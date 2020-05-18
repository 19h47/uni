import { AbstractPage } from 'starting-blocks';
import VirtualScroll from 'virtual-scroll';
import { elements } from 'scripts/config';
import gsap from 'gsap';
import mediaBreakpointUp from 'utils/mediaBreakpointUp';

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

		if (!mediaBreakpointUp('md')) {
			return false;
		}

		this.scroll = null;
		this.options = { mouseMultiplier: 4, touchMultiplier: 8 };

		elements.html.style.setProperty('overflow', '100%');
		elements.html.style.setProperty('height', '100%');

		elements.body.style.setProperty('overflow', 'hidden');
		elements.body.style.setProperty('width', '100%');
		elements.body.style.setProperty('height', '100%');

		return true;
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
		this.scroll = new VirtualScroll(this.options);
	}

	initEvents() {
		super.initEvents();

		this.scroll.on(event => {
			const { deltaY } = event;

			this.$track.scrollLeft -= deltaY * 0.5;

			if (this.$footer && mediaBreakpointUp('md')) {
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
