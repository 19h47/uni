import { module as M } from '@19h47/modular';

class ProjectInformationButton extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: 'toggle',
		};
	}

	toggle() {
		const action = this.getData('action') ? this.getData('action') : 'toggle';

		console.log('ProjectInformationButton.toggle()', action);

		this.call(action, false, 'ProjectInformation');
	}
}

export default ProjectInformationButton;
