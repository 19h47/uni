import { AbstractBlock } from 'starting-blocks';
import { gsap } from 'gsap';

import { disableScroll, enableScroll } from 'utils/scroll';
import { elements } from 'scripts/config';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ProjectInformationsBlock extends AbstractBlock {
	constructor(container) {
		// console.info('ProjectInformations.constructor');

		super(container, 'ProjectInformationsBlock');

		this.isOpen = elements.body.classList.contains('project-informations--is-open');

		// Scroll
		this.disableScroll = disableScroll;
		this.enableScroll = enableScroll;

		this.rect = {};

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

		this.buttons = document.querySelectorAll('.js-project-informations-button') || [];
	}

	/**
	 * ProjectInformations.initEvents
	 */
	initEvents() {
		// console.info('ProjectInformations.setupEvents');
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
	 * ProjectInformations.toggle
	 */
	toggle() {
		// console.info('ProjectInformations.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * ProjectInformations.open
	 */
	open() {
		if (this.isOpen) return false;

		this.isOpen = true;

		elements.body.classList.add('project-informations--is-open');

		this.timeline.play();

		// When ProjectInformations is open, disableScroll
		this.disableScroll();

		const menu = this.page.blocks.find(block => 'menu' === block.id);
		menu.close();

		return true;
	}

	/**
	 * ProjectInformations.close
	 */
	close() {
		// console.info('ProjectInformations.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		elements.body.classList.remove('ProjectInformations--is-open');

		this.timeline.reverse();

		// When ProjectInformations is closed, enableScroll
		this.enableScroll();

		return true;
	}

	onResize() {
		console.info('ProjectInformations.onResize');
		super.onResize();

		this.rect = this.rootElement.getBoundingClientRect();
		gsap.set(this.rootElement, { x: this.rect.width + 20 });
		this.close();
	}
}
