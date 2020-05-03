/* global uni */
import { AbstractBlock } from 'starting-blocks';
import $ from 'jquery';

/**
 *
 * @constructor
 * @param {object} container
 */
export default class AddToCartBlock extends AbstractBlock {
	constructor(container) {
		// console.info('AddToCartBlock.constructor');

		super(container, 'AddToCartBlock');
	}

	init() {
		super.init();

		this.$wrapper = $('.js-wrapper');

		this.$button = this.rootElement.querySelector('.js-add-to-cart-button');
		this.$quantity = this.rootElement.querySelector('input[name=quantity]');
		this.$productId = this.rootElement.querySelector('input[name=product_id]');
		this.$variantionID = this.rootElement.querySelector('input[name=variation_id]');

		this.value = this.$button.getAttribute('value');
		this.quantity = this.$quantity ? this.querySelector.getAttribute('value') : 1;
		this.productId = this.$productId ? this.$productId.getAttribute('value') : this.value;
		this.variationId = this.$variantionID ? this.$variantionID.getAttribute('value') : 0;
	}

	/**
	 * AddToCartBlock.initEvents
	 */
	initEvents() {
		// console.info('AddToCartBlock.setupEvents');
		super.initEvents();

		this.$button.addEventListener('click', event => {
			event.preventDefault();

			this.fetch();
		});
	}

	fetch() {
		const request = new Request(uni.ajax_url);
		const headers = new Headers({
			'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
		});
		const body = new URLSearchParams({
			action: 'uni_add_to_cart',
			nonce: uni.nonce,
			product_id: this.productId,
			product_sku: '',
			quantity: this.quantity,
			variation_id: this.variationId,
		});

		this.$wrapper.block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6,
			},
		});

		fetch(request, {
			method: 'POST',
			headers,
			body,
		})
			.then(res => res.json())
			.then(response => {
				$(document.body).trigger('added_to_cart', [
					response.fragments,
					response.cart_hash,
					$(this.$button),
				]);

				this.$wrapper.unblock();
			})
			.catch(error => console.log(error.message));
	}
}
