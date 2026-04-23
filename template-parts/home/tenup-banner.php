<?php
/**
 * Home — Bandeau Ten'Up.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titre = tcro_option( 'tenup_titre', 'Inscriptions & réservations en ligne' );
$sous  = tcro_option( 'tenup_sous', 'Adhésion, offres de cours, réservation de courts — tout sur Ten\'Up' );
$links = tcro_option( 'tenup_links', [] );
?>

<div style="background:#0A1524; border-top:1px solid rgba(230,51,41,.25); border-bottom:1px solid rgba(230,51,41,.25);">
	<div class="max-w-[1520px] mx-auto px-5 sm:px-8 md:px-16 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
		<div class="flex items-center gap-4">
			<div class="w-10 h-10 rounded-sm bg-primary/20 flex items-center justify-center shrink-0">
				<span class="text-xl">🎾</span>
			</div>
			<div>
				<p class="text-sand font-display font-semibold text-sm"><?php echo esc_html( $titre ); ?></p>
				<p class="text-sand/50 text-xs mt-0.5"><?php echo esc_html( $sous ); ?></p>
			</div>
		</div>
		<?php if ( ! empty( $links ) ) : ?>
		<div class="flex flex-wrap gap-3 shrink-0">
			<?php foreach ( $links as $link ) :
				$cls = ! empty( $link['primary'] )
					? 'bg-primary hover:bg-primary-light text-white'
					: 'border border-sand/20 hover:border-sand/40 text-sand';
			?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener"
					class="<?php echo esc_attr( $cls ); ?> text-[11px] font-medium tracking-widest uppercase px-5 py-2.5 rounded-sm transition-colors">
					<?php echo esc_html( $link['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
