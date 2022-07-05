<?php // phpcs:ignore
/**
 * Send message
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace UNI\Core;

use UNI\Core\{ Mail };
use Timber\{ Timber, Post };

/**
 * Class Send Message
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */
class SendMessage {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_send_message', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_send_message', array( $this, 'ajax' ) );
	}


	/**
	 * Ajax
	 *
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
	 * @access public
	 */
	public function ajax() {
		check_ajax_referer( 'security', 'nonce' );

		$data = isset( $_POST ) ? $_POST : false;

		if ( ! $data ) {
			return;
		}

		$new_post = array(
			'post_title'  => $data['subject'],
			'post_status' => 'publish',
			'post_type'   => 'message',
		);

		$pid = wp_insert_post( $new_post );

		add_post_meta( $pid, 'email', $data['email'], true );
		add_post_meta( $pid, 'interest', $data['interest'], true );
		add_post_meta( $pid, 'subject', $data['subject'], true );
		add_post_meta( $pid, 'you', $data['you'], true );
		add_post_meta( $pid, 'message', $data['message'], true );

		if ( isset( $data['about-us'] ) ) {
			add_post_meta( $pid, 'about-us', $data['about-us'], true );
		}

		// Mail.
		$to[] = $data['email'];

		$headers[] = 'From: UNI <contact@contact@uni-habitat.fr>';
		$headers[] = 'Bcc: ' . get_option( 'admin_email' );

		$context = Timber::context();

		$context['post'] = new Post( $pid );

		Mail::init()
			->to( $to )
			->subject( __( 'UNI: New message', 'uni' ) )
			->message( 'partials/message.html.twig', $context )
			->headers( $headers )
			->send();

		wp_die();
	}
}
