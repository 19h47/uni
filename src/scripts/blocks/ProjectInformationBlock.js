import { AbstractBlock } from 'starting-blocks';
import { gsap } from 'gsap';

import { disableScroll, enableScroll } from 'utils/scroll';
import { elements } from 'scripts/config';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ProjectInformationBlock extends AbstractBlock {
	constructor(container) {
		// console.info('ProjectInformation.constructor');

		super(container, 'ProjectInformationBlock');

		this.isOpen = elements.body.classList.contains('project-information--is-open');

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

		this.buttons = document.querySelectorAll('.js-project-information-button') || [];
	}

	/**
	 * ProjectInformation.initEvents
	 */
	initEvents() {
		// console.info('ProjectInformation.setupEvents');
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
	 * ProjectInformation.toggle
	 */
	toggle() {
		// console.info('ProjectInformation.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}

	/**
	 * ProjectInformation.open
	 */
	open() {
		if (this.isOpen) return false;

		this.isOpen = true;

		elements.body.classList.add('project-information--is-open');

		this.timeline.play();

		// When ProjectInformation is open, disableScroll
		this.disableScroll();

		const menu = this.page.blocks.find(block => 'menu' === block.id);
		menu.close();

		return true;
	}

	/**
	 * ProjectInformation.close
	 */
	close() {
		// console.info('ProjectInformation.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		elements.body.classList.remove('ProjectInformation--is-open');

		this.timeline.reverse();

		// When ProjectInformation is closed, enableScroll
		this.enableScroll();

		return true;
	}

	onResize() {
		console.info('ProjectInformation.onResize');
		super.onResize();

		this.rect = this.rootElement.getBoundingClientRect();
		gsap.set(this.rootElement, { x: this.rect.width + 20 });
		this.close();
	}
}
