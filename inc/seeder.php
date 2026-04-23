<?php
/**
 * Seeder — peuple l'admin avec du contenu par défaut
 * issu du mockup d'origine (TC Riez Océan).
 *
 * Se déclenche une seule fois, au premier chargement admin
 * après activation du thème (gate via option `tcro_seeded_v1`).
 *
 * Pour re-seeder : supprimer l'option via un outil WP, ou ajouter
 * ?tcro_force_seed=1 à n'importe quelle URL admin (admin requis).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const TCRO_SEED_FLAG          = 'tcro_seeded_v1';
const TCRO_SEED_ARTICLES_FLAG = 'tcro_seeded_articles_v1';
const TCRO_SEED_MARQUEE_FLAG  = 'tcro_seeded_marquee_v1';

add_action( 'admin_init', 'tcro_maybe_seed', 20 );

function tcro_maybe_seed() : void {

	$force = current_user_can( 'manage_options' ) && ! empty( $_GET['tcro_force_seed'] );

	if ( ! function_exists( 'update_field' ) ) {
		return; // ACF pas encore chargé.
	}

	// Premier seed complet OU force : on (re)crée tout.
	if ( $force || ! get_option( TCRO_SEED_FLAG ) ) {

		if ( $force ) {
			tcro_cleanup_seeded_posts();
		}

		tcro_seed_options();
		tcro_seed_membres();
		tcro_seed_tarifs();
		tcro_seed_evenements();
		tcro_seed_articles();
		tcro_seed_marquee();

		update_option( TCRO_SEED_FLAG,          time() );
		update_option( TCRO_SEED_ARTICLES_FLAG, time() );
		update_option( TCRO_SEED_MARQUEE_FLAG,  time() );
		set_transient( 'tcro_seeded_notice', 1, 30 );
		return;
	}

	// Ajouts incrémentaux (idempotents — skippent ce qui est déjà en base).
	if ( ! get_option( TCRO_SEED_ARTICLES_FLAG ) ) {
		tcro_seed_articles();
		update_option( TCRO_SEED_ARTICLES_FLAG, time() );
		set_transient( 'tcro_seeded_articles_notice', 1, 30 );
	}
	if ( ! get_option( TCRO_SEED_MARQUEE_FLAG ) ) {
		tcro_seed_marquee();
		update_option( TCRO_SEED_MARQUEE_FLAG, time() );
	}
}

add_action( 'admin_notices', function () {
	if ( get_transient( 'tcro_seeded_notice' ) ) {
		delete_transient( 'tcro_seeded_notice' );
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>TC Riez Océan :</strong> contenus par défaut créés. Tu peux les personnaliser dans <a href="%s">Contenu du site</a>, <a href="%s">Équipe</a>, <a href="%s">Tarifs</a>, <a href="%s">Agenda</a>, <a href="%s">Articles</a>.</p></div>',
			esc_url( admin_url( 'admin.php?page=tcro-options' ) ),
			esc_url( admin_url( 'edit.php?post_type=tcro_membre' ) ),
			esc_url( admin_url( 'edit.php?post_type=tcro_tarif' ) ),
			esc_url( admin_url( 'edit.php?post_type=tcro_evenement' ) ),
			esc_url( admin_url( 'edit.php' ) )
		);
	}
	if ( get_transient( 'tcro_seeded_articles_notice' ) ) {
		delete_transient( 'tcro_seeded_articles_notice' );
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>TC Riez Océan :</strong> 4 articles de démonstration ajoutés. Ajoute les photos via <code>?tcro_fetch_stock=1</code> puis visite la page d\'accueil.</p></div>'
		);
	}
} );

/**
 * Supprime définitivement tous les posts marqués _tcro_seed (force reseed).
 */
