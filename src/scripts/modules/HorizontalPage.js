import { module as M } from '@19h47/modular';
import Smooth from 'utils/smooth-scrolling.custom';
import { elements } from 'scripts/config';
import { breakpoints } from 'utils/environment';

const imagesLoaded = require('imagesloaded');

class HorizontalPage extends M {
	constructor(container) {
		super(container, 'HorizontalPage');

		this.scroll = null;

		elements.html.style.setProperty('width', '100%');
		elements.html.style.setProperty('height', '100%');
	}

	init() {
		if (!breakpoints.md.matches) {
			return false;
		}

		this.options = {
			preload: true,
			native: true,
			direction: 'vertical',
			section: this.$('section')[0],
			divs: this.$('track')[0],
		};

		return imagesLoaded(this.el, () => {
			console.log('all images are loaded');

			this.resize()
			window.addEventListener('resize', this.resize.bind(this))

			this.initPlugins();
		});
	}

	initPlugins() {
		console.info('HorizontalPage.initPlugins');

		this.scroll = new Smooth(this.options).init();
	}

	resize() {
		this.$('image').forEach($image => {
			const { width } = $image.getBoundingClientRect();

			console.log(`${width}px`);

			$image.parentElement.style.setProperty('width', `${width}px`);
		});
	}
}

export default HorizontalPage;