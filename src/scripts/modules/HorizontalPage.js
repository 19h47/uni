import { module as M } from '@19h47/modular';
import Smooth from 'utils/smooth-scrolling.custom';
import { breakpoints, html } from 'utils/environment';

class HorizontalPage extends M {
	constructor(container) {
		super(container, 'HorizontalPage');

		this.scroll = null;

		html.style.setProperty('width', '100%');
		html.style.setProperty('height', '100%');
	}

	init() {
		if (!breakpoints.md.matches) {
			html.classList.remove('cursor-wait');

			return false;
		}

		this.options = {
			preload: false,
			native: true,
			direction: 'vertical',
			section: this.$('section')[0],
			divs: this.$('track')[0],
		};

		html.classList.remove('cursor-wait');

		this.resize()
		window.addEventListener('resize', this.resize.bind(this))

		return this.initPlugins();
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