function tcro_cleanup_seeded_posts() : void {
	$ids = get_posts( [
		'post_type'      => [ 'tcro_membre', 'tcro_tarif', 'tcro_evenement', 'post' ],
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => [ [ 'key' => '_tcro_seed', 'value' => 1 ] ],
	] );
	foreach ( $ids as $id ) {
		wp_delete_post( $id, true );
	}
}

/* ─────────────────────────────────────────
 *  ACF OPTIONS
 * ───────────────────────────────────────── */
function tcro_seed_options() : void {

	/* HERO */
	update_field( 'hero_kicker',    'Vendée Atlantique · Depuis 1980', 'option' );
	update_field( 'hero_titre',     'TC Riez Océan,', 'option' );
	update_field( 'hero_titre_em',  'le tennis vivant', 'option' );
	update_field( 'hero_sous_titre','Tennis, Pickleball, Tennis Santé : le TC Riez Océan vous accueille à Saint-Hilaire-de-Riez avec 16 courts et une équipe pédagogique diplômée.', 'option' );
	update_field( 'hero_cta1_label','S\'inscrire sur Ten\'Up', 'option' );
	update_field( 'hero_cta1_url',  'https://tenup.fft.fr/club/61850433/offres', 'option' );
	update_field( 'hero_cta2_label','Découvrir le club', 'option' );
	update_field( 'hero_cta2_url',  '#activites', 'option' );
	update_field( 'hero_annee',     '1980', 'option' );
	update_field( 'hero_stats', [
		[ 'valeur' => '12',  'label' => 'Courts' ],
		[ 'valeur' => '218', 'label' => 'Licenciés' ],
		[ 'valeur' => '12',  'label' => 'Équipes' ],
	], 'option' );

	/* ABOUT */
	update_field( 'about_kicker',       'Le club', 'option' );
	update_field( 'about_titre',        'TC Riez Océan', 'option' );
	update_field( 'about_titre_suite',  'le club de la côte vendéenne', 'option' );
	update_field( 'about_texte', "<p>Depuis 1980, le TCRO est un club dynamique implanté au cœur de Saint-Hilaire-de-Riez. Avec 12 courts — 2 en terre battue, 4 en salle et 6 extérieurs — et 218 licenciés, il propose tennis, pickleball et tennis santé dans une ambiance conviviale et chaleureuse.</p>\n<p>Affilié à la Fédération Française de Tennis, notre équipe pédagogique diplômée d'État — Julien Morineau (Directeur Sportif), Céline Bonnin et Marvin Geslin — accompagne tous les profils, du débutant au compétiteur confirmé.</p>", 'option' );
	update_field( 'about_badges', [
		[ 'icone' => '🏅', 'texte' => 'Club Espoir FFT' ],
		[ 'icone' => '❤️', 'texte' => 'Label Tennis Santé' ],
		[ 'icone' => '♿', 'texte' => 'Club Handisport' ],
	], 'option' );
	update_field( 'about_annee',     '1980', 'option' );
	update_field( 'about_cta_label', 'Rejoindre le club', 'option' );
	update_field( 'about_cta_url',   'https://tenup.fft.fr/club/61850433/offres', 'option' );

	/* ÉQUIPE (intro) */
	update_field( 'equipe_kicker',   'Notre équipe', 'option' );
	update_field( 'equipe_titre',    'Les visages', 'option' );
	update_field( 'equipe_titre_em', 'du TCRO', 'option' );

	/* COURTS */
	update_field( 'courts_kicker',   'Nos infrastructures', 'option' );
	update_field( 'courts_titre',    '12 courts,', 'option' );
	update_field( 'courts_titre_em', 'toutes saisons', 'option' );
	update_field( 'courts_items', [
		[ 'sous_titre' => 'Extérieur · 2 courts', 'nom' => 'Terre battue',    'description' => '2 courts en terre battue extérieurs, surface traditionnelle.', 'color1' => '#B8261F', 'color2' => '#E63329' ],
		[ 'sous_titre' => 'Extérieur · 6 courts', 'nom' => 'Résine & Béton',  'description' => '4 courts résine + 2 courts béton en plein air.',              'color1' => '#1B2F47', 'color2' => '#2D4769' ],
		[ 'sous_titre' => 'Intérieur · 4 courts', 'nom' => 'Couverts',        'description' => '2 courts résine + 2 courts béton — ouverts 12 mois/an.',     'color1' => '#0E1B2E', 'color2' => '#3A4556' ],
	], 'option' );
	update_field( 'featured_tag',  'Court Central', 'option' );
	update_field( 'featured_nom',  'Court Philippe Chatrier', 'option' );
	update_field( 'featured_desc', 'Scène des finales du Tournoi Interne et des rencontres par équipes.', 'option' );
	update_field( 'recap', [
		[ 'label' => 'Terre battue', 'valeur' => '2 courts ext.', 'detail' => 'Surface traditionnelle' ],
		[ 'label' => 'Extérieur',    'valeur' => '6 courts',      'detail' => '4 résine · 2 béton' ],
		[ 'label' => 'Intérieur',    'valeur' => '4 courts',      'detail' => '2 résine · 2 béton' ],
		[ 'label' => 'Réservation',  'valeur' => 'Via Ten\'Up',   'detail' => '<a href="https://tenup.fft.fr/club/61850433" target="_blank" class="text-primary-light underline">tenup.fft.fr</a>' ],
	], 'option' );

	/* ACTIVITÉS */
	update_field( 'activites_kicker',   'Nos activités', 'option' );
	update_field( 'activites_titre',    'Six activités pour', 'option' );
	update_field( 'activites_titre_em', 'tous les profils', 'option' );
	update_field( 'activites_items', [
		[ 'icone' => '🎾', 'titre' => 'École de Tennis',      'description' => 'Cours collectifs et particuliers avec enseignants diplômés d\'État. Progression garantie du débutant au compétiteur.', 'tag' => 'Tous âges' ],
		[ 'icone' => '🏆', 'titre' => 'Loisir & Compétition', 'description' => '12 équipes en championnats par équipes. Tournois homologués FFT et interclubs toute la saison.',                      'tag' => 'Tous niveaux' ],
		[ 'icone' => '❤️', 'titre' => 'Tennis Santé',         'description' => 'Programme labellisé FFT pour les personnes souhaitant pratiquer le tennis dans un objectif de bien-être et de santé.',   'tag' => 'Label FFT' ],
		[ 'icone' => '🏓', 'titre' => 'Pickleball',           'description' => 'Le sport tendance ! Courts dédiés, initiation et cours disponibles pour tous les niveaux.',                              'tag' => 'Nouveauté' ],
		[ 'icone' => '♿', 'titre' => 'Tennis Fauteuil',      'description' => 'Club engagé pour le handisport. Home club de Gaëtan Menguy, para-athlète de haut niveau.',                              'tag' => 'Handisport' ],
		[ 'icone' => '💪', 'titre' => 'Remise en forme',      'description' => 'Activités complémentaires pour améliorer votre condition physique et votre pratique tennistique.',                      'tag' => 'Bien-être' ],
	], 'option' );

	/* TARIFS (intro) */
	update_field( 'tarifs_kicker', 'Adhésion 2024–2025', 'option' );
	update_field( 'tarifs_titre',  'Tarifs & Formules', 'option' );
	update_field( 'tarifs_sous',   'Saison sportive · Septembre à Août', 'option' );
	update_field( 'tarifs_note',   'Tarifs indicatifs', 'option' );

	/* AGENDA (intro) */
	update_field( 'agenda_kicker',    'Agenda', 'option' );
	update_field( 'agenda_titre',     "Prochains\névénements", 'option' );
	update_field( 'agenda_desc',      'Compétitions, tournois, stages et temps forts de la saison vendéenne.', 'option' );
	update_field( 'agenda_cta_label', 'Voir sur Ten\'Up', 'option' );
	update_field( 'agenda_cta_url',   'https://tenup.fft.fr/club/61850433/competitions?type=tournois', 'option' );

	/* CONTACT */
	update_field( 'contact_kicker',    'Contact & Inscription', 'option' );
	update_field( 'contact_titre',     'Nous contacter', 'option' );
	update_field( 'contact_titre_em',  '& nous rejoindre', 'option' );
	update_field( 'contact_intro',     '<p>Inscriptions ouvertes toute l\'année. Pour rejoindre le club ou réserver un cours, vous pouvez aussi passer directement par <a href="https://tenup.fft.fr/club/61850433/offres" target="_blank">Ten\'Up</a>.</p>', 'option' );
	update_field( 'contact_adresse',   '2 rue des Tressange, 85270 Saint-Hilaire-de-Riez', 'option' );
	update_field( 'contact_tel',       '02 51 54 46 81', 'option' );
	update_field( 'contact_email',     'tennisclub.riezocean@orange.fr', 'option' );
	update_field( 'contact_horaires',  "Renseignements par téléphone\nSite web : club.fft.fr/tcriezocean", 'option' );
	update_field( 'contact_qlinks', [
		[ 'icone' => '📋', 'label' => 'Offres',   'sous_label' => '& Tarifs',     'url' => 'https://tenup.fft.fr/club/61850433/offres' ],
		[ 'icone' => '🏆', 'label' => 'Tournois', 'sous_label' => 'Compétitions', 'url' => 'https://tenup.fft.fr/club/61850433/competitions?type=tournois' ],
		[ 'icone' => '👥', 'label' => 'Équipe',   'sous_label' => '& Contact',    'url' => 'https://tenup.fft.fr/club/61850433/equipe' ],
	], 'option' );

	/* TEN'UP BANNER */
	update_field( 'tenup_titre', 'Inscriptions & réservations en ligne', 'option' );
	update_field( 'tenup_sous',  'Adhésion, offres de cours, réservation de courts — tout sur Ten\'Up', 'option' );
	update_field( 'tenup_links', [
		[ 'label' => 'Offres & tarifs', 'url' => 'https://tenup.fft.fr/club/61850433/offres',                        'primary' => true  ],
		[ 'label' => 'Compétitions',    'url' => 'https://tenup.fft.fr/club/61850433/competitions?type=tournois',    'primary' => false ],
		[ 'label' => 'Équipe du club',  'url' => 'https://tenup.fft.fr/club/61850433/equipe',                        'primary' => false ],
	], 'option' );

	/* GLOBAL */
	update_field( 'global_nom',         'TC Riez Océan', 'option' );
	update_field( 'global_sous_nom',    'Saint-Hilaire-de-Riez', 'option' );
	update_field( 'global_tenup',       'https://tenup.fft.fr/club/61850433/offres', 'option' );
	update_field( 'global_footer_desc', 'Tennis, Pickleball & Tennis Santé à Saint-Hilaire-de-Riez depuis 1980.', 'option' );
	update_field( 'global_footer_cols', [
		[ 'titre' => 'Club', 'liens' => [
			[ 'label' => 'Histoire',   'url' => '#about' ],
			[ 'label' => 'Équipe',     'url' => '#equipe' ],
			[ 'label' => 'Terrains',   'url' => '#courts' ],
			[ 'label' => 'Activités',  'url' => '#activites' ],
			[ 'label' => 'Tarifs',     'url' => '#tarifs' ],
		] ],
		[ 'titre' => 'Pratique', 'liens' => [
			[ 'label' => 'Offres Ten\'Up', 'url' => 'https://tenup.fft.fr/club/61850433/offres' ],
			[ 'label' => 'Tournois',       'url' => 'https://tenup.fft.fr/club/61850433/competitions?type=tournois' ],
			[ 'label' => 'Compétitions',   'url' => 'https://tenup.fft.fr/club/61850433/competitions' ],
		] ],
		[ 'titre' => 'Liens', 'liens' => [
			[ 'label' => 'FFT.fr',       'url' => 'https://fft.fr' ],
			[ 'label' => 'Site du club', 'url' => 'http://www.club.fft.fr/tcriezocean' ],
			[ 'label' => 'Contact',      'url' => '#contact' ],
		] ],
	], 'option' );
}

