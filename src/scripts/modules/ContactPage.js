/* global uni */
import { module as M } from '@19h47/modular';
import Bouncer from 'formbouncerjs';

const { ajax_url: ajaxUrl, nonce, messages } = uni;

const remove = target => target.classList.remove('Form--loading');

class ContactPage extends M {
	constructor(m) {
		super(m);

		this.bouncer = null;
		this.url = `${ajaxUrl}?action=send_message&nonce=${nonce}`;
	}

	init() {
		// console.log('ContactPage.init()');

		this.bouncer = new Bouncer('form.js-contact-page-form', {
			fieldClass: 'has-error',
			errorClass: 'error-message',
			messages: {
				missingValue: {
					default: messages.value_missing.default,
				},
				patternMismatch: {
					email: messages.type_mismatch.email,
					default: messages.type_mismatch.default,
				},
			},
			disableSubmit: true,
		});

		this.el.addEventListener('bouncerFormValid', () => {
			const form = new FormData(this.$('form')[0]);

			this.$('form')[0].classList.add('is-loading');

			this.$('form')[0].style.setProperty('pointer-events', 'none');
			this.$('form')[0].style.setProperty('opacity', '0.6');

			this.$('error')[0].style.setProperty('display', 'none');
			this.$('success')[0].style.setProperty('display', 'none');
			this.$('content')[0].style.setProperty('display', 'flex');

			fetch(this.url, {
				method: 'POST',
				body: form,
			})
				.then(() => {
					remove(this.el);
					this.$('form')[0].classList.remove('is-loading');
					this.$('form')[0].classList.add('is-success');

					this.$('form')[0].style.removeProperty('pointer-events');
					this.$('form')[0].style.removeProperty('opacity');

					this.$('error')[0].style.setProperty('display', 'none');
					this.$('success')[0].style.setProperty('display', 'block');
					this.$('content')[0].style.setProperty('display', 'none');
				})
				.catch(error => {
					console.log(error.message);
					remove(this.el);
					this.$('form')[0].classList.add('is-error');

					this.$('error')[0].style.setProperty('display', 'block');
					this.$('success')[0].style.setProperty('display', 'none');
					this.$('content')[0].style.setProperty('display', 'none');
				});
		});
	}
}

export default ContactPage;
