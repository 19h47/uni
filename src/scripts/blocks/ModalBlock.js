import { AbstractBlock } from 'starting-blocks';

import { disableScroll, enableScroll } from 'utils/scroll';
import { elements } from 'scripts/config';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ModalBlock extends AbstractBlock {
	constructor(container) {
		// console.info('Modal.constructor');

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

		this.buttons = document.querySelectorAll('.js-modal-button') || [];
	}

	/**
	 * Modal.initEvents
	 */
	initEvents() {
		// console.info('Modal.setupEvents');
		super.initEvents();

		// On click
		[...this.buttons].forEach(button => button.addEventListener('click', this.toggle));

		// On esc key
		document.onkeydown = event => {
			if (27 === event.keyCode && this.isOpen) {
				this.close();
			}
		};

		document.body.addEventListener('added_to_cart', event => {
			this.toggle();
			console.log(event);
		});
	}

	/**
	 * Modal.toggle
	 */
	toggle() {
		console.info('Modal.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * Modal.open
	 */
	open() {
		console.info('Modal.open');
		if (this.isOpen) return false;

		this.isOpen = true;

		elements.body.classList.add('modal--is-open');

		// When menu is open, disableScroll
		this.disableScroll();

		return true;
	}

	/**
	 * Modal.close
	 */
	close() {
		// console.info('Modal.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		elements.body.classList.remove('modal--is-open');

		// When menu is closed, enableScroll
		this.enableScroll();

		return true;
	}
}
