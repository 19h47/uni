/* global uni */
import { AbstractBlock } from 'starting-blocks';
import Bouncer from 'formbouncerjs';

const { ajax_url: ajaxUrl, nonce, messages } = uni;

const remove = target => target.classList.remove('Form--loading');

/**
 *
 * @constructor
 * @param {object} container
 */
export default class ContactBlock extends AbstractBlock {
	constructor(container) {
		super(container, 'ContactBlock');

		this.bouncer = null;
		this.url = `${ajaxUrl}?action=send_message&nonce=${nonce}`;
	}

	async init() {
		this.initPlugins();

		await super.init();
	}

	initPlugins() {
		this.bouncer = new Bouncer('form.page-block', {
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
	}

	initEvents() {
		super.initEvents();

		document.addEventListener('bouncerFormValid', () => {
			const form = new FormData(this.rootElement);
			this.rootElement.classList.add('is-loading');

			fetch(this.url, {
				method: 'POST',
				body: form,
			})
				.then(() => {
					remove(this.rootElement);
					this.rootElement.classList.remove('is-loading');
					this.rootElement.classList.add('is-success');
				})
				.catch(error => {
					console.log(error.message);
					remove(this.rootElement);
					this.rootElement.classList.add('is-error');
				});
		});
	}
}
