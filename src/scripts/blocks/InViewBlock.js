import { AbstractInViewBlock } from 'starting-blocks';

export default class InViewBlock extends AbstractInViewBlock {
	constructor(container) {
		super(container, 'InViewBlock');

		this.observerOptions = {
			...this.observerOptions,
			root: document,
			threshold: 1,
		};
	}

	init() {
		super.init();

		this.$navigation = document.querySelector('.js-navigation');
		this.inner = this.$navigation.innerHTML;

		this.index = parseInt(this.rootElement.getAttribute('data-index'), 10);
		this.x = 0;
	}

	initEvents() {
		super.initEvents();
	}

	onScreen(entry) {
		const {
			isIntersecting,
			boundingClientRect: { x },
		} = entry;

		if (isIntersecting) {
			this.$navigation.innerHTML = this.index;
		}

		if (x > this.x && 1 === this.index) {
			this.$navigation.innerHTML = this.inner;
		}

		this.x = x;
		// this.rootElement.style.setProperty('will-change', 'opacity, transform');
	}
}
