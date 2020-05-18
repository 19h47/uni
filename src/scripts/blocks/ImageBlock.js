/* global uni */
import { AbstractInViewBlock } from 'starting-blocks';
import gsap from 'gsap';
import mediaBreakpointUp from 'utils/mediaBreakpointUp';

export default class ImageBlock extends AbstractInViewBlock {
	constructor(container) {
		super(container, 'ImageBlock');

		this.md = mediaBreakpointUp('md');

		this.observerOptions = {
			...this.observerOptions,
			threshold: this.md ? 1 : 0.25,
		};

		this.clientX = uni.clientX;
		this.clientY = uni.clientY;

		this.render = this.render.bind(this);
	}

	init() {
		super.init();

		this.$navigation = document.querySelector('.js-navigation');
		this.description = this.rootElement.querySelector('.js-description') || false;
		this.$container = this.rootElement.querySelector('.js-container');

		this.inner = this.$navigation.innerHTML;

		this.index = parseInt(this.rootElement.getAttribute('data-index'), 10);
		this.x = 0;
		this.y = 0;

		if (this.description && this.md) {
			gsap.set(this.description, {
				xPercent: -50,
				yPercent: -50,
			});

			requestAnimationFrame(this.render);
		}
	}

	initEvents() {
		super.initEvents();

		if (this.description && this.md) {
			this.$container.addEventListener('mouseenter', () =>
				gsap.to(this.description, { opacity: 1 }),
			);
			this.$container.addEventListener('mouseleave', () =>
				gsap.to(this.description, { opacity: 0 }),
			);
		}
	}

	onScreen(entry) {
		const {
			isIntersecting,
			boundingClientRect: { x, y },
		} = entry;

		if (isIntersecting) {
			this.$navigation.innerHTML = this.index;
		}

		if (this.md && x > this.x && 1 === this.index) {
			this.$navigation.innerHTML = this.inner;
		}

		if (!this.md && y > this.y && 1 === this.index) {
			this.$navigation.innerHTML = this.inner;
		}

		this.x = x;
		this.y = y;

		// this.rootElement.style.setProperty('will-change', 'opacity, transform');
	}

	/**
	 * Render
	 */
	render() {
		gsap.to(this.description, {
			x: uni.clientX /* - rect.left */,
			y: uni.clientY /* - rect.top */,
			duration: 0.1,
		});

		return requestAnimationFrame(this.render);
	}
}
