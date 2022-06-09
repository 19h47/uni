import { module as M } from '@19h47/modular';

import { disableScroll, enableScroll } from 'utils/scroll';
import { body } from 'utils/environment';

class ProjectInformation extends M {
	constructor(m) {
		// console.info('ProjectInformation.constructor');

		super(m);

		this.isOpen = body.classList.contains('project-information--is-open');

		this.close = this.close.bind(this);
	}

	init() {
		this.el.addEventListener('click', event => {
			const { tagName } = event.target;

			if ('A' !== tagName) {
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
	 * ProjectInformation.toggle
	 */
	toggle() {
		// console.info('ProjectInformation.toggle');
		if (this.isOpen) {
			return this.close();
		}

		return this.open();
	}

	/**
	 * ProjectInformation.open
	 */
	open() {
		// console.info('ProjectInformation.open()');

		if (this.isOpen) return false;

		this.isOpen = true;

		body.classList.add('project-information--is-open');

		// When ProjectInformation is open, disableScroll
		disableScroll();

		return true;
	}

	/**
	 * ProjectInformation.close
	 */
	close() {
		console.info('ProjectInformation.close()');

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		body.classList.remove('project-information--is-open');

		// When ProjectInformation is closed, enableScroll
		enableScroll();

		return true;
	}
}

export default ProjectInformation;
