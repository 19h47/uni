import { AbstractBlock } from 'starting-blocks';
import { gsap } from 'gsap';

import { disableScroll, enableScroll } from 'utils/scroll';
import { elements } from 'scripts/config';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class MenuBlock extends AbstractBlock {
	constructor(container) {
		// console.info('Menu.constructor');

		super(container, 'MenuBlock');

		this.isOpen = elements.body.classList.contains('menu--is-open');

		// Scroll
		this.disableScroll = disableScroll;
		this.enableScroll = enableScroll;

		this.close = this.close.bind(this);
	}

	init() {
		super.init();

		this.onResize();

		this.timeline = gsap.timeline({ paused: true });

		this.timeline.fromTo(
			this.rootElement,
			{
				duration: 0.3,
				x: this.rect.width + 20,
				ease: 'power3.in',
			},
			{ x: 0 },
		);

		this.buttons = document.querySelectorAll('.js-menu-button') || [];
	}

	/**
	 * Menu.initEvents
	 */
	initEvents() {
		// console.info('Menu.setupEvents');
		super.initEvents();

		// On click
		[...this.buttons].forEach(button => {
			button.addEventListener('click', () => this.toggle());
		});

		this.rootElement.addEventListener('click', event => {
			const { tagName } = event.target;

			if ('A' !== tagName) {
				this.close();
			}
		});

		// On esc key
		document.onkeydown = event => {
			if (27 === event.keyCode) {
				this.close();
			}
		};
	}

	/**
	 * Menu.toggle
	 */
	toggle() {
		// console.info('Menu.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * Menu.open
	 */
	open() {
		console.info('Menu.open');
		if (this.isOpen) return false;

		this.isOpen = true;

		elements.body.classList.add('menu--is-open');

		this.timeline.play();

		// When menu is open, disableScroll
		this.disableScroll();

		const projectInformations = this.page.blocks.find(
			block => 'project-informations' === block.id,
		);
		projectInformations.close();

		return true;
	}

	/**
	 * Menu.close
	 */
	close() {
		// console.info('Menu.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		elements.body.classList.remove('menu--is-open');

		this.timeline.reverse();

		// When menu is closed, enableScroll
		this.enableScroll();

		return true;
	}

	onResize() {
		// console.info('Menu.onResize');
		super.onResize();

		this.rect = this.rootElement.getBoundingClientRect();
		gsap.set(this.rootElement, { x: this.rect.width + 20 });
	}
}
