<?php
/**
 * Home — Hero.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'hero_kicker', 'Vendée Atlantique · Depuis 1980' );
$titre     = tcro_option( 'hero_titre', 'TC Riez Océan,' );
$titre_em  = tcro_option( 'hero_titre_em', 'le tennis vivant' );
$sous_t    = tcro_option( 'hero_sous_titre', '' );
$cta1_lbl  = tcro_option( 'hero_cta1_label', 'S\'inscrire sur Ten\'Up' );
$cta1_url  = tcro_option( 'hero_cta1_url', 'https://tenup.fft.fr/club/61850433/offres' );
$cta2_lbl  = tcro_option( 'hero_cta2_label', 'Découvrir le club' );
$cta2_url  = tcro_option( 'hero_cta2_url', '#activites' );
$annee     = tcro_option( 'hero_annee', '1980' );
$stats     = tcro_option( 'hero_stats', [] );
?>

<section class="relative min-h-svh flex flex-col justify-end overflow-hidden">

	<div class="absolute inset-0" style="background:radial-gradient(ellipse 120% 80% at 60% 30%,rgba(230,51,41,.38),transparent 70%),radial-gradient(ellipse 80% 100% at 5% 80%,rgba(27,47,71,.55),transparent 60%),linear-gradient(160deg,#0E1B2E,#1B2F47 35%,#2D4769 55%,#1B2F47 75%,#0A1524)"></div>
	<div class="court-lines absolute inset-0 pointer-events-none"></div>
	<div class="absolute left-0 top-0 bottom-0 w-1" style="background:linear-gradient(to bottom,transparent,#E63329 30%,#FF5449 70%,transparent)"></div>
	<div class="hidden lg:block absolute right-0 top-1/2 -translate-y-1/2 font-display font-black select-none pointer-events-none leading-none" style="font-size:clamp(200px,22vw,340px);color:rgba(248,200,23,.06);letter-spacing:-.02em"><?php echo esc_html( $annee ); ?></div>

	<!-- Content -->
	<div class="relative z-10 px-5 sm:px-8 md:px-14 pb-6 md:pb-16 animate-fade-up">
		<?php if ( $kicker ) : ?>
		<p class="flex items-center gap-3 text-accent text-[11px] tracking-[.2em] uppercase font-medium mb-5">
			<span class="w-7 h-px bg-accent"></span><?php echo esc_html( $kicker ); ?>
		</p>
		<?php endif; ?>

		<h1 class="font-display font-black text-sand leading-none tracking-tight mb-5" style="font-size:clamp(40px,8vw,92px)">
			<?php echo esc_html( $titre ); ?><?php if ( $titre_em ) : ?><br><em class="text-primary-light italic not-italic"><?php echo esc_html( $titre_em ); ?></em><?php endif; ?>
		</h1>

		<?php if ( $sous_t ) : ?>
		<p class="font-serif font-light italic text-sand/65 max-w-md leading-relaxed mb-7" style="font-size:clamp(15px,1.8vw,19px)">
			<?php echo esc_html( $sous_t ); ?>
		</p>
		<?php endif; ?>

		<div class="flex flex-col xs:flex-row items-start gap-4 flex-wrap">
			<?php if ( $cta1_lbl && $cta1_url ) : ?>
				<a href="<?php echo esc_url( $cta1_url ); ?>" target="_blank" rel="noopener" class="bg-primary hover:bg-primary-light text-white text-xs font-medium tracking-widest uppercase px-8 py-4 rounded-sm transition-all hover:-translate-y-px w-full xs:w-auto text-center"><?php echo esc_html( $cta1_lbl ); ?></a>
			<?php endif; ?>
			<?php if ( $cta2_lbl && $cta2_url ) : ?>
				<a href="<?php echo esc_url( $cta2_url ); ?>" class="text-sand text-xs tracking-widest uppercase border-b border-sand/30 hover:border-primary-light hover:text-primary-light pb-0.5 transition-all self-center"><?php echo esc_html( $cta2_lbl ); ?> →</a>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( ! empty( $stats ) ) : ?>
	<!-- Stats -->
	<div class="relative z-10 flex items-center gap-5 sm:gap-10 px-5 sm:px-8 md:px-14 py-6 md:py-10 animate-fade-in" style="background:linear-gradient(to top,rgba(10,21,36,.7),transparent)">
		<?php foreach ( $stats as $i => $stat ) : ?>
			<?php if ( $i > 0 ) : ?><div class="w-px h-9 bg-sand/15"></div><?php endif; ?>
			<div class="text-center">
				<span class="block font-display font-bold text-sand leading-none" style="font-size:clamp(1.6rem,4vw,2.4rem)"><?php echo esc_html( $stat['valeur'] ); ?></span>
				<span class="block text-sand/45 text-[10px] tracking-[.15em] uppercase mt-1"><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</section>
