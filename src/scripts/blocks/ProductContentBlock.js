import { AbstractBlock } from 'starting-blocks';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ProductContentBlock extends AbstractBlock {
	constructor(container) {
		// console.info('ProductContentBlock.constructor');

		super(container, 'ProductContentBlock');
	}

	init() {
		super.init();

		this.images = [...this.rootElement.querySelectorAll('img')];
		this.$link = this.rootElement.querySelector('.js-link');
	}

	initEvents() {
		super.initEvents();

		this.rootElement.addEventListener('mouseover', event => {
			const { target } = event;

			if (target.matches('.js-color')) {
				const color = target.getAttribute('data-color');
				const link = target.getAttribute('data-link');
				const img = this.rootElement.querySelector(`img[data-color="${color}"]`);

				this.images.map(image => image.classList.remove('is-active'));
				this.$link.setAttribute('href', link);

				return img.classList.add('is-active');
			}

			return false;
		});
	}
}
