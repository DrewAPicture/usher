<?php
/**
 * Usher bootstrap
 *
 * @package   Usher\Core
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */

use Usher\{Components, Core, Util};
use function Usher\{load, get_registry};

/**
 * Sets up the Usher plugin.
 *
 * @since 1.0.0
 */
final class Usher {

	/**
	 * Instance.
	 *
	 * @since 1.0.0
	 * @var   \Usher
	 */
	private static $instance;

	/**
	 * Usher loader file path.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	private $file = '';

	/**
	 * Version.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	private $version = '1.0.1';

	/**
	 * Creates an Usher instance.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $file Path to the base plugin file.
	 * @return \Usher Plugin instance.
	 */
	public static function get_instance( $file = '' ) {
		if ( ! empty( $file ) && ! isset( self::$instance ) && ! ( self::$instance instanceof Usher ) ) {
			self::setup_instance( $file );

			self::$instance->constants();
			self::$instance->load();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Sets up the singleton instance.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file Path to the base plugin file.
	 */
	private static function setup_instance( $file ) {
		self::$instance       = new Usher();
		self::$instance->file = $file;
	}

	/**
	 * Defines core constants.
	 *
	 * @since 1.0.0
	 */
	private function constants() {
		// Base plugin file.
		if ( ! defined( 'USHER_PLUGIN_FILE' ) ) {
			define( 'USHER_PLUGIN_FILE', $this->file );
		}

		// Plugin Folder URL.
		if ( ! defined( 'USHER_PLUGIN_URL' ) ) {
			define( 'USHER_PLUGIN_URL', plugin_dir_url( USHER_PLUGIN_FILE ) );
		}

		// Plugin directory.
		if ( ! defined( 'USHER_PLUGIN_DIR' ) ) {
			define( 'USHER_PLUGIN_DIR', plugin_dir_path( USHER_PLUGIN_FILE ) );
		}

		// Version.
		if ( ! defined( 'USHER_VERSION' ) ) {
			define( 'USHER_VERSION', $this->version );
		}
	}

	/**
	 * Loads core files.
	 *
	 * @since 1.0.0
	 */
	private function load() {
		// Autoloader and third-party libraries.
		require_once USHER_PLUGIN_DIR . '/includes/lib/autoload.php';

		// Namespaced functions.
		require_once USHER_PLUGIN_DIR . '/includes/functions.php';
	}

	/**
	 * Setup the bulk of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function setup() {
		// Register the activation hook.
		register_activation_hook( USHER_PLUGIN_FILE, array( $this, 'trigger_hint_notice' ) );

		// Initialize the shortcuts registry.
		$registry = Components\Shortcut_Registry::instance();

		load( new Core\Assets );
		load( new Core\Shortcuts );

		add_action( 'admin_notices', array( $this, 'maybe_display_hint_notice' ) );

		/**
		 * Fires during instantiation of the registry.
		 *
		 * @since 1.0.0
		 *
		 * @param Components\Shortcut_Registry $registry Registry instance.
		 */
		do_action( 'usher_shortcut_registry_init', $registry );

		load( new Core\Render_Dialog );
	}

	/**
	 * Triggers displaying a one-time hint notice to dashboard users.
	 *
	 * @since 1.0.0
	 */
	public function trigger_hint_notice() {
		add_user_meta( get_current_user_id(), 'show-usher-hint-notice', 1 );
	}

	/**
	 * (Maybe) displays a one-time hint notice for dashboard users.
	 *
	 * @since 1.0.0
	 */
	public function maybe_display_hint_notice() {
		$current_user = get_current_user_id();

		if ( get_user_meta( $current_user, 'show-usher-hint-notice' ) ) {
			?>
			<div class="updated notice is-dismissible">
				<p><?php esc_html_e( 'You&#8217;ve successfully activated Usher. Type ? to get started.', 'usher' ); ?></p>
			</div>
			<?php
			delete_user_meta( $current_user, 'show-usher-hint-notice' );
		}
	}

	/**
	 * Prevents cloning.
	 *
	 * @since 1.0.0
	 */
	private function __clone() {}

	/**
	 * Prevents overloading members.
	 *
	 * @since 1.0.0
	 */
	public function __set( $a, $b ) {}

}
