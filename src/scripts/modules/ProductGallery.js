import { module as M } from '@19h47/modular';
import { next, previous } from 'utils/flickity.utilities';

const Flickity = require('flickity');

class ProductGallery extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: {
				next: 'next',
				previous: 'previous',
			}
		}
	}

	init() {
		this.options = {
			pageDots: false,
			prevNextButtons: false,
			cellSelector: '.js-cell',
			wrapAround: true,
			setGallerySize: false,
			contain: true,
			cellAlign: 'center',
		};

		this.carousel = new Flickity(this.$('wrapper')[0], this.options);

		this.carousel.on('select', index => {
			this.$('current')[0].innerHTML = `${index + 1}`.padStart(2, '0');
		});

		this.carousel.on('staticClick', this.next.bind(this));
	}

	next() {
		next(this.carousel);
	}

	previous() {
		previous(this.carousel);
	}
}

export default ProductGallery;
