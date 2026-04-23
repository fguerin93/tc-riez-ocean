<?php
/**
 * Home — À propos.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker      = tcro_option( 'about_kicker', 'Le club' );
$titre       = tcro_option( 'about_titre', 'TC Riez Océan' );
$titre_suite = tcro_option( 'about_titre_suite', 'le club de la côte vendéenne' );
$texte       = tcro_option( 'about_texte', '' );
$image       = tcro_option( 'about_image' );
$badges      = tcro_option( 'about_badges', [] );
$annee       = tcro_option( 'about_annee', '1980' );
$cta_label   = tcro_option( 'about_cta_label', 'Rejoindre le club' );
$cta_url     = tcro_option( 'about_cta_url', 'https://tenup.fft.fr/club/61850433/offres' );
?>

<section id="about" class="bg-cream text-ink py-20 md:py-28">
	<div class="max-w-7xl mx-auto px-5 sm:px-8 md:px-16">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-20 items-center reveal">

			<div>
				<?php if ( $kicker ) : ?>
				<p class="flex items-center gap-2.5 text-primary text-[11px] tracking-[.2em] uppercase font-medium mb-4">
					<span class="w-5 h-px bg-primary"></span><?php echo esc_html( $kicker ); ?>
				</p>
				<?php endif; ?>

				<h2 class="font-display font-bold leading-tight mb-6" style="font-size:clamp(26px,4vw,48px)">
					<em class="text-primary"><?php echo esc_html( $titre ); ?></em>,<br><?php echo esc_html( $titre_suite ); ?>
				</h2>

				<?php if ( $texte ) : ?>
					<div class="font-serif font-light text-lg leading-relaxed text-ink/75 mb-8 [&>p]:mb-5 [&>p:last-child]:mb-0">
						<?php echo wp_kses_post( $texte ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $badges ) ) : ?>
				<div class="flex flex-wrap gap-2 mb-6">
					<?php foreach ( $badges as $badge ) : ?>
						<span class="inline-flex items-center gap-1.5 bg-ink/5 border border-ink/15 text-ink text-[10px] tracking-[.12em] uppercase px-3 py-1.5 rounded-sm">
							<?php if ( ! empty( $badge['icone'] ) ) : ?><span><?php echo esc_html( $badge['icone'] ); ?></span><?php endif; ?>
							<?php echo esc_html( $badge['texte'] ); ?>
						</span>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<?php if ( $cta_label && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="inline-block bg-primary hover:bg-primary-dark text-white text-xs font-medium tracking-widest uppercase px-8 py-4 rounded-sm transition-all hover:-translate-y-px"><?php echo esc_html( $cta_label ); ?> →</a>
				<?php endif; ?>
			</div>

			<div class="relative mt-6 lg:mt-0">
				<div class="rounded-sm overflow-hidden relative" style="aspect-ratio:4/3;">
					<?php if ( $image && is_array( $image ) ) : ?>
						<img src="<?php echo esc_url( $image['sizes']['large'] ?? $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'TC Riez Océan' ); ?>" class="w-full h-full object-cover">
						<div class="absolute inset-0 bg-primary/15"></div>
					<?php else : ?>
						<div class="w-full h-full" style="background:linear-gradient(135deg,#B8261F,#E63329 45%,#FF5449 75%,#B8261F)"></div>
					<?php endif; ?>
				</div>
				<div class="absolute -bottom-4 -left-2 sm:-bottom-6 sm:-left-5 bg-ocean px-5 py-4 sm:px-6 sm:py-5 rounded-sm shadow-xl">
					<div class="font-display font-bold text-primary-light leading-none" style="font-size:clamp(1.8rem,4vw,2.6rem)">Depuis</div>
					<div class="font-display font-bold text-primary-light leading-none" style="font-size:clamp(1.8rem,4vw,2.6rem)"><?php echo esc_html( $annee ); ?></div>
					<div class="text-sand/50 text-[10px] tracking-wider uppercase mt-1">Club affilié FFT · Vendée</div>
				</div>
			</div>
		</div>
	</div>
</section>
