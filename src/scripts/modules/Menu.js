import { module as M } from '@19h47/modular';

import { disableScroll, enableScroll } from 'utils/scroll';
import { body } from 'utils/environment';

class Menu extends M {
	constructor(m) {
		// console.info('Menu.constructor');

		super(m);

		this.isOpen = body.classList.contains('menu--is-open');

		this.close = this.close.bind(this);
	}

	init() {

		this.el.addEventListener('click', ({ target }) => {
			const { tagName } = target;

			if ('A' !== tagName && 'INPUT' !== tagName) {
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
	 * Menu.toggle
	 */
	toggle() {
		console.info('Menu.toggle()');

		if (this.isOpen) {
			return this.close();
		}

		return this.open();
	}

	/**
	 * Menu.open
	 */
	open() {
		console.info('Menu.open()');

		if (this.isOpen) {
			return false;
		}

		this.isOpen = true;

		body.classList.add('menu--is-open');

		// When menu is open, disableScroll
		disableScroll();

		// const projectInformation = this.page.blocks.find(
		// 	block => 'project-information' === block.id,
		// );

		// if (projectInformation) {
		// 	projectInformation.close();
		// }

		return true;
	}

	/**
	 * Menu.close
	 */
	close() {
		console.info('Menu.close()');

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		body.classList.remove('menu--is-open');

		// When menu is closed, enableScroll
		enableScroll();

		return true;
	}
}

export default Menu;
