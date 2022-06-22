import { module as M } from '@19h47/modular';

const toggle = $el => {
	if ('none' === $el.style.display) {
		return $el.style.setProperty('display', 'block');
	}

	if ('block' === $el.style.display) {
		return $el.style.setProperty('display', 'none');
	}

	return true;
};

/**
 * DisclosureButton
 *
 * @see https://www.w3.org/TR/wai-aria-practices-1.1/#disclosure
 */
class DisclosureButton extends M {
	constructor(m) {
		super(m);

		// console.log('DisclosureButton', this.el);

		this.events = { click: 'onClick', focus: 'onFocus', blur: 'onBlur' };
	}

	init() {
		const ids = this.el
			.getAttribute('aria-controls')
			.split(',')
			.map(id => `#${id.trim()}`);

		this.elements = [...document.querySelectorAll(ids.join(','))];
	}

	onClick() {
		this.toggle();
	}

	onFocus() {
		this.el.classList.add('focus');
	}

	onBlur() {
		this.el.classList.remove('focus');
	}

	toggle() {
		if ('true' === this.el.getAttribute('aria-expanded')) {
			this.el.setAttribute('aria-expanded', false);
		} else {
			this.el.setAttribute('aria-expanded', true);
		}

		this.elements.forEach($el => toggle($el));
	}
}

export default DisclosureButton;
