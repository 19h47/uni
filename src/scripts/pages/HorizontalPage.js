import { AbstractPage } from 'starting-blocks';
import Smooth from 'utils/smooth-scrolling.custom';
import { elements } from 'scripts/config';
import mediaBreakpointUp from 'utils/mediaBreakpointUp';

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

	init() {
		super.init();

		if (!this.md) {
			return false;
		}

		this.$track = this.rootElement.querySelector('.js-track');
		this.$section = this.rootElement.querySelector('.js-section');

		this.options = {
			preload: true,
			native: true,
			direction: 'vertical',
			section: this.$section,
			divs: this.$track,
		};

		return this.initPlugins();
	}

	initPlugins() {
		// console.info('initPlugins');

		this.scroll = new Smooth(this.options).init();
	}
}
