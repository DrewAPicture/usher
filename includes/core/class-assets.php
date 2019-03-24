<?php
/**
 * Assets management class
 *
 * @package   Usher\Core
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */

namespace Usher\Core;

use Usher\Core\Interfaces\Loader;

/**
 * Core Usher class that handles registering and enqueuing assets.
 *
 * @since 1.0.0
 */
class Assets implements Loader {

	/**
	 * Loads the Assets class hook callbacks.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets'      )     );
	}

	/**
	 * Registers any needed Usher assets for enqueueing later.
	 *
	 * @since 1.0.0
	 */
	public function register_assets() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Mousetrap.
		wp_register_script(
			$handle = 'external-mousetrap',
			$src = USHER_PLUGIN_URL . '/assets/vendor/mousetrap/mousetrap' . $suffix . '.js',
			$deps = array(),
			$version = '1.6.2',
			$footer = true
		);

		// Usher admin JS.
		wp_register_script(
			$handle = 'usher-admin',
			$src = USHER_PLUGIN_URL . '/assets/js/usher-admin' . $suffix . '.js',
			$deps = array( 'external-mousetrap', 'jquery-ui-dialog' ),
			$version = USHER_VERSION,
			$footer = true
		);
	}

}
