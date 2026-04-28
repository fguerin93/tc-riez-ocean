<?php
/**
 * Card — événement (ligne d'agenda).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$nom        = get_the_title();
$date       = tcro_field( 'date', '' );
$jour_over  = tcro_field( 'jour_texte', '' );
$mois_over  = tcro_field( 'mois_texte', '' );
$sous_titre = tcro_field( 'sous_titre', '' );
$badge      = tcro_field( 'badge', '' );
$lien       = tcro_field( 'lien', '' );
$highlight  = (bool) tcro_field( 'highlight', false );

// Calcul affichage jour/mois.
if ( $jour_over ) {
	$jour = $jour_over;
} elseif ( $date ) {
	$jour = date( 'd', strtotime( $date ) );
} else {
	$jour = '—';
}

if ( $mois_over ) {
	$mois = $mois_over;
} elseif ( $date ) {
	$mois_fr = [ '01'=>'Janv','02'=>'Fév','03'=>'Mars','04'=>'Avr','05'=>'Mai','06'=>'Juin','07'=>'Juil','08'=>'Août','09'=>'Sept','10'=>'Oct','11'=>'Nov','12'=>'Déc' ];
	$mois = $mois_fr[ date( 'm', strtotime( $date ) ) ] ?? '';
} else {
	$mois = '';
}

$tag    = 'div';
$attr   = '';
$cursor = '';
if ( $lien ) {
	$tag    = 'a';
	$attr   = ' href="' . esc_url( $lien ) . '" target="_blank" rel="noopener"';
	$cursor = 'cursor-pointer';
}

$highlight_cls = $highlight ? 'border-primary' : 'border-transparent';
?>
<<?php echo $tag . $attr; ?> class="flex items-center gap-4 px-4 sm:px-6 py-4 bg-white/[.04] hover:bg-white/[.08] border-l-2 <?php echo esc_attr( $highlight_cls ); ?> hover:border-primary transition-all <?php echo esc_attr( $cursor ); ?> no-underline">
	<div class="shrink-0 text-center w-11">
		<div class="font-display font-bold text-primary-light text-xl leading-none"><?php echo esc_html( $jour ); ?></div>
		<?php if ( $mois ) : ?><div class="text-white/40 text-[9px] tracking-widest uppercase"><?php echo esc_html( $mois ); ?></div><?php endif; ?>
	</div>
	<div class="w-px h-8 bg-white/10 shrink-0"></div>
	<div class="flex-1 min-w-0">
		<div class="font-display font-semibold text-white text-sm sm:text-base truncate"><?php echo esc_html( $nom ); ?></div>
		<?php if ( $sous_titre ) : ?><div class="text-white/45 text-xs mt-0.5 truncate"><?php echo esc_html( $sous_titre ); ?></div><?php endif; ?>
	</div>
	<?php if ( $badge ) : ?>
		<span class="hidden sm:block text-[9px] tracking-widest uppercase text-primary-light border border-primary px-2 py-1 shrink-0"><?php echo esc_html( $badge ); ?></span>
	<?php endif; ?>
</<?php echo $tag; ?>>
