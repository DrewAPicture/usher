<?php
/**
 * Usher core functions
 *
 * @package   Usher\Functions
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */
namespace Usher;

use Usher\{Components\Shortcut_Registry, Core\Interfaces};

/**
 * Short-hand helper to initialize an aspect of the bootstrap.
 *
 * @since 1.0.0
 *
 * @param Interfaces\Loader $object Object to initialize.
 * @return mixed Result of the bootstrap initialization, usually an object.
 */
function load( $object ) {
	if ( $object instanceof Interfaces\Loader ) {
		return $object->load();
	}
}

/**
 * Retrieves a registry instance.
 *
 * @since 1.0.0
 *
 * @param string $registry Registry ID.
 * @return Shortcut_Registry Registry instance.
 */
function get_registry( $registry = '' ) {
	switch ( $registry ) {
		case 'shortcuts':
		default:
			$registry = Shortcut_Registry::instance();
			break;
	}

	return $registry;
}

/**
 * Registers a short
 * @param string $shortcut Keyboard shortcut.
 * @param array  $atts     {
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
 * @return true Always true.
 */
function register_shortcut( $shortcut, $atts ) {
	return get_registry()->register_shortcut( $shortcut, $atts );
}