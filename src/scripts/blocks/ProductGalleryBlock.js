import { AbstractBlock } from 'starting-blocks';
import { next, previous } from 'utils/flickity.utilities';

const Flickity = require('flickity');

require('flickity-imagesloaded');

/**
 *
 * @constructor
 * @param {object} container
 */
class ProductGalleryBlock extends AbstractBlock {
	constructor(container) {
		super(container, 'ProductGalleryBlock');
	}

	init() {
		super.init();

		this.$wrapper = this.rootElement.querySelector('.js-wrapper');
		this.$next = this.rootElement.querySelector('.js-next') || false;
		this.$previous = this.rootElement.querySelector('.js-previous') || false;
		this.$current = this.rootElement.querySelector('.js-current');

		this.carousel = false;
		this.options = {};

		return this.initPlugins();
	}

	initPlugins() {
		this.options = {
			pageDots: false,
			prevNextButtons: false,
			cellSelector: '.js-cell',
			wrapAround: true,
			setGallerySize: false,
			imagesLoaded: true,
			contain: true,
			cellAlign: 'center',
		};

		this.carousel = new Flickity(this.$wrapper, this.options);
	}

	initEvents() {
		super.initEvents();

		if (this.$next) {
			this.$next.addEventListener('click', () => {
				next(this.carousel);
			});
		}

		if (this.$previous) {
			this.$previous.addEventListener('click', () => {
				previous(this.carousel);
			});
		}

		this.carousel.on('select', index => {
			this.$current.innerHTML = `${index + 1}`.padStart(2, '0');
		});

		this.carousel.on('staticClick', () => {
			return next(this.carousel);
		});
	}
}

export default ProductGalleryBlock;
