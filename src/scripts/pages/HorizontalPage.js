import { AbstractPage } from 'starting-blocks';
import Smooth from 'utils/smooth-scrolling.custom';
import { elements } from 'scripts/config';
// import { gsap } from 'gsap';
import mediaBreakpointUp from 'utils/mediaBreakpointUp';

const imagesLoaded = require('imagesloaded');

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
		this.md = mediaBreakpointUp('md');

		elements.html.style.setProperty('width', '100%');
		elements.html.style.setProperty('height', '100%');

		return true;
	}

	async init() {
		await super.init();

		if (!this.md) {
			return false;
		}

		this.$track = this.rootElement.querySelector('.js-track');
		this.$footer = this.rootElement.querySelector('.js-footer');
		this.$section = this.rootElement.querySelector('.js-section');

		this.options = {
			preload: false,
			native: true,
			direction: 'vertical',
			section: this.$section,
			divs: this.$track,
		};

		return this.initPlugins();
	}

	initPlugins() {
		console.info('initPlugins');
		this.scroll = new Smooth(this.options);

		imagesLoaded(this.rootElement, () => {
			this.scroll.init();
		});
	}

	// initEvents() {
	// 	// console.info('initEvents');
	// 	super.initEvents();

	// 	this.scroll.on(event => {
	// 		console.log(event);
	// 		const { deltaY } = event;

	// 		this.$track.scrollLeft -= deltaY * 0.5;

	// 		if (this.$footer && this.md) {
	// 			const x = (this.$track.scrollLeft * 100) / (this.scrollWidth - this.clientWidth);

	// 			gsap.to(this.$footer, {
	// 				x,
	// 			});
	// 		}
	// 	});
	// }

	onResize() {
		super.onResize();

		if (!this.md) {
			return false;
		}

		this.scrollWidth = this.$track.scrollWidth;
		this.clientWidth = document.body.clientWidth;

		return true;
	}
}
