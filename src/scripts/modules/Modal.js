import { module as M } from '@19h47/modular';
import $ from 'jquery';

import { disableScroll, enableScroll } from 'utils/scroll';
import { body } from 'utils/environment';

class Modal extends M {
	constructor(m) {
		// console.info('Modal.constructor');

		super(m);

		this.isOpen = body.classList.contains('modal--is-open');

		// Scroll
		this.disableScroll = disableScroll;
		this.enableScroll = enableScroll;

		// Bind
		this.toggle = this.toggle.bind(this);

		this.events = {
			click: { close: 'close' },
		};
	}

	init() {
		// On esc key
		document.onkeydown = ({ key }) => {
			if (27 === key) {
				this.close();
			}
		};

		$(document.body).on('added_to_cart', () => this.toggle());

		$(document.body).on('found_variation', (_, variation) => {
			this.$('price')[0].innerHTML = variation.price_html;
		});
	}

	/**
	 * Modal.toggle
	 */
	toggle() {
		// console.info('Modal.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * Modal.open
	 */
	open() {
		// console.info('Modal.open');
		if (this.isOpen) {
			return false;
		}

		this.isOpen = true;

		body.classList.add('modal--is-open');

		// When menu is open, disableScroll
		disableScroll();

		return true;
	}

	/**
	 * Modal.close
	 */
	close() {
		console.info('Modal.close()');

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		body.classList.remove('modal--is-open');

		// When menu is closed, enableScroll
		enableScroll();

		return true;
	}
}

export default Modal;
