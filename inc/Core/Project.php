<?php // phpcs:ignore
/**
 * Class Project
 *
 * @package UNI
 * @subpackage UNI/Core
 */

namespace UNI\Core;

use WP_Post;

/**
 * Project class
 */
class Project {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'css' ) );
		add_action( 'manage_project_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
		add_action( 'save_post_project', array( $this, 'save' ), 10, 3 );

		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_updated_messages' ), 10, 2 );
		add_filter( 'manage_project_posts_columns', array( $this, 'add_custom_columns' ) );
	}


	/**
	 * Save
	 *
	 * @param  int     $post_id The post id.
	 * @param  WP_Post $post    The post object.
	 * @param  bool    $update  Is update or not.
	 * @return void
	 */
	public function save( int $post_id, WP_Post $post, bool $update ) : void {
		if ( function_exists( 'pll_current_language' ) ) {
			delete_transient( 'uni_projects_' . pll_current_language() );
		}
	}


	/**
	 * CSS
	 *
	 * @return bool
	 */
	public function css() : bool {
		global $typenow;

		if ( 'project' !== $typenow ) {
			return false;
		}

		?>
		<style>
			.fixed .column-thumbnail {
				vertical-align: top;
				width: 80px;
			}

			.column-thumbnail a {
				display: block;
			}
			.column-thumbnail a img {
				display: inline-block;
				vertical-align: middle;
				width: 80px;
				height: 80px;
				object-fit: contain;
				object-position: center;
			}
		</style>
		<?php

		return true;
	}


	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 * @return array $new_columns
	 * @link https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 */
	public function add_custom_columns( array $columns ) : array {
		$new_columns = array();

		unset( $columns['date'] );

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['thumbnail'] = __( 'Thumbnail', 'uni' );
			}

			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $column_name The column name.
	 * @param int    $post_id The ID of the post.
	 * @link https://developer.wordpress.org/reference/hooks/manage_post-post_type_posts_custom_column/
	 *
	 * @return void
	 */
	public function render_custom_columns( string $column_name, int $post_id ) : void {
		switch ( $column_name ) {
			case 'thumbnail':
				$images = get_field( 'images', $post_id );
				$html   = '—';

				if ( is_array( $images ) && isset( $images[0] ) ) {
					$html  = '<a href="' . esc_attr( get_edit_post_link( $post_id ) ) . '">';
					$html .= wp_get_attachment_image( $images[0]['ID'], 'thumbnail' );
					$html .= '</a>';

				}

				echo wp_kses_post( $html );

				break;
		}
	}


	/**
	 * Updated messages
	 *
	 * @param array $messages Post updated messages. For defaults see $messages declarations above.
	 * @return array $message
	 * @link https://developer.wordpress.org/reference/hooks/post_updated_messages/
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
			__( 'View Project', 'uni' )
		);

		$scheduled_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'Preview Project', 'uni' )
		);

		$preview_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview Project', 'uni' )
		);

		$messages['partner'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Project updated.', 'uni' ) . $view_link_html,
			2  => __( 'Custom field updated.', 'uni' ),
			3  => __( 'Custom field deleted.', 'uni' ),
			4  => __( 'Project updated.', 'uni' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s.', 'uni' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
			6  => __( 'Project published.', 'uni' ) . $view_link_html,
			7  => __( 'Project saved.', 'uni' ),
			8  => __( 'Project submitted.', 'uni' ) . $preview_link_html,
			9  => sprintf( __( 'Project scheduled for: %s.', 'uni' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_link_html, // phpcs:ignore
			10 => __( 'Project draft updated.', 'uni' ) . $preview_link_html,
		);

		return $messages;
	}


	/**
	 * Bulk updated messages
	 *
	 * @param array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
	 * @param array $bulk_counts Array of item counts for each message, used to build internationalized strings.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/bulk_post_updated_messages/
	 *
	 * @return array $bulk_counts
	 */
	public function bulk_updated_messages( array $bulk_messages, array $bulk_counts ) : array {
		$bulk_messages['project'] = array(
			/* translators: %s: Number of projects. */
			'updated'   => _n( '%s project updated.', '%s projects updated.', $bulk_counts['updated'], 'uni' ),
			'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 project not updated, somebody is editing it.', 'uni' ) :
				/* translators: %s: Number of partners. */
				_n( '%s project not updated, somebody is editing it.', '%s projects not updated, somebody is editing them.', $bulk_counts['locked'], 'uni' ),
			/* translators: %s: Number of partners. */
			'deleted'   => _n( '%s project permanently deleted.', '%s project permanently deleted.', $bulk_counts['deleted'], 'uni' ),
			/* translators: %s: Number of projects.. */
			'trashed'   => _n( '%s project moved to the Trash.', '%s project moved to the Trash.', $bulk_counts['trashed'], 'uni' ),
			/* translators: %s: Number of partners. */
			'untrashed' => _n( '%s project restored from the Trash.', '%s project restored from the Trash.', $bulk_counts['untrashed'], 'uni' ),
		);

		return $bulk_messages;
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Projects', 'project type generale name', 'uni' ),
			'singular_name'            => _x( 'Project', 'project type singular name', 'uni' ),
			'add_new'                  => _x( 'Add New', 'project type', 'uni' ),
			'add_new_item'             => __( 'Add New Project', 'uni' ),
			'edit_item'                => __( 'Edit Project', 'uni' ),
			'new_item'                 => __( 'New Project', 'uni' ),
			'view_items'               => __( 'View Projects', 'uni' ),
			'view_item'                => __( 'View Project', 'uni' ),
			'search_items'             => __( 'Search Projects', 'uni' ),
			'not_found'                => __( 'No projects found.', 'uni' ),
			'not_found_in_trash'       => __( 'No projects found in Trash.', 'uni' ),
			'parent_item_colon'        => __( 'Parent Projet:', 'uni' ),
			'all_items'                => __( 'All Projects', 'uni' ),
			'archives'                 => __( 'Project Archives', 'uni' ),
			'attributes'               => __( 'Project Attributes', 'uni' ),
			'insert_into_item'         => __( 'Insert into project', 'uni' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this project', 'uni' ),
			'featured_image'           => _x( 'Featured Image', 'project', 'uni' ),
			'set_featured_image'       => _x( 'Set featured image', 'project', 'uni' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'project', 'uni' ),
			'use_featured_image'       => _x( 'Use as featured image', 'project', 'uni' ),
			'items_list_navigation'    => __( 'Projects list navigation', 'uni' ),
			'items_list'               => __( 'Projects list', 'uni' ),
			'item_published'           => __( 'Project published.', 'uni' ),
			'item_published_privately' => __( 'Project published privately.', 'uni' ),
			'item_reverted_to_draft'   => __( 'Project reverted to draft.', 'uni' ),
			'item_scheduled'           => __( 'Project scheduled.', 'uni' ),
			'item_updated'             => __( 'Project updated.', 'uni' ),
		);

		$rewrite = array(
			'slug'       => 'projets',
			'with_front' => true,
		);

		$args = array(
			'label'               => __( 'Project', 'uni' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-portfolio',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'show_in_rest'        => true,
		);
		register_post_type( 'project', $args );
	}
}
