import { module as M } from '@19h47/modular';

class ProductContent extends M {
	constructor(m) {
		// console.info('ProductContentBlock.constructor');

		super(m);

		this.events = {
			'mouseover': 'onMouseover',
		}
	}

	onMouseover({ target }) {
		// console.log('ProductContent.mouseover()', target);

		if (target.matches('.js-color')) {
			const color = target.getAttribute('data-color');
			const link = target.getAttribute('data-link');
			const images = [...this.el.querySelectorAll(`img[data-color="${color}"]`)];

			this.$('image').forEach(image => image.classList.remove('is-active'));
			this.$('link')[0].setAttribute('href', link);

			return images.forEach(image => image.classList.add('is-active'));
		}

		return false;
	}
}

export default ProductContent;