/* ─────────────────────────────────────────
 *  CPT : ÉQUIPE
 * ───────────────────────────────────────── */
function tcro_seed_membres() : void {

	$membres = [
		// Pédagogique
		[ 'nom' => 'Julien Morineau', 'initiales' => 'JM', 'fonction' => 'Directeur Sportif',        'desc' => 'Enseignant diplômé d\'État · Responsable de l\'école de tennis', 'role' => 'pedagogique', 'ordre' => 1 ],
		[ 'nom' => 'Céline Bonnin',   'initiales' => 'CB', 'fonction' => 'Enseignante tous publics', 'desc' => 'Cours collectifs & particuliers · Tous niveaux',                  'role' => 'pedagogique', 'ordre' => 2 ],
		[ 'nom' => 'Marvin Geslin',   'initiales' => 'MG', 'fonction' => 'Enseignant tous publics',  'desc' => 'Cours collectifs & particuliers · Tous niveaux',                  'role' => 'pedagogique', 'ordre' => 3 ],
		// Dirigeante
		[ 'nom' => 'Fabien Coulombeau', 'initiales' => 'FC', 'fonction' => 'Président',          'desc' => '', 'role' => 'dirigeante', 'ordre' => 1 ],
		[ 'nom' => 'Brigitte Guibert',  'initiales' => 'BG', 'fonction' => 'Secrétaire Général', 'desc' => '', 'role' => 'dirigeante', 'ordre' => 2 ],
		[ 'nom' => 'Ghislaine Renaud',  'initiales' => 'GR', 'fonction' => 'Trésorier Général',  'desc' => '', 'role' => 'dirigeante', 'ordre' => 3 ],
		[ 'nom' => 'Marc-Alban Gravez', 'initiales' => 'MG', 'fonction' => 'Vice-Président',     'desc' => '', 'role' => 'dirigeante', 'ordre' => 4 ],
		[ 'nom' => 'Nicolas Lécuiller', 'initiales' => 'NL', 'fonction' => 'Membre',             'desc' => '', 'role' => 'dirigeante', 'ordre' => 5 ],
	];

	foreach ( $membres as $m ) {
		$post_id = wp_insert_post( [
			'post_type'   => 'tcro_membre',
			'post_title'  => $m['nom'],
			'post_status' => 'publish',
			'menu_order'  => $m['ordre'],
			'meta_input'  => [ '_tcro_seed' => 1 ],
		] );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_field( 'initiales',   $m['initiales'], $post_id );
		update_field( 'fonction',    $m['fonction'],  $post_id );
		update_field( 'description', $m['desc'],      $post_id );

		$term = get_term_by( 'slug', $m['role'], 'tcro_role_equipe' );
		if ( $term && ! is_wp_error( $term ) ) {
			wp_set_post_terms( $post_id, [ $term->term_id ], 'tcro_role_equipe' );
		}
	}
}

