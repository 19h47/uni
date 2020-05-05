import { AbstractInViewBlock } from 'starting-blocks';
import gsap from 'gsap';

export default class InViewBlock extends AbstractInViewBlock {
	constructor(container) {
		super(container, 'InViewBlock');

		this.observerOptions = {
			...this.observerOptions,
			threshold: 1,
		};

		this.clientX = 0;
		this.clientY = 0;

		this.render = this.render.bind(this);
	}

	init() {
		super.init();

		this.$navigation = document.querySelector('.js-navigation');
		this.$title = this.rootElement.querySelector('.js-title');
		this.$link = this.rootElement.querySelector('.js-link');

		this.inner = this.$navigation.innerHTML;

		this.index = parseInt(this.rootElement.getAttribute('data-index'), 10);
		this.x = 0;

		requestAnimationFrame(this.render);
	}

	initEvents() {
		super.initEvents();

		window.addEventListener('mousemove', event => {
			this.clientX = event.pageX;
			this.clientY = event.pageY;
		});

		this.$link.addEventListener('mouseenter', () => gsap.to(this.$title, { opacity: 1 }));
		this.$link.addEventListener('mouseleave', () => gsap.to(this.$title, { opacity: 0 }));
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

	render() {
		const rect = this.$link.getBoundingClientRect();

		gsap.to(this.$title, {
			x: this.clientX - rect.left,
			y: this.clientY - rect.top,
			duration: 0.1,
		});

		return requestAnimationFrame(this.render);
	}
}
