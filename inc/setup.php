<?php
/**
 * Theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'tcro', TCRO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus( [
		'primary' => __( 'Menu principal (header desktop + mobile)', 'tcro' ),
		'footer'  => __( 'Menu footer — colonne « Le club »', 'tcro' ),
	] );
} );

add_filter( 'excerpt_more', fn() => '…' );

/**
 * Force la structure de permaliens à /articles/%postname%/ une seule fois.
 * Une fois exécuté, le flag empêche toute ré-application — l'admin peut alors
 * modifier à sa guise dans Réglages > Permaliens.
 */
add_action( 'init', function () {
	if ( get_option( 'tcro_permalink_initialized' ) ) {
		return;
	}
	update_option( 'permalink_structure', '/articles/%postname%/' );
	flush_rewrite_rules();
	update_option( 'tcro_permalink_initialized', '1' );
}, 100 );

/**
 * Fallback affiché tant qu'aucun menu n'est assigné à l'emplacement
 * « Menu principal » dans Apparence > Menus.
 */
function tcro_primary_menu_fallback( $args ) {
	$items = [
		[ home_url( '/#equipe' ),    'Équipe' ],
		[ home_url( '/#courts' ),    'Terrains' ],
		[ home_url( '/#activites' ), 'Activités' ],
		[ home_url( '/#tarifs' ),    'Tarifs' ],
		[ home_url( '/#agenda' ),    'Agenda' ],
	];
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$items[] = [ get_permalink( $posts_page_id ), 'Actualités' ];
	}

	$menu_class = $args['menu_class'] ?? '';
	echo '<ul class="' . esc_attr( $menu_class ) . '">';
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item[0] ), esc_html( $item[1] ) );
	}
	echo '</ul>';
}

/**
 * Fallback colonne « Le club » du footer.
 */
function tcro_footer_menu_fallback( $args ) {
	$items = [
		[ home_url( '/#about' ),  'Le club' ],
		[ home_url( '/#equipe' ), 'L\'équipe' ],
		[ home_url( '/#courts' ), 'Les terrains' ],
		[ home_url( '/#tarifs' ), 'Tarifs' ],
	];
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$items[] = [ get_permalink( $posts_page_id ), 'Actualités' ];
	}

	$menu_class = $args['menu_class'] ?? '';
	echo '<ul class="' . esc_attr( $menu_class ) . '">';
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item[0] ), esc_html( $item[1] ) );
	}
	echo '</ul>';
}

/**
 * Supprime les emoji scripts WP (on utilise nos propres icônes).
 */
add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
} );

/**
 * Désactive complètement les commentaires sur tout le site.
 */
add_action( 'init', function () {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'post', 'trackbacks' );
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'page', 'trackbacks' );
} );

add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open',    '__return_false', 20, 2 );
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

// Retire le menu "Commentaires" de l'admin et de la barre top.
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );
add_action( 'wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
} );
