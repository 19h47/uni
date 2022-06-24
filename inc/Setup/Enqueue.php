<?php // phpcs:ignore
/**
 * Enqueue
 *
 * @package uni
 */

namespace UNI\Setup;

use WP_Scripts;

/**
 * Enqueue
 */
class Enqueue {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'style_loader_tag', array( $this, 'style_loader_tag' ), 10, 4 );
		add_action( 'wp_head', array( $this, 'preload' ) );
		add_action( 'wp_default_scripts', array( $this, 'default_scripts' ), 10, 1 );
	}


	/**
	 * Default scripts
	 *
	 * @param WP_Scripts $scripts (Required) WP_Scripts object.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_default_scripts/
	 */
	function default_scripts( WP_Scripts $scripts ) {

		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {

			$script = $scripts->registered['jquery'];

			if ( $script->deps ) {
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}


	/**
	 * Enqueue scripts
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue_scripts() : void {
		wp_deregister_script( 'wp-embed' );
		wp_deregister_script( 'wp-mediaelement' );

		wp_deregister_script( 'mailchimp-woocommerce' );

		$deps = array( 'jquery', 'jquery-blockui' );

		if ( isset( get_theme_manifest()['vendors.js'] ) ) {
            wp_register_script( // phpcs:ignore
				get_theme_text_domain() . '-vendors',
				get_template_directory_uri() . '/' . get_theme_manifest()['vendors.js'],
				array(),
				null,
				true
			);
			array_push( $deps, get_theme_text_domain() . '-vendors' );
		}

		wp_register_script( // phpcs:ignore
			get_theme_text_domain() . '-main',
			get_template_directory_uri() . '/' . get_theme_manifest()['main.js'],
			$deps,
			null,
			true
		);

		$data = array(
			'template_directory_uri' => get_template_directory_uri(),
			'base_url'               => site_url(),
			'home_url'               => home_url( '/' ),
			'ajax_url'               => admin_url( 'admin-ajax.php' ),
			'api_url'                => home_url( 'wp-json' ),
			'current_url'            => get_permalink(),
			'nonce'                  => wp_create_nonce( 'security' ),
			'messages'               => array(
				'value_missing' => array(
					'default' => _x( 'Please fill out this field.', 'messages', 'uni' ),
				),
				'type_mismatch' => array(
					'email'   => _x( 'Please enter an email address.', 'messages', 'uni' ),
					'url'     => _x( 'Please enter a URL.', 'messages', 'uni' ),
					'default' => _x( 'Please match the expected format.', 'messages', 'uni' ),
				),
			),
			'text_domain'            => get_theme_text_domain(),
		);

		wp_add_inline_script(
			get_theme_text_domain() . '-main',
			'var ' . get_theme_text_domain() . ' = ' . wp_json_encode(
				$data
			),
			'before',
		);

		wp_enqueue_script( get_theme_text_domain() . '-main' );
	}


	/**
	 * Enqueue styles.
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue_style() : void {

		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'wp-mediaelement' );

		// Add custom fonts, used in the main stylesheet.
		$webfonts = array();
		foreach ( get_webfonts() as $name => $url ) {
			wp_register_style( 'font-' . $name, $url, array(), '1.0.0' );
			$webfonts[] = "font-$name";
		}

		wp_register_style(
			'flickity',
			'//cdnjs.cloudflare.com/ajax/libs/flickity/3.0.0/flickity.min.css',
			array(),
			null
		);

		// Theme stylesheet.
		wp_register_style( // phpcs:ignore
			get_theme_text_domain() . '-main',
			get_template_directory_uri() . '/' . get_theme_manifest()['main.css'],
			$webfonts,
			null
		);

		wp_enqueue_style( get_theme_text_domain() . '-main' );
		wp_enqueue_style( 'flickity' );
	}



	/**
	 * Style Loader Tag
	 *
	 * @param string $html The link tag for the enqueued style.
	 * @param string $handle The style's registered handle.
	 * @param string $href The stylesheet's source URL.
	 * @param string $media The stylesheet's media attribute.
	 *
	 * @return string
	 */
	public function style_loader_tag( string $html, string $handle, string $href, string $media ) : string {
		if ( get_theme_text_domain() . '-main' === $handle ) {
			$html = str_replace( '/>', ' onload="this.media=\'all\'; this.onload=null; this.isLoaded=true" />', $html );
		}

		return $html;
	}


	/**
	 * Preload
	 */
	public function preload() {
		global $wp_scripts, $wp_styles;

		// Scripts.
		foreach ( $wp_scripts->queue as $handle ) {
			$script = $wp_scripts->registered[ $handle ];

			if ( substr( $script->handle, 0, strlen( get_theme_text_domain() ) ) !== get_theme_text_domain() ) {
				continue;
			}

			if ( isset( $script->extra['group'] ) && 1 === $script->extra['group'] ) {
				$href = $script->src . ( $script->ver ? "?ver={$script->ver}" : '' );
				echo '<link rel="preload" as="script" href="' . $href . '">';
			}
		}

		// Styles.
		foreach ( $wp_styles->queue as $handle ) {
			$style = $wp_styles->registered[ $handle ];

			if ( substr( $style->handle, 0, strlen( get_theme_text_domain() ) ) !== get_theme_text_domain() ) {
				continue;
			}

			$href = $style->src . ( $style->ver ? "?ver={$style->ver}" : '' );
			echo '<link rel="preload" as="style" href="' . $href . '">';

		}

		// Fonts.
		foreach ( get_theme_manifest() as $key => $value ) {
			if ( substr( $key, 0, 6 ) === 'fonts/' ) {
				$extension = pathinfo( $key, PATHINFO_EXTENSION );
				$href      = get_template_directory_uri() . '/' . $value;

				echo '<link rel="preload" as="font" href="' . $href . '" type="font/' . $extension . '" crossorigin>';
			}
		}
	}
}
