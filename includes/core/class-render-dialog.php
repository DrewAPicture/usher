<?php
/**
 * Class that handles logic for rendering the Usher shortcuts dialog
 *
 * @package   Usher\Core
 * @copyright Copyright (c) 2019, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */
namespace Usher\Core;

use Usher\Core\Interfaces\Loader;
use function Usher\get_registry;

/**
 * Renders the Usher shortcuts options dialog.
 *
 * @since 1.0.0
 */
class Render_Dialog implements Loader {

	/**
	 * Parsed shortcuts data.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $shortcuts = array();

	/**
	 * Handles loading hook callbacks for rendering the dialog.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		add_action( 'current_screen',        array( $this, 'set_shortcuts_data' ), 11 );
		add_action( 'admin_head',            array( $this, 'render_dialog'      ), 12 );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets'     ), 11 );
	}

	/**
	 * Renders the HTML markup for the shortcuts dialog.
	 */
	public function render_dialog() {
		$shortcuts = $this->get_shortcuts_data();

		if ( empty( $shortcuts ) ) {
			return;
		}
		?>
		<div id="usher-shortcuts" class="hidden" style="min-width:500px;">
			<?php if ( ! empty( $shortcuts['global'] ) ) : ?>
				<h4><?php esc_html_e( 'Global Shortcuts', 'usher' ); ?></h4>

				<?php foreach ( $shortcuts['global'] as $shortcut ) : ?>
					<p style="display:block"><code><?php echo $shortcut['combo']; ?></code> <?php echo $shortcut['label']; ?></p>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if ( ! empty( $shortcuts['current_screen'] ) ) : ?>
				<h4><?php esc_html_e( 'Other Shortcuts', 'usher' ); ?></h4>

				<?php foreach ( $shortcuts['current_screen'] as $shortcut ) : ?>
					<p style="display:block"><code><?php echo $shortcut['combo']; ?></code> <?php echo $shortcut['label']; ?></p>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Retrieves the parsed shortcuts data.
	 *
	 * @since 1.0.0
	 *
	 * @return array Shortcuts data.
	 */
	public function get_shortcuts_data() {
		return $this->shortcuts;
	}

	/**
	 * Parses and sets the shortcuts data from the registry based on the current screen.
	 *
	 * @since 1.0.0
	 */
	public function set_shortcuts_data() {
		$records = get_registry( 'shortcuts' )->get_items();

		$current_screen = \get_current_screen()->id;

		foreach ( $records as $id => $atts ) {
			// Skip it if the current user doesn't have requisite permissions.
			if ( ! empty( $atts['cap'] ) && ! current_user_can( $atts['cap'] ) ) {
				continue;
			}

			$id_parts = explode( ':', $id );

			if ( empty( $id_parts[0] ) ) {
				continue;
			} else {
				$screen = $id_parts[0];

				// Only retrieve shortcuts that are global and for the current screen.
				if ( ! in_array( $screen, array( 'global', $current_screen ), true ) ) {
					continue;
				}

			}

			// By this point, only global and current screen shortcuts remain.
			foreach ( $atts['screen'] as $screen_id ) {
				if ( $screen_id === $current_screen ) {
					$screen = 'current_screen';
				} else {
					$screen = 'global';
				}

				$this->shortcuts[ $screen ][] = array(
					'combo' => $atts['shortcut'],
					'label' => $atts['label'],
					'url'   => $atts['url'] ?? '',
				);
			}

		}
	}

	/**
	 * Enqueues assets needed to render and style the dialog.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		wp_enqueue_script( 'usher-admin' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );

		wp_localize_script( 'usher-admin', 'usher_vars', array(
			'title'     => __( 'Usher Keyboard Shortcuts', 'usher' ),
			'admin_url' => admin_url(),
			'shortcuts' => $this->get_shortcuts_data(),
			'screen'    => get_current_screen()->id,
		) );
	}
}
