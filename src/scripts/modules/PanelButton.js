import { module as M } from '@19h47/modular';

class PanelButton extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: 'toggle',
		};
	}

	toggle() {
		// console.log('PanelButton.toggle()');

		const action = this.getData('action') || 'toggle';
		const id = this.getData('id');

		if (id) {
			[...Object.entries(this.modules.Panel)].forEach(([key, obj]) => {
				if (key !== id) {
					obj.close();
				}
			});

			this.call(action, false, 'Panel', id);
		}
	}
}

export default PanelButton;
