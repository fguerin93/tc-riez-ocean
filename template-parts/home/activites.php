<?php
/**
 * Home — Activités.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'activites_kicker', 'Nos activités' );
$titre     = tcro_option( 'activites_titre', 'Six activités pour' );
$titre_em  = tcro_option( 'activites_titre_em', 'tous les profils' );
$items     = tcro_option( 'activites_items', [] );
?>

<section id="activites" class="py-20 md:py-28 bg-sand text-ink">
	<div class="max-w-6xl mx-auto px-5 sm:px-8 md:px-12">
		<div class="reveal">
			<?php if ( $kicker ) : ?>
			<p class="flex items-center gap-2.5 text-primary-dark text-[11px] tracking-[.2em] uppercase font-medium mb-3">
				<span class="w-5 h-px bg-primary-dark"></span><?php echo esc_html( $kicker ); ?>
			</p>
			<?php endif; ?>
			<h2 class="font-display font-bold text-ink leading-tight mb-10 md:mb-14" style="font-size:clamp(26px,4vw,48px)">
				<?php echo esc_html( $titre ); ?><?php if ( $titre_em ) : ?><br><em class="text-primary"><?php echo esc_html( $titre_em ); ?></em><?php endif; ?>
			</h2>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 reveal">
			<?php foreach ( $items as $item ) : ?>
			<div class="bg-white/70 border-t-4 border-primary p-6 md:p-8 hover:bg-white hover:-translate-y-1 hover:shadow-md transition-all duration-200">
				<?php if ( ! empty( $item['icone'] ) ) : ?>
				<span class="text-3xl block mb-5"><?php echo esc_html( $item['icone'] ); ?></span>
				<?php endif; ?>
				<h3 class="font-display font-semibold text-ink text-lg mb-2"><?php echo esc_html( $item['titre'] ?? '' ); ?></h3>
				<p class="text-sm leading-relaxed text-ink/70"><?php echo esc_html( $item['description'] ?? '' ); ?></p>
				<?php if ( ! empty( $item['tag'] ) ) : ?>
					<span class="inline-block mt-4 text-[10px] tracking-[.12em] uppercase text-primary border border-primary px-2.5 py-1"><?php echo esc_html( $item['tag'] ); ?></span>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
