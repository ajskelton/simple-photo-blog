/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	/* Blog Title */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	/* Blog Description */
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	/* Index Grid Title */
	wp.customize( 'ajs_spb_index_grid_title', function( value ) {
		value.bind( function( to ) {
			$( '.index-grid-title' ).text( to );
		} );
	} );

	/* Background Color */
	wp.customize( 'ajs_spb_custom_colors[background_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css('background-color', to );
		} );
	} );

	/* Header Background Color */
	wp.customize( 'ajs_spb_custom_colors[header_background_color]', function( value ) {
		value.bind( function( to ) {
			$( '.site-header, .site-footer' ).css( 'background-color', to );
		} );
	} );

	/* Header Text Color */
	wp.customize( 'ajs_spb_custom_colors[header_text_color]', function( value ) {
		value.bind( function( to ) {
			$( '.site-header, .site-header a, .site-footer, .site-footer a, .site-title a, .menu-toggle .menu-toggle-text, .menu.dropdown ul a ' ).css( 'color', to );
		} );
	} );

	/* Text Color */
	wp.customize( 'ajs_spb_custom_colors[text_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css('color', to );
		} );
	} );

	/* Link Color */
	wp.customize( 'ajs_spb_custom_colors[link_color]', function( value ) {
		value.bind( function( to ) {
			$( '.site-content a, .site-content a:active, .site-content a:focus, .site-content a:hover, .site-content a:visited, .entry-title a' ).css('color', to );
		} );
	} );
	
} )( jQuery );