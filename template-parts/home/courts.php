<?php
/**
 * Home — Terrains / Courts.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'courts_kicker', 'Nos infrastructures' );
$titre     = tcro_option( 'courts_titre', '12 courts,' );
$titre_em  = tcro_option( 'courts_titre_em', 'toutes saisons' );
$items     = tcro_option( 'courts_items', [] );
$feat_tag  = tcro_option( 'featured_tag', 'Court Central' );
$feat_nom  = tcro_option( 'featured_nom', 'Court Philippe Chatrier' );
$feat_desc = tcro_option( 'featured_desc', '' );
$recap     = tcro_option( 'recap', [] );
?>

<section id="courts" class="bg-ocean py-20 md:py-28">
	<div class="max-w-6xl mx-auto px-5 sm:px-8 md:px-12">

		<div class="mb-10 reveal">
			<?php if ( $kicker ) : ?>
			<p class="flex items-center gap-2.5 text-primary-light text-[11px] tracking-[.2em] uppercase font-medium mb-3">
				<span class="w-5 h-px bg-primary-light"></span><?php echo esc_html( $kicker ); ?>
			</p>
			<?php endif; ?>
			<h2 class="font-display font-bold text-sand leading-tight" style="font-size:clamp(26px,4vw,48px)">
				<?php echo esc_html( $titre ); ?><?php if ( $titre_em ) : ?><br><em class="text-primary-light"><?php echo esc_html( $titre_em ); ?></em><?php endif; ?>
			</h2>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-3 gap-0.5 reveal">
			<?php foreach ( $items as $item ) :
				$c1 = $item['color1'] ?? '#B8261F';
				$c2 = $item['color2'] ?? '#E63329';
			?>
			<div class="group relative overflow-hidden cursor-pointer" style="aspect-ratio:3/2">
				<div class="absolute inset-0 transition-transform duration-500 group-hover:scale-105" style="background:linear-gradient(145deg,<?php echo esc_attr( $c1 ); ?>,<?php echo esc_attr( $c2 ); ?> 50%,<?php echo esc_attr( $c1 ); ?>)"></div>
				<div class="absolute inset-[12%] border border-sand/10 pointer-events-none"></div>
				<div class="absolute inset-0 flex flex-col justify-end p-5 md:p-7" style="background:linear-gradient(to top,rgba(10,21,36,.85),transparent 55%)">
					<?php if ( ! empty( $item['sous_titre'] ) ) : ?><p class="text-sand/70 text-[10px] tracking-[.2em] uppercase mb-1"><?php echo esc_html( $item['sous_titre'] ); ?></p><?php endif; ?>
					<h3 class="font-display font-bold text-sand text-xl md:text-2xl mb-1.5"><?php echo esc_html( $item['nom'] ?? '' ); ?></h3>
					<?php if ( ! empty( $item['description'] ) ) : ?><p class="text-sand/60 text-sm leading-relaxed hidden sm:block"><?php echo esc_html( $item['description'] ); ?></p><?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<!-- Featured + récap -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-0.5 mt-0.5 reveal">
			<div class="md:col-span-2 group relative overflow-hidden cursor-pointer min-h-48 md:min-h-64">
				<div class="absolute inset-0 transition-transform duration-500 group-hover:scale-[1.03]" style="background:linear-gradient(120deg,#B8261F,#E63329 40%,#8C1A14)"></div>
				<div class="absolute inset-3 md:inset-5 border border-sand/10 pointer-events-none"></div>
				<div class="absolute inset-0 flex flex-col justify-end p-5 md:p-10" style="background:linear-gradient(to top,rgba(10,21,36,.8),transparent 50%)">
					<?php if ( $feat_tag ) : ?><span class="inline-block bg-accent text-ink text-[10px] font-semibold tracking-[.15em] uppercase px-3 py-1 mb-2 self-start"><?php echo esc_html( $feat_tag ); ?></span><?php endif; ?>
					<h3 class="font-display font-bold text-sand text-xl md:text-3xl mb-1"><?php echo esc_html( $feat_nom ); ?></h3>
					<?php if ( $feat_desc ) : ?><p class="text-sand/60 text-sm hidden sm:block"><?php echo esc_html( $feat_desc ); ?></p><?php endif; ?>
				</div>
			</div>

			<?php if ( ! empty( $recap ) ) : ?>
			<div class="bg-sand/[.04] border-t md:border-t-0 md:border-l border-sand/[.07] p-5 md:p-8 grid grid-cols-2 md:grid-cols-1 gap-4 md:gap-6">
				<?php foreach ( $recap as $r ) : ?>
					<div>
						<p class="text-sand/35 text-[10px] tracking-widest uppercase mb-1"><?php echo esc_html( $r['label'] ); ?></p>
						<p class="font-display font-semibold text-sand"><?php echo esc_html( $r['valeur'] ); ?></p>
						<?php if ( ! empty( $r['detail'] ) ) : ?><p class="text-sand/45 text-xs"><?php echo wp_kses( $r['detail'], [ 'a' => [ 'href' => [], 'target' => [], 'class' => [] ] ] ); ?></p><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
