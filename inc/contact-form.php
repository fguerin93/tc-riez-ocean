<?php
/**
 * Handler du formulaire de contact (admin-post.php?action=tcro_contact).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_post_nopriv_tcro_contact', 'tcro_handle_contact' );
add_action( 'admin_post_tcro_contact',        'tcro_handle_contact' );

function tcro_handle_contact() : void {

	// Honeypot
	if ( ! empty( $_POST['website'] ?? '' ) ) {
		wp_safe_redirect( home_url( '/#contact' ) );
		exit;
	}

	if ( ! isset( $_POST['tcro_contact_nonce'] ) || ! wp_verify_nonce( $_POST['tcro_contact_nonce'], 'tcro_contact' ) ) {
		wp_die( 'Nonce invalide.', 403 );
	}

	$prenom  = sanitize_text_field( $_POST['prenom']  ?? '' );
	$nom     = sanitize_text_field( $_POST['nom']     ?? '' );
	$email   = sanitize_email(       $_POST['email']  ?? '' );
	$sujet   = sanitize_text_field( $_POST['sujet']   ?? 'Demande de contact' );
	$message = sanitize_textarea_field( $_POST['message'] ?? '' );

	if ( ! $prenom || ! $nom || ! is_email( $email ) ) {
		wp_safe_redirect( home_url( '/?contact_error=1#contact' ) );
		exit;
	}

	$to = tcro_option( 'contact_form_email' ) ?: tcro_option( 'contact_email' ) ?: get_option( 'admin_email' );

	$subject = sprintf( '[TCRO] %s — %s %s', $sujet, $prenom, $nom );
	$body    = "Prénom : {$prenom}\nNom : {$nom}\nEmail : {$email}\nSujet : {$sujet}\n\nMessage :\n{$message}";
	$headers = [
		'From: ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <no-reply@' . wp_parse_url( home_url(), PHP_URL_HOST ) . '>',
		'Reply-To: ' . $prenom . ' ' . $nom . ' <' . $email . '>',
	];

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( home_url( '/?contact_sent=1#contact' ) );
	exit;
}