/* ─────────────────────────────────────────
 *  CPT : TARIFS
 * ───────────────────────────────────────── */
function tcro_seed_tarifs() : void {

	$tarifs = [
		[
			'nom'       => 'Jeune',
			'prix'      => 84,
			'periode'   => 'par saison',
			'cible'     => 'jusqu\'à 18 ans',
			'populaire' => false,
			'features'  => [
				'Accès libre aux courts',
				'Licence FFT incluse',
				'École de Tennis disponible',
				'Championnats jeunes FFT',
			],
			'ordre' => 1,
		],
		[
			'nom'       => 'Adulte',
			'prix'      => 140,
			'periode'   => 'par saison',
			'cible'     => '18 à 64 ans',
			'populaire' => true,
			'features'  => [
				'Accès courts tennis & pickleball',
				'Licence FFT incluse',
				'Cours collectifs & particuliers',
				'Interclubs — 12 équipes',
				'Tennis Santé accessible',
			],
			'ordre' => 2,
		],
		[
			'nom'       => 'Famille & Senior',
			'prix'      => 220,
			'periode'   => 'par saison',
			'cible'     => 'famille ou 65+',
			'populaire' => false,
			'features'  => [
				'Accès courts tennis & pickleball',
				'Licence FFT incluse',
				'Tennis Santé inclus',
				'Cours collectifs disponibles',
				'Remise en forme',
			],
			'ordre' => 3,
		],
	];

	foreach ( $tarifs as $t ) {
		$post_id = wp_insert_post( [
			'post_type'   => 'tcro_tarif',
			'post_title'  => $t['nom'],
			'post_status' => 'publish',
			'menu_order'  => $t['ordre'],
			'meta_input'  => [ '_tcro_seed' => 1 ],
		] );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_field( 'prefix',    'Formule',      $post_id );
		update_field( 'prix',      $t['prix'],     $post_id );
		update_field( 'periode',   $t['periode'],  $post_id );
		update_field( 'cible',     $t['cible'],    $post_id );
		update_field( 'populaire', $t['populaire'],$post_id );
		update_field( 'cta_label', 'Voir les offres sur Ten\'Up', $post_id );
		update_field( 'cta_url',   'https://tenup.fft.fr/club/61850433/offres', $post_id );
		update_field( 'features',  array_map( fn( $ligne ) => [ 'ligne' => $ligne ], $t['features'] ), $post_id );
	}
}

