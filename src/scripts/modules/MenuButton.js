import { module as M } from '@19h47/modular';

class MenuButton extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: 'toggle'
		}
	}

	toggle() {
		console.log('MenuButton.toggle()');

		const action = this.getData('action') || 'toggle';
		this.call(action, false, 'Menu');
	}
}

export default MenuButton;
