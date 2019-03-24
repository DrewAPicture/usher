<?php
/**
 * Defines the contract under which Usher loader classes exist
 *
 * @package   Usher\Core\Interfaces
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */
namespace Usher\Core\Interfaces;

/**
 * Loader interface for bootstrapping components.
 *
 * @since 1.0.0
 */
interface Loader {

	/**
	 * Loads the component or class.
	 *
	 * @since 1.0.0
	 */
	public function load();

}
