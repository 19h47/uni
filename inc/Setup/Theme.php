<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package uni
 * @subpackage UNI/Setup/Theme
 */

namespace UNI\Setup;

use Timber\{ Timber, Menu };
use Twig\{ TwigFunction };
use UNI\Core\{ SendMessage };

$timber = new Timber();

Timber::$dirname = array( 'views', 'templates', 'dist' );

/**
 * Theme
 */
class Theme {

	/**
	 * The manifest of this theme
	 *
	 * @access private
	 * @var    array
	 */
	private $theme_manifest;


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run() : void {
		$this->theme_manifest = get_theme_manifest();

		new SendMessage();

		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber_context', array( $this, 'add_socials_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_manifest_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_menus_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
	}


	/**
	 * Add to Twig
	 *
	 * @param object $twig Twig environment.
	 * @return object $twig
	 * @access public
	 */
	public function add_to_twig( object $twig ) : object {
		$twig->addFunction(
			new TwigFunction(
				'html_class',
				function ( $args = '' ) {
					return html_class( $args );
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'body_class',
				function ( $args = '' ) {
					return body_class( $args );
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'set_product_global',
				function( $post ) {
					return set_product_global( $post );
				}
			)
		);

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_the_languages',
					function() {
						return pll_the_languages( array( 'raw' => 1 ) );
					}
				)
			);
		}

		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll__',
					function ( string $string ) : string {
						return pll__( $string );
					}
				)
			);
		}

		if ( function_exists( 'sanitize_title' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'sanitize_title',
					function ( string $title, string $fallback_title = '', string $context = 'save' ) : string {
						return sanitize_title( $title, $fallback_title, $context );
					}
				)
			);
		}

		return $twig;
	}


	/**
	 * Add manifest to context
	 *
	 * @param array $context Timber context.
	 */
	public function add_manifest_to_context( array $context ) : array {
		$context['manifest'] = get_theme_manifest();

		return $context;
	}


	/**
	 * Add socials to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 */
	public function add_socials_to_context( array $context ) : array {
		// Share and Socials links.
		$socials = array(
			array(
				'title' => 'Twitter',
				'slug'  => 'twitter',
				'name'  => __( 'Share on Twitter', 'uni' ),
				'link'  => 'https://twitter.com/intent/tweet?url=',
				'url'   => get_option( 'twitter' ),
			),
			array(
				'title' => 'Facebook',
				'slug'  => 'facebook',
				'name'  => __( 'Share on Facebook', 'uni' ),
				'link'  => 'https://www.facebook.com/sharer.php?u=',
				'url'   => get_option( 'facebook' ),
			),
			array(
				'title' => 'YouTube',
				'slug'  => 'youtube',
				'url'   => get_option( 'youtube' ),
			),
			array(
				'title' => 'LinkedIn',
				'slug'  => 'linkedin',
				'name'  => __( 'Share on LinkedIn', 'uni' ),
				'link'  => 'https://www.linkedin.com/sharing/share-offsite/?url=',
				'url'   => get_option( 'linkedin' ),
			),
			array(
				'title' => 'Instagram',
				'slug'  => 'instagram',
				'url'   => get_option( 'instagram' ),
			),
		);

		foreach ( $socials as $social ) {
			if ( ! empty( $social['url'] ) ) {
				$context['socials'][ $social['slug'] ] = $social;
			}
			$context['shares'][ $social['slug'] ] = $social;
		}

		return $context;
	}


	/**
	 * Add menus to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 * @since  1.0.0
	 */
	public function add_menus_to_context( array $context ) : array {
		$menus = get_registered_nav_menus();

		foreach ( $menus as $menu => $value ) {
			$context['menus'][ $menu ] = new Menu( $menu );
		}

		return $context;
	}


	/**
	 * Add to context
	 *
	 * @param array $context Timber context.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function add_to_context( array $context ) : array {
		$context['cart']     = WC()->cart;
		$context['cart_url'] = wc_get_cart_url();

		$context['mailchimp'] = array(
			'url'  => get_option( 'mailchimp_url' ),
			'id'   => get_option( 'mailchimp_id' ),
			'user' => get_option( 'mailchimp_user' ),
		);

		$context['shop_url'] = get_term_link( 26, 'product_cat' );

		$context['objects_page'] = Timber::get_post( get_option( 'objects_page_' . pll_current_language() ) );
		$context['habitat_page'] = Timber::get_post( get_option( 'habitat_page_' . pll_current_language() ) );

		$context['projects_settings'] = array(
			'subtitle' => get_field( 'subtitle', 'projects_settings_' . pll_current_language() ),
			'title'    => get_field( 'title', 'projects_settings_' . pll_current_language() ),
			'content'  => get_field( 'content', 'projects_settings_' . pll_current_language() ),
		);

		return $context;
	}
}
