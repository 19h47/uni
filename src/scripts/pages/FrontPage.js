import { AbstractPage } from 'starting-blocks';
import VirtualScroll from 'virtual-scroll';
// import { elements } from 'scripts/config';
import gsap from 'gsap';

// const imagesLoaded = require('imagesloaded');

const clamp = (number, min, max) => Math.min(Math.max(number, min), max);

/**
 * Front Page
 *
 * @extends {FrontPage}
 * @class
 */
export default class FrontPage extends AbstractPage {
	constructor(container) {
		super(container, 'FrontPage');

		this.scroll = null;
		this.currentTime = 0;
		this.options = { preventTouch: true };
	}

	async init() {
		this.$player = this.rootElement.querySelector('.js-player');
		this.$content = this.rootElement.querySelector('.js-content');

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

			this.currentTime += (deltaY * -1) / (this.$player.duration * 100);

			this.currentTime = clamp(this.currentTime, 0, this.$player.duration);

			gsap.to(this.$player, 0, {
				roundProps: this.currentTime,
				currentTime: this.currentTime,
			});
			gsap.to(this.$content, 0, {
				opacity: 1 - this.currentTime / (this.$player.duration * 0.5),
			});
		});
	}

	onResize() {
		super.onResize();
	}
}
