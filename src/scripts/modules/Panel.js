import { module as M } from '@19h47/modular';

import { disableScroll, enableScroll } from 'utils/scroll';
import { body } from 'utils/environment';

class Panel extends M {
	init() {
		this.isOpen = body.classList.contains(`${this.el.id}--is-open`);

		this.el.addEventListener('click', ({ target }) => {
			const { tagName } = target;

			if ('A' !== tagName && 'INPUT' !== tagName && 'BUTTON' !== tagName) {
				this.close();
			}
		});

		// On esc key
		document.onkeydown = ({ key }) => {
			if (27 === key) {
				this.close();
			}
		};
	}

	/**
	 * Panel.toggle
	 */
	toggle() {
		console.info('Panel.toggle()', this.el.id, this.isOpen);

		if (this.isOpen) {
			return this.close();
		}

		return this.open();
	}

	/**
	 * Panel.open
	 */
	open() {
		console.info('Panel.open()', this.el.id);

		if (this.isOpen) {
			return false;
		}

		this.isOpen = true;

		body.classList.add(`${this.el.id}--is-open`);
		this.el.style.removeProperty('transform')

		// When Panel is open, disableScroll
		disableScroll();

		return true;
	}

	/**
	 * Panel.close
	 */
	close() {
		console.info('Panel.close()', this.el.id);

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		body.classList.remove(`${this.el.id}--is-open`);
		this.el.style.setProperty('transform', 'translate3d(100%, 0, 0)')

		// When menu is closed, enableScroll
		enableScroll();

		return true;
	}
}

export default Panel;
