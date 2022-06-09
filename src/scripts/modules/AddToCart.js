/* global uni */
import { module as M } from '@19h47/modular';
import $ from 'jquery';

class AddToCart extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: {
				button: 'fetch',
			},
		};
	}

	init() {
		this.$quantity = this.el.querySelector('input[name=quantity]');
		this.$productId = this.el.querySelector('input[name=product_id]');
		this.$variantionID = this.el.querySelector('input[name=variation_id]');

		this.value = this.$('button')[0].getAttribute('value');
		this.quantity = this.$quantity ? this.$quantity.getAttribute('value') : 1;
		this.productId = this.$productId ? this.$productId.getAttribute('value') : this.value;
		this.variationId = this.$variantionID ? this.$variantionID.getAttribute('value') : 0;
	}

	fetch(e) {
		e.preventDefault();

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

		this.call('block', null, 'WrapperPage');

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

				this.call('unblock', null, 'WrapperPage');
			})
			.catch(error => console.log(error.message));
	}
}

export default AddToCart;
