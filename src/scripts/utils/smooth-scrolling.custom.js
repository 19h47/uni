import Smooth from 'smooth-scrolling';

export default class Custom extends Smooth {
	constructor(opt) {
		super(opt);
		this.resizing = false;
		this.cache = null;

		this.dom.divs = opt.divs;

		this.getCache = this.getCache.bind(this);
		this.inViewport = this.inViewport.bind(this);
	}

	resize() {
		console.info('Custom.resize');

		super.resize();
		this.getCache();
		this.vars.bounding =
			this.cache.reduce((acc, current) => acc + current.width, 0) -
			this.vars.width +
			this.vars.height +
			100;
		this.dom.scroll.style.width = '';
		this.dom.scroll.style.height = `${this.vars.bounding}px`;
	}

	getCache() {
		this.cache = [];

		this.dom.divs.children.forEach(el => {
			const { target } = this.vars;
			const { left, right, width } = el.getBoundingClientRect();
			const bounds = {
				el,
				left: left + target,
				right: right + target,
				width,
				center: width / 2,
			};
			this.cache.push(bounds);
		});
	}

	run() {
		this.dom.divs.children.forEach((el, i) => this.inViewport(el, i));
		this.dom.section.style[this.prefix] = `translate3d(${this.vars.current * -1}px,0,0)`;
		super.run();
	}

	inViewport(el, index) {
		if (!this.cache) {
			return;
		}

		const cache = this.cache[index];

		const { current } = this.vars;
		const left = Math.round(cache.left - current);
		const right = Math.round(cache.right - current);
		const inview = 0 < right && left < this.vars.width;

		const $grid = el.querySelector('.js-grid') || false;
		const $title = el.querySelector('.js-title') || false;
		const $footer = el.querySelector('.js-footer') || false;

		if (inview && right >= this.vars.width && 0 === index) {
			el.classList.add('is-in-viewport');

			[$grid].forEach($element => {
				if ($element) {
					$element.style.setProperty(
						this.prefix,
						`translate3d(${this.vars.current.toFixed(2)}px, 0, 0)`,
					);
				}
			});

			if ($footer) {
				$footer.style.setProperty(
					this.prefix,
					`translate3d(${this.vars.current.toFixed(2) * 0.01}px, 0, 0)`,
				);
			}

			if ($title) {
				$title.style.setProperty(
					this.prefix,
					`translate3d(${this.vars.current.toFixed(2) * 1.01}px, 0, 0)`,
				);
			}
		} else {
			el.classList.remove('is-in-viewport');
		}
	}
}
