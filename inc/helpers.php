<?php
/**
 * Helpers utilitaires.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupère un champ ACF avec fallback. Silencieux si ACF n'est pas chargé.
 */
function tcro_field( string $key, $fallback = '', $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}
	$v = get_field( $key, $post_id );
	return ( $v === null || $v === '' || $v === false ) ? $fallback : $v;
}

/**
 * Version Options page du helper.
 */
function tcro_option( string $key, $fallback = '' ) {
	return tcro_field( $key, $fallback, 'option' );
}

/**
 * Rend une URL absolue ou #ancre en toute sécurité.
 */
function tcro_safe_url( $url, $fallback = '#' ) {
	if ( empty( $url ) ) {
		return $fallback;
	}
	if ( str_starts_with( $url, '#' ) || str_starts_with( $url, '/' ) ) {
		return esc_url( $url );
	}
	return esc_url( $url );
}

/**
 * Classe CSS couleur pour un élément.
 */
function tcro_class_attr( array $classes ): string {
	return esc_attr( implode( ' ', array_filter( $classes ) ) );
}
