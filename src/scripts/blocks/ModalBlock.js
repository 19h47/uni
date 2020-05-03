import { AbstractBlock } from 'starting-blocks';
import $ from 'jquery';

import { disableScroll, enableScroll } from 'utils/scroll';
import { elements } from 'scripts/config';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ModalBlock extends AbstractBlock {
	constructor(container) {
		// console.info('ModalBlock.constructor');

		super(container, 'ModalBlock');

		this.isOpen = elements.body.classList.contains('modal--is-open');

		// Scroll
		this.disableScroll = disableScroll;
		this.enableScroll = enableScroll;

		// Bind
		this.toggle = this.toggle.bind(this);
	}

	init() {
		super.init();

		this.buttons = [...this.rootElement.querySelectorAll('.js-modal-button')] || [];
		this.$price = this.rootElement.querySelector('.js-modal-price');
	}

	/**
	 * ModalBlock.initEvents
	 */
	initEvents() {
		// console.info('ModalBlock.setupEvents');
		super.initEvents();

		// On click
		this.buttons.forEach(button => button.addEventListener('click', this.toggle));

		// On esc key
		document.onkeydown = event => {
			if (27 === event.keyCode && this.isOpen) {
				this.close();
			}
		};

		$(document.body).on('added_to_cart', event => {
			this.toggle();
			console.log(event);
		});

		$(document.body).on('found_variation', (event, variation) => {
			this.$price.innerHTML = variation.price_html;
		});
	}

	/**
	 * ModalBlock.toggle
	 */
	toggle() {
		// console.info('ModalBlock.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * ModalBlock.open
	 */
	open() {
		// console.info('ModalBlock.open');
		if (this.isOpen) return false;

		this.isOpen = true;

		elements.body.classList.add('modal--is-open');

		// When menu is open, disableScroll
		this.disableScroll();

		return true;
	}

	/**
	 * ModalBlock.close
	 */
	close() {
		// console.info('ModalBlock.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		elements.body.classList.remove('modal--is-open');

		// When menu is closed, enableScroll
		this.enableScroll();

		return true;
	}
}
