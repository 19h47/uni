/* global uni */
import modular from '@19h47/modular';
import { html } from 'utils/environment';

require('scripts/vendors/validate');

// eslint-disable-next-line new-cap
const app = new modular({
	modules: [],
});

function init() {
	app.init(app);

	html.classList.add('is-loaded');
	html.classList.add('is-ready');
	html.classList.add('is-first-load');
	html.classList.remove('is-loading');

	setTimeout(() => html.classList.add('has-dom-ready'), 500);

	// window.addEventListener('mousemove', event => {
	// 	uni.clientX = event.clientX;
	// 	uni.clientY = event.clientY;
	// });
}

window.onload = () => {

	const $style = document.getElementById(`${uni.text_domain}-main-css`);

	if ($style) {
		console.log(`✅ "${uni.text_domain}-main-css" stylesheet found`);

		if ($style.isLoaded) {
			init();
		} else {
			$style.addEventListener('load', () => init());
		}
	} else {
		console.warn(`❌ "${uni.text_domain}-main-css" stylesheet not found`);
	}
};
