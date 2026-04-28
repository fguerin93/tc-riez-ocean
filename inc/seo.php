<?php
/**
 * Open Graph + Twitter Card minimal pour le partage social
 * (Facebook, LinkedIn, WhatsApp, Slack, X, etc.).
 *
 * Logique :
 * - single post / page  → titre + extrait + featured image
 * - home                → nom du site + tagline + image hero ACF
 * - fallback image      → logo du club
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function () {

	$site_name   = get_bloginfo( 'name' );
	$title       = '';
	$description = '';
	$image       = '';
	$url         = '';
	$type        = 'website';

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		$title   = get_the_title( $post_id );
		$url     = get_permalink( $post_id );

		// Description : excerpt manuel sinon début du contenu.
		$excerpt = get_the_excerpt( $post_id );
		if ( ! $excerpt ) {
			$excerpt = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 30, '…' );
		}
		$description = $excerpt;

		if ( has_post_thumbnail( $post_id ) ) {
			$image = get_the_post_thumbnail_url( $post_id, 'large' );
		}

		if ( is_singular( 'post' ) ) {
			$type = 'article';
		}

	} elseif ( is_front_page() ) {
		$title       = $site_name;
		$description = get_bloginfo( 'description' );
		$url         = home_url( '/' );

		if ( function_exists( 'tcro_option' ) ) {
			$hero_image = tcro_option( 'hero_image' );
			if ( $hero_image && is_array( $hero_image ) ) {
				$image = $hero_image['sizes']['large'] ?? $hero_image['url'] ?? '';
			}
		}

	} elseif ( is_home() ) {
		// Page liste des articles.
		$posts_page_id = (int) get_option( 'page_for_posts' );
		$title         = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Toutes les actualités', 'tcro' );
		$description   = get_bloginfo( 'description' );
		$url           = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
	}

	// Fallback image : logo du club.
	if ( ! $image ) {
		if ( function_exists( 'tcro_option' ) ) {
			$logo = tcro_option( 'global_logo' );
			if ( $logo && is_array( $logo ) ) {
				$image = $logo['sizes']['large'] ?? $logo['url'] ?? '';
			}
		}
		if ( ! $image ) {
			$image = TCRO_URI . '/assets/img/logo.jpg';
		}
	}

	if ( ! $title )       { $title       = wp_get_document_title(); }
	if ( ! $description ) { $description = get_bloginfo( 'description' ); }
	if ( ! $url )         { $url         = home_url( add_query_arg( null, null ) ); }

	$desc_clean = wp_strip_all_tags( $description );
	?>
	<meta property="og:locale"      content="<?php echo esc_attr( get_locale() ); ?>">
	<meta property="og:type"        content="<?php echo esc_attr( $type ); ?>">
	<meta property="og:site_name"   content="<?php echo esc_attr( $site_name ); ?>">
	<meta property="og:title"       content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $desc_clean ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( $url ); ?>">
	<?php if ( $image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<?php endif; ?>

	<meta name="twitter:card"        content="summary_large_image">
	<meta name="twitter:title"       content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $desc_clean ); ?>">
	<?php if ( $image ) : ?>
		<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
	<?php endif; ?>

	<meta name="description" content="<?php echo esc_attr( $desc_clean ); ?>">
	<?php
}, 5 );
