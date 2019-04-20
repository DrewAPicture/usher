<?php
/**
 * Core class that sets up the default global shortcuts
 *
 * @package   Usher\Core
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */
namespace Usher\Core;

use Usher\Components\Shortcut_Registry;
use Usher\Core\Interfaces\Loader;
use function Usher\{register_shortcut};

/**
 * Implements default global Usher shortcuts.
 *
 * @since 1.0.0
 */
class Shortcuts implements Loader {

	/**
	 * Registers the core shortcuts.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		$this->navigation_shortcuts();
	}

	/**
	 * Registers core navigation shortcuts.
	 *
	 * @since 1.0.0
	 */
	public function navigation_shortcuts() {
		// Posts.
		register_shortcut( 'g b', array(
			'label' => __( 'Navigate to the Posts screen', 'usher' ),
			'url'   => 'edit.php',
			'cap'   => 'edit_posts',
		) );

		// Pages.
		register_shortcut( 'g p', array(
			'label' => __( 'Navigate to the Pages screen', 'usher' ),
			'url'   => 'edit.php?post_type=page',
			'cap'   => 'edit_pages',
		) );

		// Comments.
		register_shortcut( 'g c', array(
			'label' => __( 'Navigate to the Comments screen', 'usher' ),
			'url'   => 'edit-comments.php',
			'cap'   => 'moderate_comments',
		) );

		// Media.
		register_shortcut( 'g m', array(
			'label' => __( 'Navigate to the Media screen', 'usher' ),
			'url'   => 'upload.php',
			'cap'   => 'upload_files',
		) );

		// Plugins.
		register_shortcut( 'p l', array(
			'label' => __( 'Navigate to the Plugins screen', 'usher' ),
			'url'   => 'plugins.php',
			'cap'   => 'manage_plugins',
		) );

		// Users.
		register_shortcut( 'g u', array(
			'label' => __( 'Navigate to the Users screen', 'usher' ),
			'url'   => 'users.php',
			'cap'   => 'list_users',
		) );

		// Settings.
		register_shortcut( 'g s', array(
			'label' => __( 'Navigate to the site settings screen', 'usher' ),
			'url'   => 'options-general.php',
			'cap'   => 'manage_options',
		) );

		// Updates.
		register_shortcut( 'u p', array(
			'label' => __( 'Navigate to the Updates screen', 'usher' ),
			'url'   => 'update-core.php',
			'cap'   => 'update_core',
		) );

		if ( is_multisite() ) {
			register_shortcut( 'g n', array(
				'label' => __( 'Navigate to the Network Admin', 'usher' ),
				'url'   => 'network',
				'cap'   => 'manage_network_options',
			) );
		}
	}

}
