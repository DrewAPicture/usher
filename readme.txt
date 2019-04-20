=== Usher ===
Contributors: DrewAPicture
Tags: keyboard, shortcuts, navigation, admin
Requires at least: 5.0
Requires PHP: 7.0
Tested up to: 5.1.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds keyboard shortcuts for navigating around the WordPress admin.

== Description ==

Usher brings Gmail-like keyboard shortcuts for navigating around the various core pages of the WordPress admin.

Additionally, it includes a robust API for registering new global and screen-specific keyboard shortcuts.

To register new shortcuts, use the Usher\register_shortcut() function. For example:

*Add a shortcut for the EDD Dashboard*
`
Usher\register_shortcut( 'g d', array(
    'label' => __( 'Navigate to the EDD dashboard', 'textdomain' ),
    'url'   => 'edit.php?post_type=download',
    'cap'   => 'manage_shop_settings'
) );
`
*Add a shortcut for the Jetpack Dashboard*
`
Usher\register_shortcut( 'g j', array(
    'label' => __( 'Navigate to the Jetpack dashboard', 'textdomain' ),
    'url'   => 'admin.php?page=jetpack',
    'cap'   => 'manage_options',
) );
`

== Screenshots ==

1. Shortcuts panel (activated with '?').

== Changelog ==

= 1.0.1 =
* New: Shortcuts can now be registered with fully-qualified URLs
* Tweak: Updated the Plugins, Updates, and Network Admin screen shortcuts to two letters because of the unreliability of three-letter shortcuts
* Fix: Ensure shortcuts targeted for the current screen get properly bound to the Usher JS object

= 1.0 =
* Initial Release