/* global usher_vars */
( function ( $ ) {

	var	Usher = Mousetrap,
		shortcuts = usher_vars.shortcuts;

	// Shortcuts modal.
	$( '#usher-shortcuts' ).dialog( {
		title: usher_vars.title,
		dialogClass: 'usher-dialog',
		autoOpen: false,
		draggable: false,
		width: 'auto',
		modal: true,
		resizeable: false,
		closeOnEscape: true,
		position: {
			my: 'center',
			at: 'center',
			of: window
		},
		open: function() {
			$( '.ui-widget-overlay' ).on( 'click', function( event ) {
				$( '#usher-shortcuts' ).dialog( 'close' );
			} );
		},
		create: function() {
			$( '.ui-dialog-titlebar-close' ).addClass( 'ui-button' );
		}
	} );

	// Help dialog launch.
	Usher.bind( '?', function() {
		$( '#usher-shortcuts' ).dialog( 'open' );
	} );

	$.each( shortcuts.global, bindShortcuts );
	$.each( shortcuts.current_screen, bindShortcuts );

	/**
	 * Binds Usher shortcuts.
	 *
	 * @since 1.0.1
	 *
	 * @param {Integer} i Index.
	 * @param {Object} shortcut Shortcut object.
	 */
	function bindShortcuts( i, shortcut ) {
		Usher.bind( shortcut.combo, function() {
			if ( shortcut.url.length ) {
				window.location.href = shortcut.url;
			}
		} );
	}

} )( jQuery );
