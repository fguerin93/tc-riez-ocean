<?php
/**
 * Custom Post Types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	/* ─── Équipe ─── */
	register_post_type( 'tcro_membre', [
		'labels'       => [
			'name'               => __( 'Membres de l\'équipe', 'tcro' ),
			'singular_name'      => __( 'Membre', 'tcro' ),
			'add_new'            => __( 'Ajouter', 'tcro' ),
			'add_new_item'       => __( 'Ajouter un membre', 'tcro' ),
			'edit_item'          => __( 'Modifier le membre', 'tcro' ),
			'new_item'           => __( 'Nouveau membre', 'tcro' ),
			'view_item'          => __( 'Voir le membre', 'tcro' ),
			'search_items'       => __( 'Rechercher un membre', 'tcro' ),
			'menu_name'          => __( 'Équipe', 'tcro' ),
		],
		'public'            => false,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_rest'      => false,
		'menu_position'     => 20,
		'menu_icon'         => 'dashicons-groups',
		'supports'          => [ 'title', 'thumbnail', 'page-attributes' ],
		'has_archive'       => false,
		'rewrite'           => false,
		'capability_type'   => 'post',
	] );

	/* ─── Tarifs ─── */
	register_post_type( 'tcro_tarif', [
		'labels'       => [
			'name'               => __( 'Tarifs', 'tcro' ),
			'singular_name'      => __( 'Tarif', 'tcro' ),
			'add_new'            => __( 'Ajouter', 'tcro' ),
			'add_new_item'       => __( 'Ajouter un tarif', 'tcro' ),
			'edit_item'          => __( 'Modifier le tarif', 'tcro' ),
			'new_item'           => __( 'Nouveau tarif', 'tcro' ),
			'view_item'          => __( 'Voir le tarif', 'tcro' ),
			'search_items'       => __( 'Rechercher un tarif', 'tcro' ),
			'menu_name'          => __( 'Tarifs', 'tcro' ),
		],
		'public'            => false,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_rest'      => false,
		'menu_position'     => 21,
		'menu_icon'         => 'dashicons-tickets-alt',
		'supports'          => [ 'title', 'page-attributes' ],
		'has_archive'       => false,
		'rewrite'           => false,
		'capability_type'   => 'post',
	] );

	/* ─── Événements / Agenda ─── */
	register_post_type( 'tcro_evenement', [
		'labels'       => [
			'name'               => __( 'Événements', 'tcro' ),
			'singular_name'      => __( 'Événement', 'tcro' ),
			'add_new'            => __( 'Ajouter', 'tcro' ),
			'add_new_item'       => __( 'Ajouter un événement', 'tcro' ),
			'edit_item'          => __( 'Modifier l\'événement', 'tcro' ),
			'new_item'           => __( 'Nouvel événement', 'tcro' ),
			'view_item'          => __( 'Voir l\'événement', 'tcro' ),
			'search_items'       => __( 'Rechercher un événement', 'tcro' ),
			'menu_name'          => __( 'Agenda', 'tcro' ),
		],
		'public'            => false,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_rest'      => false,
		'menu_position'     => 22,
		'menu_icon'         => 'dashicons-calendar-alt',
		'supports'          => [ 'title', 'page-attributes' ],
		'has_archive'       => false,
		'rewrite'           => false,
		'capability_type'   => 'post',
	] );
} );
