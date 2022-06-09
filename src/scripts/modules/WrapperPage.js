import { module as M } from '@19h47/modular';
import $ from 'jquery';

class WrapperPage extends M {
	block() {
		$(this.el).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6,
			},
		});
	}

	unblock() {
		$(this.el).unblock();
	}
}

export default WrapperPage;
