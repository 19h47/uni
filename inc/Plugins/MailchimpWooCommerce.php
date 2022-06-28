<?php // phpcs:ignore
/**
 * Mailchimp WooCommerce
 *
 * @package uni
 * @subpackage UNI/Plugins/MailchimpWooCommerce
 */

namespace UNI\Plugins;

/**
 * WordPress
 */
class MailchimpWooCommerce {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'mailchimp_woocommerce_newsletter_field', array( $this, 'newsletter_field' ), 10, 3 );
	}


	/**
	 * Newsletter field
	 *
	 * @param string $checkbox Checkobx.
	 * @param bool   $status Status (default set to true).
	 * @param string $label Newsletter label.
	 *
	 * @see https://github.com/mailchimp/mc-woocommerce/blob/master/includes/class-mailchimp-woocommerce-newsletter.php#L69
	 * @return string $checkbox
	 */
	public function newsletter_field( string $checkbox, bool $status, string $label ) : string {
		$checkbox  = '<p class="m-0 w-100 form-row form-row-wide mailchimp-newsletter Checkbox">';
		$checkbox .= '<label for="mailchimp_woocommerce_newsletter" class="inline d-flex align-items-center woocommerce-form__label woocommerce-form__label-for-checkbox">';
		$checkbox .= '<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="mailchimp_woocommerce_newsletter" type="checkbox" name="mailchimp_woocommerce_newsletter" value="1"' . ( $status ? ' checked="checked"' : '' ) . '>';
		$checkbox .= '&nbsp;<span>' . __( 'Subscribe to our newsletter', 'uni' ) . '</span>';
		$checkbox .= '</label></p>';

		return (string) $checkbox;
	}
}