/* ─────────────────────────────────────────
 *  CPT : ÉVÉNEMENTS
 * ───────────────────────────────────────── */
function tcro_seed_evenements() : void {

	$events = [
		[ 'nom' => 'TMC Open d\'Été — Toutes séries', 'jour' => '07', 'mois' => 'Juil',   'sous' => 'Tournoi homologué FFT · 7 au 16 juillet',    'badge' => 'Tournoi',   'ordre' => 1, 'highlight' => true  ],
		[ 'nom' => 'TMC Open Jeunes',                 'jour' => '07', 'mois' => 'Juil',   'sous' => 'Toutes catégories jeunes · 7 au 18 juillet', 'badge' => 'Tournoi',   'ordre' => 2, 'highlight' => false ],
		[ 'nom' => 'Championnat d\'hiver par équipes','jour' => '—',  'mois' => 'Hiver',  'sous' => '12 équipes toutes catégories · Vendée',      'badge' => 'Interclub', 'ordre' => 3, 'highlight' => false ],
		[ 'nom' => 'Championnat d\'été par équipes',  'jour' => '—',  'mois' => 'Été',    'sous' => 'Interclubs · Ligue Pays de la Loire',        'badge' => 'Interclub', 'ordre' => 4, 'highlight' => false ],
		[ 'nom' => 'Tournoi de Tennis Jeunes',        'jour' => '—',  'mois' => 'Annuel', 'sous' => '11/12, 13/14, 15/16, 17/18 ans · Entrée gratuite', 'badge' => 'Jeunes', 'ordre' => 5, 'highlight' => false ],
	];

	foreach ( $events as $e ) {
		$post_id = wp_insert_post( [
			'post_type'   => 'tcro_evenement',
			'post_title'  => $e['nom'],
			'post_status' => 'publish',
			'menu_order'  => $e['ordre'],
			'meta_input'  => [ '_tcro_seed' => 1 ],
		] );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_field( 'jour_texte', $e['jour'],  $post_id );
		update_field( 'mois_texte', $e['mois'],  $post_id );
		update_field( 'sous_titre', $e['sous'],  $post_id );
		update_field( 'badge',      $e['badge'], $post_id );
		update_field( 'highlight',  $e['highlight'], $post_id );
	}
}

