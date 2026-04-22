<?php
/**
 * Enqueue front styles & scripts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$css_rel = '/assets/css/main.css';
	$js_rel  = '/assets/js/main.js';

	$css_ver = file_exists( TCRO_DIR . $css_rel ) ? filemtime( TCRO_DIR . $css_rel ) : TCRO_VERSION;
	$js_ver  = file_exists( TCRO_DIR . $js_rel )  ? filemtime( TCRO_DIR . $js_rel )  : TCRO_VERSION;

	// Google Fonts.
	wp_enqueue_style(
		'tcro-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap',
		[],
		null
	);

	// Tailwind compiled CSS.
	wp_enqueue_style(
		'tcro-main',
		TCRO_URI . $css_rel,
		[ 'tcro-fonts' ],
		$css_ver
	);

	// style.css (obligatoire pour WP, vide côté styles).
	wp_enqueue_style(
		'tcro-style',
		get_stylesheet_uri(),
		[ 'tcro-main' ],
		TCRO_VERSION
	);

	// JS front.
	wp_enqueue_script(
		'tcro-main',
		TCRO_URI . $js_rel,
		[],
		$js_ver,
		true
	);
} );

/**
 * Preconnect Google Fonts pour performance.
 */
add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );
