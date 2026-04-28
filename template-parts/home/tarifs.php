<?php
/**
 * Home — Tarifs (CPT tcro_tarif).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker = tcro_option( 'tarifs_kicker', 'Adhésion 2024–2025' );
$titre  = tcro_option( 'tarifs_titre', 'Tarifs & Formules' );
$sous   = tcro_option( 'tarifs_sous', 'Saison sportive · Septembre à Août' );
$note   = tcro_option( 'tarifs_note', '' );
$tenup  = tcro_option( 'global_tenup', 'https://tenup.fft.fr/club/61850433/offres' );

$tarifs = get_posts( [
	'post_type'      => 'tcro_tarif',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
] );
?>

<section id="tarifs" class="bg-cream py-20 md:py-28">
	<div class="max-w-7xl mx-auto px-5 sm:px-8 md:px-16">

		<div class="text-center mb-12 reveal">
			<?php if ( $kicker ) : ?>
			<p class="flex items-center justify-center gap-3 text-primary-light text-[11px] tracking-[.2em] uppercase font-medium mb-3">
				<span class="w-5 h-px bg-primary-light"></span><?php echo esc_html( $kicker ); ?><span class="w-5 h-px bg-primary-light"></span>
			</p>
			<?php endif; ?>
			<h2 class="font-display font-bold text-ink mb-2" style="font-size:clamp(26px,4vw,48px)"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous ) : ?><p class="font-serif italic text-ink/45"><?php echo esc_html( $sous ); ?></p><?php endif; ?>
			<?php if ( $note ) : ?>
				<p class="text-ink/35 text-xs mt-2"><?php echo wp_kses( $note, [ 'a' => [ 'href' => [], 'target' => [], 'class' => [] ] ] ); ?> — consultez <a href="<?php echo esc_url( $tenup ); ?>" target="_blank" class="text-primary-light underline">Ten'Up</a> pour les offres complètes</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $tarifs ) ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-0.5 reveal">
			<?php foreach ( $tarifs as $tarif ) :
				setup_postdata( $GLOBALS['post'] = $tarif );
				get_template_part( 'template-parts/cards/tarif' );
			endforeach; wp_reset_postdata(); ?>
		</div>
		<?php else : ?>
			<p class="text-ink/50 text-center">Aucun tarif pour le moment.</p>
		<?php endif; ?>

	</div>
</section>