/* ─────────────────────────────────────────
 *  ARTICLES (post type `post`)
 * ───────────────────────────────────────── */
function tcro_seed_articles() : void {

	$articles = [
		[
			'titre'    => 'Le TCRO a accueilli l\'équipe de tennis fauteuil pour Paris 2024',
			'cat'      => 'Handisport',
			'date'     => '-120 days',
			'content'  => "<p>En amont des Jeux Paralympiques de Paris 2024, le TC Riez Océan a eu l'honneur d'accueillir une délégation de l'équipe de France de tennis fauteuil pour un stage de préparation de cinq jours.</p>\n\n<p>Les courts couverts du club ont été entièrement privatisés pour permettre aux athlètes de s'entraîner dans des conditions optimales, avec un accompagnement technique et physique de haut niveau. Une rencontre conviviale a été organisée avec les licenciés du club, qui ont pu échanger avec les para-athlètes et assister à une démonstration exceptionnelle.</p>\n\n<h2>Un club engagé pour le handisport</h2>\n\n<p>Labellisé « Club Handisport », le TCRO est le home club de Gaëtan Menguy, para-athlète de haut niveau, et s'investit depuis plusieurs années dans le développement du tennis fauteuil en Vendée. L'accueil de cette équipe nationale s'inscrit dans la continuité de cet engagement.</p>\n\n<p>Fabien Coulombeau, président du club, a tenu à remercier l'ensemble des bénévoles qui ont rendu ce stage possible : « Voir nos courts investis par des champions qui allaient quelques semaines plus tard représenter la France aux JO, c'est une immense fierté pour tout le club. »</p>",
		],
		[
			'titre'    => 'La finale de la Coupe de Vendée au TCRO',
			'cat'      => 'Compétition',
			'date'     => '-85 days',
			'content'  => "<p>Le TC Riez Océan a accueilli le week-end dernier la finale départementale de la Coupe de Vendée. Une journée dense, ensoleillée, et une belle vitrine pour le club devant un public nombreux venu de toute la côte.</p>\n\n<h2>Des matchs serrés jusqu'au bout</h2>\n\n<p>Les équipes du TCRO ont brillamment défendu leurs couleurs face aux clubs voisins. Les finales femmes et hommes se sont jouées en trois sets, avec plusieurs jeux décisifs qui ont tenu les spectateurs en haleine jusqu'au dernier point.</p>\n\n<p>Le Court Philippe Chatrier, court central du club, a vibré tout l'après-midi au rythme des échanges. La cérémonie de remise des prix, organisée en fin de journée, a permis de saluer le niveau technique et l'esprit sportif remarquables des compétiteurs.</p>\n\n<h2>Merci aux bénévoles</h2>\n\n<p>Rien n'aurait été possible sans la mobilisation exceptionnelle des bénévoles du club : arbitrage, accueil, buvette, logistique. Un grand merci à tous les adhérents qui ont donné de leur temps pour faire de cette journée une réussite.</p>",
		],
		[
			'titre'    => 'Le TMC Femmes du samedi 18 avril',
			'cat'      => 'Tournoi',
			'date'     => '-30 days',
			'content'  => "<p>Samedi 18 avril, le TCRO organisait son traditionnel TMC Femmes — Tournoi Multi-Chances réservé aux joueuses classées 40 à 15/2. Une journée 100 % féminine, avec 24 participantes engagées.</p>\n\n<h2>Format et déroulement</h2>\n\n<p>Le TMC permet à chaque joueuse de disputer au minimum trois matchs dans la journée, quel que soit son niveau. Les matchs se sont enchaînés sur nos courts couverts et extérieurs de 9 h à 18 h, dans une ambiance conviviale mais très engagée sur le plan sportif.</p>\n\n<h2>Un moment fort pour le tennis féminin</h2>\n\n<p>Céline Bonnin, enseignante du club, a coordonné l'événement : « C'est toujours un rendez-vous qu'on attend avec impatience. Le TMC donne l'occasion aux joueuses de se rencontrer dans un cadre compétitif sans la pression d'un tournoi classique. On voit de belles progressions match après match. »</p>\n\n<p>Félicitations à toutes les participantes, et rendez-vous pour la prochaine édition cet automne !</p>",
		],
		[
			'titre'    => 'Le tennis santé au TCRO',
			'cat'      => 'Tennis santé',
			'date'     => '-10 days',
			'content'  => "<p>Le TCRO est labellisé « Tennis Santé » par la Fédération Française de Tennis. Ce programme, encore méconnu du grand public, s'adresse aux personnes atteintes de pathologies chroniques ou en phase de rééducation, mais aussi à toute personne souhaitant pratiquer le tennis dans une logique de bien-être et de santé.</p>\n\n<h2>À qui s'adresse le tennis santé ?</h2>\n\n<ul>\n<li>Personnes atteintes de maladies chroniques (diabète, cardiopathies, cancers…)</li>\n<li>Personnes en surpoids ou en reprise d'activité</li>\n<li>Séniors souhaitant préserver leur mobilité et leur équilibre</li>\n<li>Toute personne sur prescription médicale d'activité physique adaptée</li>\n</ul>\n\n<h2>Comment se déroulent les séances ?</h2>\n\n<p>Les séances sont encadrées par nos enseignants diplômés, formés spécifiquement au tennis santé. Elles se déroulent en petits groupes de 4 à 6 personnes, avec un travail progressif et adapté à chacun : déplacements, coordination, renforcement musculaire doux, gestes techniques simplifiés.</p>\n\n<p>Aucun niveau technique n'est requis : le programme est ouvert aux débutants comme aux anciens joueurs. L'objectif n'est pas la performance mais le plaisir de bouger et les bénéfices santé.</p>\n\n<h2>Tarifs et inscription</h2>\n\n<p>Le tennis santé est inclus dans la plupart de nos formules d'adhésion. Pour plus d'informations ou pour vous inscrire, contactez-nous par téléphone au 02 51 54 46 81 ou par email.</p>",
		],
	];

	foreach ( $articles as $a ) {

		// Idempotent : skip si déjà présent.
		$exists = new WP_Query( [
			'post_type'      => 'post',
			'title'          => $a['titre'],
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		] );
		if ( $exists->have_posts() ) {
			continue;
		}

		// Catégorie : crée si absente.
		$cat_id = get_cat_ID( $a['cat'] );
		if ( ! $cat_id ) {
			$cat_id = wp_create_category( $a['cat'] );
		}

		$post_id = wp_insert_post( [
			'post_type'     => 'post',
			'post_title'    => $a['titre'],
			'post_content'  => $a['content'],
			'post_status'   => 'publish',
			'post_category' => $cat_id ? [ $cat_id ] : [],
			'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( $a['date'] ) ),
			'meta_input'    => [ '_tcro_seed' => 1 ],
		] );
	}
}

/* ─────────────────────────────────────────
 *  MARQUEE (bandeau défilant — options)
 * ───────────────────────────────────────── */
function tcro_seed_marquee() : void {

	// Ne pas écraser si l'admin a déjà configuré.
	if ( ! empty( get_field( 'marquee_words', 'option' ) ) ) {
		return;
	}

	update_field( 'marquee_theme', 'light', 'option' );
	update_field( 'marquee_words', [
		[ 'mot' => 'Le tennis vivant' ],
		[ 'mot' => 'Depuis 1980' ],
		[ 'mot' => 'Tennis · Pickleball · Santé' ],
		[ 'mot' => 'Vendée Atlantique' ],
		[ 'mot' => 'TC Riez Océan' ],
	], 'option' );
}
