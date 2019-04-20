<?php
/**
 * Implements a shortcuts registry
 *
 * @package   Usher\Components
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */
namespace Usher\Components;

use Usher\{Util\Registry};

/**
 * Sets up a registry for global and screen-specific keyboard shortcuts.
 *
 * @since 1.0.0
 */
class Shortcut_Registry extends \Usher\Util\Registry {

	/**
	 * Registry instance.
	 *
	 * @since 1.0.0
	 * @var   Shortcut_Registry
	 */
	private static $instance;

	/**
	 * Retrieves the one true registry instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Shortcut_Registry Registry instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new Shortcut_Registry();

			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initializes the registry.
	 *
	 * @since 1.0.0
	 */
	public function init() {}

	/**
	 * Registers a new shortcut.
	 *
	 * If multiple screens are defined, a shortcut will be registered for each screen.
	 *
	 * @since 1.0.0
	 * @since 1.0.1 Added support for fully-qualified URLs
	 *
	 * @param string $shortcut_id Shortcut.
	 * @param array  $atts        {
	 *     Shortcut attributes.
	 *
	 *     @type string|array $screen Screen or screens to register the shortcut against.
	 *                                Accepts a single screen ID, 'global', or an array
	 *                                of screen IDs. Default 'global'.
	 *     @type string       $label  Label to display for the shortcut in the dialog.
	 *     @type string       $cap    Capability needed for the destination URL. Ignored if omitted.
	 *     @type string       $url    URL to redirect to upon detection of the shortcut. If there is no scheme,
	 *                                the URL is assumed to be relative to wp-admin/.
	 * }
	 */
	public function register_shortcut( $shortcut, $atts = array() ) {
		// Shortcut.
		$atts['shortcut'] = $shortcut;

		// Screen(s).
		if ( ! empty( $atts['screen'] ) ) {
			if ( ! is_array( $atts['screen'] ) ) {
				$atts['screen'] = array( $atts['screen'] );
			}

			$atts['screen'] = array_map( 'sanitize_key', $atts['screen'] );
		} else {
			$atts['screen'] = array( 'global' );
		}

		// Description.
		if ( empty( $atts['label'] ) ) {
			$atts['label'] = __( 'No description.', 'usher' );
		}

		// Capability.
		if ( ! empty( $atts['cap'] ) ) {
			$atts['cap'] = sanitize_key( $atts['cap'] );
		}

		// URL.
		if ( ! empty( $atts['url'] ) ) {
			if ( false !== strpos( $atts['url'], 'http' ) ) {
				$atts['url'] = esc_url( $atts['url'] );
			} else {
				$atts['url'] = admin_url( $atts['url'] );
			}
		}

		// Register the shortcut(s).
		foreach ( $atts['screen'] as $screen ) {
			$shortcut_id = md5( $shortcut );
			$shortcut_id = "{$screen}:{$shortcut_id}";

			parent::add_item( $shortcut_id, $atts );
		}

		return true;
	}
}

