import { AbstractPage } from 'starting-blocks';
import VirtualScroll from 'virtual-scroll';
// import { elements } from 'scripts/config';
import gsap from 'gsap';

const imagesLoaded = require('imagesloaded');

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

		this.onResize = this.onResize.bind(this);
	}

	async init() {
		this.$track = this.rootElement.querySelector('.vs-track');
		this.$view = document.querySelector('.vs-view');
		this.$section = document.querySelector('.vs-section');

		imagesLoaded(this.rootElement, () => {
			this.onResize();
			this.initPlugins();
		});

		await super.init();
	}

	initPlugins() {
		console.log(this.rootElement, ' All images are loaded');
		this.scroll = new VirtualScroll();
	}

	initEvents() {
		super.initEvents();

		imagesLoaded(this.rootElement, () => {
			this.scroll.on(event => {
				const { deltaY } = event;

				this.targetY += deltaY;

				console.log(this.targetY);
				this.targetY = Math.max((this.width - window.innerWidth) * -1, this.targetY);
				this.targetY = Math.min(0, this.targetY);

				this.moveTo(`${this.targetY}px`);
			});

			window.addEventListener('resize', this.onResize);
		});
	}

	moveTo(x) {
		gsap.to(this.$section, { x });
	}

	onResize() {
		this.width = this.$track.scrollWidth;

		this.$view.style.setProperty('width', `${window.innerWidth}px`);
		this.$view.style.setProperty('height', `${this.width}px`);
		this.$section.style.setProperty('width', `${window.innerWidth}px`);
		this.$section.style.setProperty('height', `${window.innerHeight}px`);
	}
}
