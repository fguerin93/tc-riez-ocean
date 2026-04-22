<?php
/**
 * Home — Agenda (CPT tcro_evenement).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'agenda_kicker', 'Agenda' );
$titre     = tcro_option( 'agenda_titre', "Prochains\névénements" );
$desc      = tcro_option( 'agenda_desc', '' );
$cta_label = tcro_option( 'agenda_cta_label', 'Voir sur Ten\'Up' );
$cta_url   = tcro_option( 'agenda_cta_url', 'https://tenup.fft.fr/club/61850433/competitions?type=tournois' );

$events = get_posts( [
	'post_type'      => 'tcro_evenement',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
] );
?>

<section id="agenda" class="py-20 md:py-24" style="background:#1B2F47">
	<div class="max-w-6xl mx-auto px-5 sm:px-8 md:px-12">
		<div class="flex flex-col lg:flex-row gap-10 lg:gap-20">

			<div class="lg:w-72 shrink-0 reveal">
				<?php if ( $kicker ) : ?>
				<p class="flex items-center gap-2.5 text-primary-light text-[11px] tracking-[.2em] uppercase font-medium mb-3">
					<span class="w-5 h-px bg-primary-light"></span><?php echo esc_html( $kicker ); ?>
				</p>
				<?php endif; ?>
				<h2 class="font-display font-bold text-sand text-3xl md:text-4xl leading-tight mb-4"><?php echo nl2br( esc_html( $titre ) ); ?></h2>
				<?php if ( $desc ) : ?><p class="text-sand/55 text-sm leading-relaxed mb-7"><?php echo esc_html( $desc ); ?></p><?php endif; ?>
				<?php if ( $cta_label && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="inline-block bg-primary hover:bg-primary-light text-white text-xs font-medium tracking-widest uppercase px-7 py-3.5 rounded-sm transition-all"><?php echo esc_html( $cta_label ); ?> →</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $events ) ) : ?>
			<div class="flex-1 flex flex-col gap-0.5 reveal">
				<?php foreach ( $events as $event ) :
					setup_postdata( $GLOBALS['post'] = $event );
					get_template_part( 'template-parts/cards/evenement' );
				endforeach; wp_reset_postdata(); ?>
			</div>
			<?php else : ?>
				<p class="text-sand/50">Aucun événement pour le moment.</p>
			<?php endif; ?>
		</div>
	</div>
</section>
