<?php
/**
 * Utilitaire admin — télécharge des photos stock (Unsplash) et les attache
 * aux membres de l'équipe pédagogique. One-shot.
 *
 * Déclencheur : visiter n'importe quelle URL admin avec ?tcro_fetch_stock=1
 *
 * Les photos sont réutilisables (licence Unsplash).
 * Skippe les membres qui ont déjà une image mise en avant.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', function () {

	if ( empty( $_GET['tcro_fetch_stock'] ) ) return;
	if ( ! current_user_can( 'manage_options' ) )  return;

	// Étape 1 — Pédagogique : on télécharge les 3 photos Unsplash.
	$pedago = [
		'Julien Morineau' => 'https://images.unsplash.com/photo-1660463530535-b8ba6a79ee37?w=1200&q=80&fm=jpg&auto=format&fit=crop',
		'Céline Bonnin'   => 'https://images.unsplash.com/photo-1712869456131-f20d945004cd?w=1200&q=80&fm=jpg&auto=format&fit=crop',
		'Marvin Geslin'   => 'https://images.unsplash.com/photo-1554484361-e85dcd332855?w=1200&q=80&fm=jpg&auto=format&fit=crop',
	];

	// Étape 2 — Dirigeante : on réutilise les attachments des coachs (pas de re-download).
	$dirigeants_reuse = [
		'Fabien Coulombeau'  => 'Julien Morineau',
		'Brigitte Guibert'   => 'Céline Bonnin',
		'Ghislaine Renaud'   => 'Céline Bonnin',
		'Marc-Alban Gravez'  => 'Marvin Geslin',
		'Nicolas Lécuiller'  => 'Julien Morineau',
	];

	$ok = 0; $skip = 0; $errors = [];
	$attached = []; // name => attachment_id

	// — Pédagogique —
	foreach ( $pedago as $name => $url ) {
		$post_id = tcro_find_membre_by_title( $name );
		if ( ! $post_id ) {
			$errors[] = "Membre introuvable : {$name}";
			continue;
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$attached[ $name ] = (int) get_post_thumbnail_id( $post_id );
			$skip++;
			continue;
		}

		$att_id = tcro_sideload_image_from_url( $url, $post_id, "{$name} — photo stock Unsplash" );
		if ( is_wp_error( $att_id ) ) {
			$errors[] = "{$name} : " . $att_id->get_error_message();
			continue;
		}

		set_post_thumbnail( $post_id, $att_id );
		$attached[ $name ] = $att_id;
		$ok++;
	}

	// — Dirigeante (réutilise les 3 attachments) —
	foreach ( $dirigeants_reuse as $name => $source ) {
		$post_id = tcro_find_membre_by_title( $name );
		if ( ! $post_id ) {
			$errors[] = "Membre introuvable : {$name}";
			continue;
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$skip++;
			continue;
		}

		if ( empty( $attached[ $source ] ) ) {
			$errors[] = "{$name} : photo source ({$source}) indisponible.";
			continue;
		}

		set_post_thumbnail( $post_id, $attached[ $source ] );
		$ok++;
	}

	// — Étape 3 : Articles —
	$articles_photos = [
		'Le TCRO a accueilli l\'équipe de tennis fauteuil pour Paris 2024' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=1600&q=80&fm=jpg&auto=format&fit=crop',
		'La finale de la Coupe de Vendée au TCRO'                           => 'https://images.unsplash.com/photo-1542144582-1ba00456b5e3?w=1600&q=80&fm=jpg&auto=format&fit=crop',
		'Le TMC Femmes du samedi 18 avril'                                  => 'https://images.unsplash.com/flagged/photo-1576972405668-2d020a01cbfa?w=1600&q=80&fm=jpg&auto=format&fit=crop',
		'Le tennis santé au TCRO'                                           => 'https://images.unsplash.com/photo-1499510318569-1a3d67dc3976?w=1600&q=80&fm=jpg&auto=format&fit=crop',
	];

	foreach ( $articles_photos as $title => $url ) {
		$q = new WP_Query( [
			'post_type'      => 'post',
			'title'          => $title,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		] );
		if ( ! $q->have_posts() ) {
			$errors[] = "Article introuvable : {$title}";
			continue;
		}
		$post_id = (int) $q->posts[0];

		if ( has_post_thumbnail( $post_id ) ) {
			$skip++;
			continue;
		}

		$att_id = tcro_sideload_image_from_url( $url, $post_id, "{$title} — photo stock Unsplash" );
		if ( is_wp_error( $att_id ) ) {
			$errors[] = "{$title} : " . $att_id->get_error_message();
			continue;
		}

		set_post_thumbnail( $post_id, $att_id );
		$ok++;
	}

	set_transient( 'tcro_stock_notice', [ 'ok' => $ok, 'skip' => $skip, 'errors' => $errors ], 60 );
	wp_safe_redirect( remove_query_arg( 'tcro_fetch_stock' ) );
	exit;
}, 30 );

function tcro_find_membre_by_title( string $name ) : int {
	$q = new WP_Query( [
		'post_type'      => 'tcro_membre',
		'title'          => $name,
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	] );
	return $q->have_posts() ? (int) $q->posts[0] : 0;
}

add_action( 'admin_notices', function () {
	$n = get_transient( 'tcro_stock_notice' );
	if ( ! $n ) return;
	delete_transient( 'tcro_stock_notice' );

	$msg = sprintf(
		'<strong>TC Riez Océan :</strong> %d photo(s) téléchargée(s) et attachée(s). %d déjà présente(s), ignorée(s).',
		intval( $n['ok'] ), intval( $n['skip'] )
	);
	if ( ! empty( $n['errors'] ) ) {
		$msg .= '<br><em>Erreurs :</em> ' . esc_html( implode( ' ; ', $n['errors'] ) );
	}

	$type = empty( $n['errors'] ) ? 'success' : 'warning';
	printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( $type ), $msg );
} );

/**
 * Sideload une URL (Unsplash & co) sans dépendre de l'extension dans l'URL.
 */
function tcro_sideload_image_from_url( string $url, int $post_id, string $desc = '' ) {

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = download_url( $url, 30 );
	if ( is_wp_error( $tmp ) ) {
		return $tmp;
	}

	// On force une extension .jpg puisqu'on a demandé fm=jpg à Unsplash.
	$file_array = [
		'name'     => 'tcro-stock-' . wp_generate_password( 10, false, false ) . '.jpg',
		'tmp_name' => $tmp,
	];

	$att_id = media_handle_sideload( $file_array, $post_id, $desc );

	if ( is_wp_error( $att_id ) ) {
		@unlink( $tmp );
		return $att_id;
	}

	return $att_id;
}
