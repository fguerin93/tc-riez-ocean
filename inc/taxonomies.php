<?php
/**
 * Custom taxonomies.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	/* Rôle Équipe (pédagogique / dirigeante) */
	register_taxonomy( 'tcro_role_equipe', [ 'tcro_membre' ], [
		'labels' => [
			'name'          => __( 'Rôles', 'tcro' ),
			'singular_name' => __( 'Rôle', 'tcro' ),
			'menu_name'     => __( 'Rôles', 'tcro' ),
			'all_items'     => __( 'Tous les rôles', 'tcro' ),
			'edit_item'     => __( 'Modifier le rôle', 'tcro' ),
			'add_new_item'  => __( 'Ajouter un rôle', 'tcro' ),
		],
		'hierarchical'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => false,
		'rewrite'           => false,
	] );

	/* Catégorie d'événement (tournoi / interclub / jeunes / autre) */
	register_taxonomy( 'tcro_categorie_evenement', [ 'tcro_evenement' ], [
		'labels' => [
			'name'          => __( 'Catégories d\'événement', 'tcro' ),
			'singular_name' => __( 'Catégorie', 'tcro' ),
			'menu_name'     => __( 'Catégories', 'tcro' ),
		],
		'hierarchical'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => false,
		'rewrite'           => false,
	] );
} );

/**
 * Crée les termes par défaut à l'activation du thème.
 */
add_action( 'after_switch_theme', function () {
	$roles = [
		'pedagogique' => 'Équipe pédagogique',
		'dirigeante'  => 'Équipe dirigeante',
	];
	foreach ( $roles as $slug => $name ) {
		if ( ! term_exists( $slug, 'tcro_role_equipe' ) ) {
			wp_insert_term( $name, 'tcro_role_equipe', [ 'slug' => $slug ] );
		}
	}

	$cats = [
		'tournoi'   => 'Tournoi',
		'interclub' => 'Interclub',
		'jeunes'    => 'Jeunes',
		'autre'     => 'Autre',
	];
	foreach ( $cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'tcro_categorie_evenement' ) ) {
			wp_insert_term( $name, 'tcro_categorie_evenement', [ 'slug' => $slug ] );
		}
	}
} );
