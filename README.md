# Usher

* **Stable: v1.0.0**
* **Requires WP: 5.0**
* **Requires PHP: 7.0**

Usher brings Gmail-like keyboard shortcuts for navigating around the various core pages of the WordPress admin.

Additionally, it includes a robust API for registering new global and screen-specific keyboard shortcuts.

![Shortcuts panel listing shortcuts](http://mr.drewf.us/04e1f15b3e98/Screen%252520Shot%2525202019-03-23%252520at%2525206.37.58%252520PM.png)

To register new shortcuts, use the Usher\register_shortcut() function. For example:

**Add a shortcut for the EDD Dashboard**
```php
Usher\register_shortcut( 'g d', array(
    'label' => __( 'Navigate to the EDD dashboard', 'textdomain' ),
    'url'   => 'edit.php?post_type=download',
    'cap'   => 'manage_shop_settings'
) );
```

**Add a shortcut for the Jetpack Dashboard**
```php
Usher\register_shortcut( 'g j', array(
    'label' => __( 'Navigate to the Jetpack dashboard', 'textdomain' ),
    'url'   => 'admin.php?page=jetpack',
    'cap'   => 'manage_options',
) );
```
