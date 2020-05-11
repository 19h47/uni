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
	 * @param string $checkbox
	 * @param bool $status
	 * @param
	 */
	public function newsletter_field( string $checkbox, bool $status, string $label ) : string {
		return (string) str_replace( '<div class="clear"></div>', '', $checkbox );
	}
}

