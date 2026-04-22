<?php
/**
 * Champs ACF déclarés en PHP (versionnables).
 *
 * Tous les groupes sont préfixés `tcro_` pour éviter les collisions.
 * Les clés field_* sont stables — ne pas les renommer après mise en prod.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* ─────────────────────────────────────────
	 *  HERO (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_hero',
		'title'  => 'Hero (accueil)',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-hero' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_hero_kicker',     'label'=>'Kicker (petit texte au-dessus)', 'name'=>'hero_kicker', 'type'=>'text', 'default_value'=>'Vendée Atlantique · Depuis 1980' ],
			[ 'key'=>'field_tcro_hero_titre',      'label'=>'Titre', 'name'=>'hero_titre', 'type'=>'textarea', 'rows'=>2, 'default_value'=>'TC Riez Océan,' ],
			[ 'key'=>'field_tcro_hero_titre_em',   'label'=>'Titre (partie colorée)', 'name'=>'hero_titre_em', 'type'=>'text', 'default_value'=>'le tennis vivant' ],
			[ 'key'=>'field_tcro_hero_sous_titre', 'label'=>'Sous-titre', 'name'=>'hero_sous_titre', 'type'=>'textarea', 'rows'=>3, 'default_value'=>'Tennis, Pickleball, Tennis Santé : le TC Riez Océan vous accueille à Saint-Hilaire-de-Riez avec 16 courts et une équipe pédagogique diplômée.' ],
			[ 'key'=>'field_tcro_hero_cta1_label', 'label'=>'CTA principal — texte', 'name'=>'hero_cta1_label', 'type'=>'text', 'default_value'=>'S\'inscrire sur Ten\'Up' ],
			[ 'key'=>'field_tcro_hero_cta1_url',   'label'=>'CTA principal — URL', 'name'=>'hero_cta1_url', 'type'=>'url', 'default_value'=>'https://tenup.fft.fr/club/61850433/offres' ],
			[ 'key'=>'field_tcro_hero_cta2_label', 'label'=>'CTA secondaire — texte', 'name'=>'hero_cta2_label', 'type'=>'text', 'default_value'=>'Découvrir le club' ],
			[ 'key'=>'field_tcro_hero_cta2_url',   'label'=>'CTA secondaire — URL', 'name'=>'hero_cta2_url', 'type'=>'text', 'default_value'=>'#activites' ],
			[ 'key'=>'field_tcro_hero_annee',      'label'=>'Année (watermark)', 'name'=>'hero_annee', 'type'=>'text', 'default_value'=>'1980' ],
			[ 'key'=>'field_tcro_hero_stats',      'label'=>'Statistiques', 'name'=>'hero_stats', 'type'=>'repeater', 'min'=>0, 'max'=>5, 'button_label'=>'Ajouter une stat',
				'sub_fields' => [
					[ 'key'=>'field_tcro_hero_stats_valeur', 'label'=>'Valeur', 'name'=>'valeur', 'type'=>'text' ],
					[ 'key'=>'field_tcro_hero_stats_label',  'label'=>'Label',  'name'=>'label',  'type'=>'text' ],
				],
			],
		],
	] );

	/* ─────────────────────────────────────────
	 *  ABOUT (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_about',
		'title'  => 'À propos',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-about' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_about_kicker',    'label'=>'Kicker', 'name'=>'about_kicker', 'type'=>'text', 'default_value'=>'Le club' ],
			[ 'key'=>'field_tcro_about_titre',     'label'=>'Titre', 'name'=>'about_titre', 'type'=>'text', 'default_value'=>'TC Riez Océan' ],
			[ 'key'=>'field_tcro_about_titre_suite','label'=>'Titre (suite)', 'name'=>'about_titre_suite', 'type'=>'text', 'default_value'=>'le club de la côte vendéenne' ],
			[ 'key'=>'field_tcro_about_texte',     'label'=>'Texte', 'name'=>'about_texte', 'type'=>'wysiwyg', 'tabs'=>'visual', 'toolbar'=>'basic', 'media_upload'=>0 ],
			[ 'key'=>'field_tcro_about_image',     'label'=>'Image', 'name'=>'about_image', 'type'=>'image', 'return_format'=>'array', 'preview_size'=>'medium' ],
			[ 'key'=>'field_tcro_about_badges',    'label'=>'Badges (labels)', 'name'=>'about_badges', 'type'=>'repeater', 'button_label'=>'Ajouter un badge',
				'sub_fields' => [
					[ 'key'=>'field_tcro_about_badges_icone', 'label'=>'Icône (emoji ou ✓)', 'name'=>'icone', 'type'=>'text' ],
					[ 'key'=>'field_tcro_about_badges_texte', 'label'=>'Texte', 'name'=>'texte', 'type'=>'text' ],
				],
			],
			[ 'key'=>'field_tcro_about_annee',     'label'=>'Année fondation', 'name'=>'about_annee', 'type'=>'text', 'default_value'=>'1980' ],
			[ 'key'=>'field_tcro_about_cta_label', 'label'=>'CTA — texte', 'name'=>'about_cta_label', 'type'=>'text', 'default_value'=>'Rejoindre le club' ],
			[ 'key'=>'field_tcro_about_cta_url',   'label'=>'CTA — URL', 'name'=>'about_cta_url', 'type'=>'url', 'default_value'=>'https://tenup.fft.fr/club/61850433/offres' ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  ÉQUIPE (Options — juste intro)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_equipe',
		'title'  => 'Équipe (intro)',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-equipe' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_equipe_kicker', 'label'=>'Kicker', 'name'=>'equipe_kicker', 'type'=>'text', 'default_value'=>'Notre équipe' ],
			[ 'key'=>'field_tcro_equipe_titre',  'label'=>'Titre', 'name'=>'equipe_titre',  'type'=>'text', 'default_value'=>'Les visages' ],
			[ 'key'=>'field_tcro_equipe_titre_em','label'=>'Titre (partie colorée)', 'name'=>'equipe_titre_em', 'type'=>'text', 'default_value'=>'du TCRO' ],
			[ 'key'=>'field_tcro_equipe_note',   'label'=>'Note (sous les membres, optionnel)', 'name'=>'equipe_note', 'type'=>'wysiwyg', 'tabs'=>'visual', 'toolbar'=>'basic', 'media_upload'=>0 ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  COURTS (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_courts',
		'title'  => 'Terrains',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-courts' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_courts_kicker', 'label'=>'Kicker', 'name'=>'courts_kicker', 'type'=>'text', 'default_value'=>'Nos infrastructures' ],
			[ 'key'=>'field_tcro_courts_titre',  'label'=>'Titre', 'name'=>'courts_titre', 'type'=>'text', 'default_value'=>'12 courts,' ],
			[ 'key'=>'field_tcro_courts_titre_em','label'=>'Titre (partie colorée)', 'name'=>'courts_titre_em', 'type'=>'text', 'default_value'=>'toutes saisons' ],
			[ 'key'=>'field_tcro_courts_items', 'label'=>'Types de terrain', 'name'=>'courts_items', 'type'=>'repeater', 'button_label'=>'Ajouter un type',
				'sub_fields' => [
					[ 'key'=>'field_tcro_courts_items_type',   'label'=>'Sous-titre', 'name'=>'sous_titre', 'type'=>'text', 'instructions'=>'Ex. "Extérieur · 2 courts"' ],
					[ 'key'=>'field_tcro_courts_items_nom',    'label'=>'Nom', 'name'=>'nom', 'type'=>'text' ],
					[ 'key'=>'field_tcro_courts_items_desc',   'label'=>'Description', 'name'=>'description', 'type'=>'text' ],
					[ 'key'=>'field_tcro_courts_items_color1', 'label'=>'Couleur début (hex)', 'name'=>'color1', 'type'=>'color_picker', 'default_value'=>'#B8261F' ],
					[ 'key'=>'field_tcro_courts_items_color2', 'label'=>'Couleur fin (hex)',   'name'=>'color2', 'type'=>'color_picker', 'default_value'=>'#E63329' ],
				],
			],
			[ 'key'=>'field_tcro_courts_feat_tag',   'label'=>'Court vedette — badge', 'name'=>'featured_tag', 'type'=>'text', 'default_value'=>'Court Central' ],
			[ 'key'=>'field_tcro_courts_feat_nom',   'label'=>'Court vedette — nom', 'name'=>'featured_nom', 'type'=>'text', 'default_value'=>'Court Philippe Chatrier' ],
			[ 'key'=>'field_tcro_courts_feat_desc',  'label'=>'Court vedette — description', 'name'=>'featured_desc', 'type'=>'text', 'default_value'=>'Scène des finales du Tournoi Interne et des rencontres par équipes.' ],
			[ 'key'=>'field_tcro_courts_recap',      'label'=>'Récapitulatif (encart droit)', 'name'=>'recap', 'type'=>'repeater', 'button_label'=>'Ajouter une ligne',
				'sub_fields' => [
					[ 'key'=>'field_tcro_courts_recap_label',   'label'=>'Label',  'name'=>'label',  'type'=>'text' ],
					[ 'key'=>'field_tcro_courts_recap_valeur',  'label'=>'Valeur', 'name'=>'valeur', 'type'=>'text' ],
					[ 'key'=>'field_tcro_courts_recap_detail',  'label'=>'Détail', 'name'=>'detail', 'type'=>'text' ],
				],
			],
		],
	] );

	/* ─────────────────────────────────────────
	 *  ACTIVITÉS (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_activites',
		'title'  => 'Activités',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-activites' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_activites_kicker', 'label'=>'Kicker', 'name'=>'activites_kicker', 'type'=>'text', 'default_value'=>'Nos activités' ],
			[ 'key'=>'field_tcro_activites_titre',  'label'=>'Titre', 'name'=>'activites_titre', 'type'=>'text', 'default_value'=>'Six activités pour' ],
			[ 'key'=>'field_tcro_activites_titre_em','label'=>'Titre (partie colorée)', 'name'=>'activites_titre_em', 'type'=>'text', 'default_value'=>'tous les profils' ],
			[ 'key'=>'field_tcro_activites_items', 'label'=>'Activités', 'name'=>'activites_items', 'type'=>'repeater', 'button_label'=>'Ajouter une activité',
				'sub_fields' => [
					[ 'key'=>'field_tcro_activites_icone', 'label'=>'Icône (emoji)', 'name'=>'icone', 'type'=>'text' ],
					[ 'key'=>'field_tcro_activites_titre', 'label'=>'Titre', 'name'=>'titre', 'type'=>'text' ],
					[ 'key'=>'field_tcro_activites_desc',  'label'=>'Description', 'name'=>'description', 'type'=>'textarea', 'rows'=>3 ],
					[ 'key'=>'field_tcro_activites_tag',   'label'=>'Tag', 'name'=>'tag', 'type'=>'text' ],
				],
			],
		],
	] );

	/* ─────────────────────────────────────────
	 *  TARIFS (Options — juste intro)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_tarifs',
		'title'  => 'Tarifs (intro)',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-tarifs' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_tarifs_kicker', 'label'=>'Kicker', 'name'=>'tarifs_kicker', 'type'=>'text', 'default_value'=>'Adhésion 2024–2025' ],
			[ 'key'=>'field_tcro_tarifs_titre',  'label'=>'Titre', 'name'=>'tarifs_titre', 'type'=>'text', 'default_value'=>'Tarifs & Formules' ],
			[ 'key'=>'field_tcro_tarifs_sous',   'label'=>'Sous-titre', 'name'=>'tarifs_sous', 'type'=>'text', 'default_value'=>'Saison sportive · Septembre à Août' ],
			[ 'key'=>'field_tcro_tarifs_note',   'label'=>'Note (petit texte)', 'name'=>'tarifs_note', 'type'=>'textarea', 'rows'=>2, 'default_value'=>'Tarifs indicatifs — consultez Ten\'Up pour les offres complètes' ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  AGENDA (Options — juste intro)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_agenda',
		'title'  => 'Agenda (intro)',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-agenda' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_agenda_kicker', 'label'=>'Kicker', 'name'=>'agenda_kicker', 'type'=>'text', 'default_value'=>'Agenda' ],
			[ 'key'=>'field_tcro_agenda_titre',  'label'=>'Titre', 'name'=>'agenda_titre', 'type'=>'text', 'default_value'=>'Prochains\névénements' ],
			[ 'key'=>'field_tcro_agenda_desc',   'label'=>'Description', 'name'=>'agenda_desc', 'type'=>'textarea', 'rows'=>3, 'default_value'=>'Compétitions, tournois, stages et temps forts de la saison vendéenne.' ],
			[ 'key'=>'field_tcro_agenda_cta_label','label'=>'CTA — texte', 'name'=>'agenda_cta_label', 'type'=>'text', 'default_value'=>'Voir sur Ten\'Up' ],
			[ 'key'=>'field_tcro_agenda_cta_url',  'label'=>'CTA — URL', 'name'=>'agenda_cta_url', 'type'=>'url', 'default_value'=>'https://tenup.fft.fr/club/61850433/competitions?type=tournois' ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  CONTACT (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_contact',
		'title'  => 'Contact',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-contact' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_contact_kicker', 'label'=>'Kicker', 'name'=>'contact_kicker', 'type'=>'text', 'default_value'=>'Contact & Inscription' ],
			[ 'key'=>'field_tcro_contact_titre',  'label'=>'Titre', 'name'=>'contact_titre', 'type'=>'text', 'default_value'=>'Nous contacter' ],
			[ 'key'=>'field_tcro_contact_titre_em','label'=>'Titre (partie colorée)', 'name'=>'contact_titre_em', 'type'=>'text', 'default_value'=>'& nous rejoindre' ],
			[ 'key'=>'field_tcro_contact_intro',  'label'=>'Intro', 'name'=>'contact_intro', 'type'=>'wysiwyg', 'tabs'=>'visual', 'toolbar'=>'basic', 'media_upload'=>0 ],
			[ 'key'=>'field_tcro_contact_adresse','label'=>'Adresse', 'name'=>'contact_adresse', 'type'=>'text', 'default_value'=>'2 rue des Tressange, 85270 Saint-Hilaire-de-Riez' ],
			[ 'key'=>'field_tcro_contact_tel',    'label'=>'Téléphone', 'name'=>'contact_tel', 'type'=>'text', 'default_value'=>'02 51 54 46 81' ],
			[ 'key'=>'field_tcro_contact_email',  'label'=>'Email', 'name'=>'contact_email', 'type'=>'email', 'default_value'=>'tennisclub.riezocean@orange.fr' ],
			[ 'key'=>'field_tcro_contact_horaires','label'=>'Horaires', 'name'=>'contact_horaires', 'type'=>'textarea', 'rows'=>3, 'default_value'=>'Renseignements par téléphone' ],
			[ 'key'=>'field_tcro_contact_qlinks', 'label'=>'Quick Links (Ten\'Up)', 'name'=>'contact_qlinks', 'type'=>'repeater', 'button_label'=>'Ajouter un lien',
				'sub_fields' => [
					[ 'key'=>'field_tcro_contact_qlinks_icone', 'label'=>'Icône (emoji)', 'name'=>'icone', 'type'=>'text' ],
					[ 'key'=>'field_tcro_contact_qlinks_label', 'label'=>'Label',         'name'=>'label', 'type'=>'text' ],
					[ 'key'=>'field_tcro_contact_qlinks_sub',   'label'=>'Sous-label',    'name'=>'sous_label', 'type'=>'text' ],
					[ 'key'=>'field_tcro_contact_qlinks_url',   'label'=>'URL',           'name'=>'url', 'type'=>'url' ],
				],
			],
			[ 'key'=>'field_tcro_contact_form_email', 'label'=>'Email de réception (formulaire)', 'name'=>'contact_form_email', 'type'=>'email', 'instructions'=>'Email qui recevra les messages du formulaire.' ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  BANDEAU TEN'UP (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_tenup',
		'title'  => 'Bandeau Ten\'Up',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-tenup' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_tenup_titre', 'label'=>'Titre', 'name'=>'tenup_titre', 'type'=>'text', 'default_value'=>'Inscriptions & réservations en ligne' ],
			[ 'key'=>'field_tcro_tenup_sous',  'label'=>'Sous-titre', 'name'=>'tenup_sous', 'type'=>'text', 'default_value'=>'Adhésion, offres de cours, réservation de courts — tout sur Ten\'Up' ],
			[ 'key'=>'field_tcro_tenup_links', 'label'=>'Liens', 'name'=>'tenup_links', 'type'=>'repeater', 'button_label'=>'Ajouter un lien',
				'sub_fields' => [
					[ 'key'=>'field_tcro_tenup_links_label',   'label'=>'Label', 'name'=>'label', 'type'=>'text' ],
					[ 'key'=>'field_tcro_tenup_links_url',     'label'=>'URL',   'name'=>'url', 'type'=>'url' ],
					[ 'key'=>'field_tcro_tenup_links_primary', 'label'=>'Bouton principal', 'name'=>'primary', 'type'=>'true_false', 'ui'=>1 ],
				],
			],
		],
	] );

	/* ─────────────────────────────────────────
	 *  GLOBAL (Options)
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_global',
		'title'  => 'Réglages globaux',
		'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tcro-global' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_global_logo',      'label'=>'Logo', 'name'=>'global_logo', 'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail' ],
			[ 'key'=>'field_tcro_global_nom',       'label'=>'Nom du club (nav)', 'name'=>'global_nom', 'type'=>'text', 'default_value'=>'TC Riez Océan' ],
			[ 'key'=>'field_tcro_global_sous_nom',  'label'=>'Sous-titre nav', 'name'=>'global_sous_nom', 'type'=>'text', 'default_value'=>'Saint-Hilaire-de-Riez' ],
			[ 'key'=>'field_tcro_global_tenup',     'label'=>'URL Ten\'Up principale', 'name'=>'global_tenup', 'type'=>'url', 'default_value'=>'https://tenup.fft.fr/club/61850433/offres' ],
			[ 'key'=>'field_tcro_global_fb',        'label'=>'Facebook', 'name'=>'global_fb', 'type'=>'url' ],
			[ 'key'=>'field_tcro_global_ig',        'label'=>'Instagram', 'name'=>'global_ig', 'type'=>'url' ],
			[ 'key'=>'field_tcro_global_footer_desc','label'=>'Description footer', 'name'=>'global_footer_desc', 'type'=>'textarea', 'rows'=>2, 'default_value'=>'Tennis, Pickleball & Tennis Santé à Saint-Hilaire-de-Riez depuis 1980.' ],
			[ 'key'=>'field_tcro_global_footer_cols','label'=>'Colonnes footer', 'name'=>'global_footer_cols', 'type'=>'repeater', 'min'=>0, 'max'=>3, 'button_label'=>'Ajouter une colonne',
				'sub_fields' => [
					[ 'key'=>'field_tcro_global_footer_cols_titre', 'label'=>'Titre', 'name'=>'titre', 'type'=>'text' ],
					[ 'key'=>'field_tcro_global_footer_cols_links', 'label'=>'Liens', 'name'=>'liens', 'type'=>'repeater', 'button_label'=>'Ajouter un lien',
						'sub_fields' => [
							[ 'key'=>'field_tcro_global_footer_cols_links_label', 'label'=>'Label', 'name'=>'label', 'type'=>'text' ],
							[ 'key'=>'field_tcro_global_footer_cols_links_url',   'label'=>'URL',   'name'=>'url', 'type'=>'text' ],
						],
					],
				],
			],
		],
	] );

	/* ─────────────────────────────────────────
	 *  CPT : MEMBRE
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_cpt_membre',
		'title'  => 'Détails membre',
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'tcro_membre' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_m_initiales', 'label'=>'Initiales', 'name'=>'initiales', 'type'=>'text', 'instructions'=>'Affichées si pas de photo. Ex : JM' ],
			[ 'key'=>'field_tcro_m_fonction',  'label'=>'Fonction', 'name'=>'fonction', 'type'=>'text', 'instructions'=>'Ex : Directeur Sportif' ],
			[ 'key'=>'field_tcro_m_desc',      'label'=>'Description courte', 'name'=>'description', 'type'=>'textarea', 'rows'=>2 ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  CPT : TARIF
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_cpt_tarif',
		'title'  => 'Détails tarif',
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'tcro_tarif' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_t_prefix',    'label'=>'Pré-titre', 'name'=>'prefix', 'type'=>'text', 'default_value'=>'Formule' ],
			[ 'key'=>'field_tcro_t_prix',      'label'=>'Prix (€)', 'name'=>'prix', 'type'=>'number' ],
			[ 'key'=>'field_tcro_t_periode',   'label'=>'Période', 'name'=>'periode', 'type'=>'text', 'default_value'=>'par saison' ],
			[ 'key'=>'field_tcro_t_cible',     'label'=>'Cible', 'name'=>'cible', 'type'=>'text', 'instructions'=>'Ex : 18 à 64 ans' ],
			[ 'key'=>'field_tcro_t_features',  'label'=>'Caractéristiques', 'name'=>'features', 'type'=>'repeater', 'button_label'=>'Ajouter',
				'sub_fields' => [
					[ 'key'=>'field_tcro_t_features_ligne', 'label'=>'Ligne', 'name'=>'ligne', 'type'=>'text' ],
				],
			],
			[ 'key'=>'field_tcro_t_populaire', 'label'=>'Offre populaire ?', 'name'=>'populaire', 'type'=>'true_false', 'ui'=>1, 'instructions'=>'Affiche le badge « Populaire » et une carte mise en avant.' ],
			[ 'key'=>'field_tcro_t_cta_label', 'label'=>'CTA — texte', 'name'=>'cta_label', 'type'=>'text', 'default_value'=>'Voir les offres sur Ten\'Up' ],
			[ 'key'=>'field_tcro_t_cta_url',   'label'=>'CTA — URL', 'name'=>'cta_url', 'type'=>'url', 'default_value'=>'https://tenup.fft.fr/club/61850433/offres' ],
		],
	] );

	/* ─────────────────────────────────────────
	 *  CPT : ÉVÉNEMENT
	 * ───────────────────────────────────────── */
	acf_add_local_field_group( [
		'key'    => 'group_tcro_cpt_evenement',
		'title'  => 'Détails événement',
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'tcro_evenement' ] ] ],
		'fields' => [
			[ 'key'=>'field_tcro_e_date',       'label'=>'Date (réelle)', 'name'=>'date', 'type'=>'date_picker', 'display_format'=>'d/m/Y', 'return_format'=>'Y-m-d', 'first_day'=>1 ],
			[ 'key'=>'field_tcro_e_jour_txt',   'label'=>'Affichage jour (override)', 'name'=>'jour_texte', 'type'=>'text', 'instructions'=>'Ex : "07" ou "—" si pas de date précise. Si vide, utilise la date ci-dessus.' ],
			[ 'key'=>'field_tcro_e_mois_txt',   'label'=>'Affichage mois (override)', 'name'=>'mois_texte', 'type'=>'text', 'instructions'=>'Ex : "Juil" ou "Hiver" / "Annuel"' ],
			[ 'key'=>'field_tcro_e_sous_titre', 'label'=>'Sous-titre', 'name'=>'sous_titre', 'type'=>'text', 'instructions'=>'Ex : "Tournoi homologué FFT · 7 au 16 juillet"' ],
			[ 'key'=>'field_tcro_e_badge',      'label'=>'Badge (type)', 'name'=>'badge', 'type'=>'text', 'instructions'=>'Ex : "Tournoi", "Interclub", "Jeunes"…' ],
			[ 'key'=>'field_tcro_e_lien',       'label'=>'Lien (optionnel)', 'name'=>'lien', 'type'=>'url' ],
			[ 'key'=>'field_tcro_e_highlight',  'label'=>'Mettre en avant', 'name'=>'highlight', 'type'=>'true_false', 'ui'=>1 ],
		],
	] );

} );
