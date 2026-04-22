<?php
/**
 * Card — tarif / formule.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$prefix    = tcro_field( 'prefix', 'Formule' );
$nom       = get_the_title();
$prix      = tcro_field( 'prix' );
$periode   = tcro_field( 'periode', 'par saison' );
$cible     = tcro_field( 'cible', '' );
$features  = tcro_field( 'features', [] );
$populaire = (bool) tcro_field( 'populaire', false );
$cta_label = tcro_field( 'cta_label', 'Voir les offres sur Ten\'Up' );
$cta_url   = tcro_field( 'cta_url', 'https://tenup.fft.fr/club/61850433/offres' );

if ( $populaire ) : ?>
	<div class="relative bg-primary p-7 md:p-10 order-first md:order-none">
		<span class="absolute -top-px right-6 bg-accent text-ink text-[10px] font-semibold tracking-[.15em] uppercase px-3 py-1.5">⭐ Populaire</span>
		<p class="text-white/55 text-[10px] tracking-[.2em] uppercase mb-2"><?php echo esc_html( $prefix ); ?></p>
		<h3 class="font-display font-bold text-white text-2xl mb-5"><?php echo esc_html( $nom ); ?></h3>
		<?php if ( $prix !== '' && $prix !== null ) : ?>
		<div class="font-display font-black text-white leading-none mb-1" style="font-size:2.8rem"><?php echo esc_html( $prix ); ?><span class="text-base font-light text-white/55"> €</span></div>
		<?php endif; ?>
		<p class="text-white/60 text-xs mb-7"><?php echo esc_html( trim( "{$periode}" . ( $cible ? " · {$cible}" : '' ) ) ); ?></p>
		<div class="w-7 h-px bg-white/25 mb-5"></div>
		<?php if ( ! empty( $features ) ) : ?>
		<ul class="space-y-3">
			<?php foreach ( $features as $i => $f ) :
				$is_last = ( $i === count( $features ) - 1 );
				$border  = $is_last ? '' : 'border-b border-white/15 pb-2.5'; ?>
				<li class="flex items-center gap-2.5 text-sm text-white <?php echo esc_attr( $border ); ?>"><span class="w-1.5 h-1.5 rounded-full bg-white shrink-0"></span><?php echo esc_html( $f['ligne'] ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="mt-7 block text-center text-xs tracking-[.12em] uppercase text-white bg-white/15 hover:bg-white/25 border border-white/30 py-3.5 transition-all"><?php echo esc_html( $cta_label ); ?> →</a>
	</div>
<?php else : ?>
	<div class="border border-sand/[.07] bg-sand/[.03] hover:bg-sand/[.06] transition-colors p-7 md:p-10">
		<p class="text-sand/40 text-[10px] tracking-[.2em] uppercase mb-2"><?php echo esc_html( $prefix ); ?></p>
		<h3 class="font-display font-bold text-sand text-2xl mb-5"><?php echo esc_html( $nom ); ?></h3>
		<?php if ( $prix !== '' && $prix !== null ) : ?>
		<div class="font-display font-black text-sand leading-none mb-1" style="font-size:2.8rem"><?php echo esc_html( $prix ); ?><span class="text-base font-light text-sand/45"> €</span></div>
		<?php endif; ?>
		<p class="text-sand/45 text-xs mb-7"><?php echo esc_html( trim( "{$periode}" . ( $cible ? " · {$cible}" : '' ) ) ); ?></p>
		<div class="w-7 h-px bg-sand/20 mb-5"></div>
		<?php if ( ! empty( $features ) ) : ?>
		<ul class="space-y-3">
			<?php foreach ( $features as $i => $f ) :
				$is_last = ( $i === count( $features ) - 1 );
				$border  = $is_last ? '' : 'border-b border-sand/[.06] pb-2.5'; ?>
				<li class="flex items-center gap-2.5 text-sm text-sand/70 <?php echo esc_attr( $border ); ?>"><span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span><?php echo esc_html( $f['ligne'] ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="mt-7 block text-center text-xs tracking-[.12em] uppercase text-sand border border-sand/20 hover:bg-sand/10 hover:border-sand/45 py-3.5 transition-all"><?php echo esc_html( $cta_label ); ?> →</a>
	</div>
<?php endif;
