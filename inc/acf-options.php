<?php
/**
 * Page d'options ACF.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page( [
		'page_title' => 'Contenu du site',
		'menu_title' => 'Contenu du site',
		'menu_slug'  => 'tcro-options',
		'capability' => 'edit_posts',
		'icon_url'   => 'dashicons-layout',
		'position'   => 2,
		'redirect'   => true,
	] );

	$sub_pages = [
		'tcro-hero'       => [ 'Accueil — Hero',         'Hero' ],
		'tcro-about'      => [ 'Accueil — À propos',     'À propos' ],
		'tcro-courts'     => [ 'Accueil — Terrains',     'Terrains' ],
		'tcro-activites'  => [ 'Accueil — Activités',    'Activités' ],
		'tcro-tarifs'     => [ 'Accueil — Tarifs',       'Tarifs' ],
		'tcro-agenda'     => [ 'Accueil — Agenda',       'Agenda' ],
		'tcro-contact'    => [ 'Accueil — Contact',      'Contact' ],
		'tcro-tenup'      => [ 'Bandeau Ten\'Up',        'Bandeau Ten\'Up' ],
		'tcro-equipe'     => [ 'Accueil — Équipe',       'Équipe' ],
		'tcro-articles'   => [ 'Accueil — Articles',     'Articles (intro)' ],
		'tcro-global'     => [ 'Réglages globaux',       'Global' ],
	];

	foreach ( $sub_pages as $slug => $titles ) {
		acf_add_options_sub_page( [
			'page_title'  => $titles[0],
			'menu_title'  => $titles[1],
			'parent_slug' => 'tcro-options',
			'menu_slug'   => $slug,
		] );
	}
} );
