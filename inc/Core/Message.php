<?php // phpcs:ignore
/**
 * Message
 *
 * @package UNI
 */

namespace UNI\Core;

/**
 * Message
 */
class Message {

	/**
	 * Run function
	 *
	 * @access public
	 * @return void
	 */
	public function run() {
		add_action( 'init', array( $this, 'register_post_type' ), 10, 0 );

		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
	}


	/**
	 * Contact updated messages function
	 *
	 * @param array $messages Post updated messages. For defaults see $messages declarations above.
	 * @return array $message
	 * @access public
	 */
	public function updated_messages( array $messages ) : array {
		global $post;

		$post_ID     = isset( $post_ID ) ? (int) $post_ID : 0;
		$preview_url = get_preview_post_link( $post );

		/* translators: Publish box date format, see https://secure.php.net/date */
		$scheduled_date = date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) );

		$view_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'View Message', 'uni' )
		);

		$scheduled_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'Preview Message', 'uni' )
		);

		$preview_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview Message', 'uni' )
		);

		$messages['agency'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Message updated.', 'uni' ) . $view_link_html,
			2  => __( 'Custom field updated.', 'uni' ),
			3  => __( 'Custom field deleted.', 'uni' ),
			4  => __( 'Message updated.', 'uni' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Message restored to revision from %s.', 'uni' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
			6  => __( 'Message published.', 'uni' ) . $view_link_html,
			7  => __( 'Message saved.', 'uni' ),
			8  => __( 'Message submitted.', 'uni' ) . $preview_link_html,
			9  => sprintf( __( 'Message scheduled for: %s.', 'uni' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_link_html, // phpcs:ignore
			10 => __( 'Message draft updated.', 'uni' ) . $preview_link_html,
		);

		return $messages;
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register_post_type() : void {
		$labels = array(
			'name'                     => _x( 'Messages', 'message general name', 'uni' ),
			'singular_name'            => _x( 'Message', 'message singular name', 'uni' ),
			'add_new'                  => _x( 'Add New', 'message', 'uni' ),
			'add_new_item'             => __( 'Add New Messages', 'uni' ),
			'edit_item'                => __( 'Edit Message', 'uni' ),
			'new_item'                 => __( 'New Message', 'uni' ),
			'view_item'                => __( 'View Message', 'uni' ),
			'view_items'               => __( 'View Messages', 'uni' ),
			'search_items'             => __( 'Search Messages', 'uni' ),
			'not_found'                => __( 'No messages found.', 'uni' ),
			'not_found_in_trash'       => __( 'No messages found in Trash.', 'uni' ),
			'parent_item_colon'        => __( 'Parent Message:', 'uni' ),
			'all_items'                => __( 'All messages', 'uni' ),
			'archives'                 => __( 'Message Archives', 'uni' ),
			'attributes'               => __( 'Message Attributes', 'uni' ),
			'insert_into_item'         => __( 'Insert into message', 'uni' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this message', 'uni' ),
			'featured_image'           => _x( 'Featured Image', 'message', 'uni' ),
			'set_featured_image'       => _x( 'Set featured image', 'message', 'uni' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'message', 'uni' ),
			'use_featured_image'       => _x( 'Use as featured image', 'message', 'uni' ),
			'filter_items_list'        => __( 'Filter messages list', 'uni' ),
			'items_list_navigation'    => __( 'Messages list navigation', 'uni' ),
			'items_list'               => __( 'Messages list', 'uni' ),
			'item_published'           => __( 'Message published.', 'uni' ),
			'item_published_privately' => __( 'Message published privately.', 'uni' ),
			'item_reverted_to_draft'   => __( 'Message reverted to draft.', 'uni' ),
			'item_scheduled'           => __( 'Message scheduled.', 'uni' ),
			'item_updated'             => __( 'Message updated.', 'uni' ),
		);

		$args = array(
			'label'               => __( 'Message', 'uni' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'custom-fields' ),
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-email',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'map_meta_cap'        => true,
			'show_in_rest'        => false,
		);
		register_post_type( 'message', $args );
	}
}
