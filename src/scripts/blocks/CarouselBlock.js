import { AbstractBlock } from 'starting-blocks';
import { next, previous } from 'utils/flickity.utilities';

const Flickity = require('flickity');

require('flickity-imagesloaded');

/**
 *
 * @constructor
 * @param {object} container
 */
export default class CarouselBlock extends AbstractBlock {
	constructor(container) {
		super(container, 'CarouselBlock');
	}

	init() {
		super.init();

		this.$wrapper = this.rootElement.querySelector('.woocommerce-product-gallery__wrapper');
		this.$next = this.rootElement.querySelector('.js-next') || false;
		this.$previous = this.rootElement.querySelector('.js-previous') || false;
		this.$current = this.rootElement.querySelector('.js-current');

		this.carousel = false;
		this.options = {};

		this.initPlugins();
	}

	initPlugins() {
		this.options = {
			pageDots: false,
			prevNextButtons: false,
			cellSelector: '.woocommerce-product-gallery__image',
			// draggable: true,
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
	}
}
