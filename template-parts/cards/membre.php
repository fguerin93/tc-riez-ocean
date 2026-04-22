<?php
/**
 * Card — membre de l'équipe.
 *
 * @var array $args ['variant' => 'portrait' | 'detail' | 'compact']
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$variant   = $args['variant'] ?? 'detail';
$initiales = tcro_field( 'initiales', '' );
$fonction  = tcro_field( 'fonction',  '' );
$desc      = tcro_field( 'description', '' );
$nom       = get_the_title();
$thumb_id  = get_post_thumbnail_id();
$photo_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';

if ( $variant === 'portrait' ) : ?>
	<div class="group">
		<div class="relative overflow-hidden bg-ocean-mid mb-4" style="aspect-ratio:3/4">
			<?php if ( $photo_url ) : ?>
				<img src="<?php echo esc_url( $photo_url ); ?>"
				     alt="<?php echo esc_attr( $nom ); ?>"
				     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
				     loading="lazy">
			<?php else : ?>
				<div class="w-full h-full flex items-center justify-center"
				     style="background:linear-gradient(145deg,#1B2F47,#2D4769 50%,#0E1B2E)">
					<span class="font-display font-black text-sand/80" style="font-size:clamp(60px,9vw,110px);letter-spacing:-.04em">
						<?php echo esc_html( $initiales ); ?>
					</span>
				</div>
			<?php endif; ?>
			<!-- Petit accent rouge en bas, style réf -->
			<span class="absolute left-0 bottom-0 h-1 w-14 bg-primary transition-all duration-300 group-hover:w-24"></span>
		</div>
		<h4 class="font-display font-bold text-sand uppercase tracking-wide text-base md:text-[17px]">
			<?php echo esc_html( $nom ); ?>
		</h4>
		<?php if ( $fonction ) : ?>
			<p class="text-primary-light text-[11px] tracking-[.18em] uppercase mt-1.5"><?php echo esc_html( $fonction ); ?></p>
		<?php endif; ?>
		<?php if ( $desc ) : ?>
			<p class="text-sand/55 text-xs mt-2 leading-relaxed max-w-[30ch]"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>
	</div>

<?php elseif ( $variant === 'compact' ) : ?>
	<div class="bg-sand/[.03] border border-sand/[.06] p-4 text-center">
		<?php if ( $photo_url ) : ?>
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $nom ); ?>" class="w-12 h-12 rounded-full object-cover mx-auto mb-3">
		<?php else : ?>
			<div class="w-12 h-12 rounded-full bg-ocean-mid flex items-center justify-center mx-auto mb-3 overflow-hidden">
				<svg viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-sand/35" aria-hidden="true"><path d="M12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/></svg>
			</div>
		<?php endif; ?>
		<div class="font-display font-semibold text-sand text-sm"><?php echo esc_html( $nom ); ?></div>
		<?php if ( $fonction ) : ?><div class="text-primary-light text-[10px] tracking-widest uppercase mt-1"><?php echo esc_html( $fonction ); ?></div><?php endif; ?>
	</div>

<?php else : /* detail (fallback) */ ?>
	<div class="bg-sand/[.04] border border-sand/[.07] p-6 flex items-start gap-4">
		<?php if ( $photo_url ) : ?>
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $nom ); ?>" class="w-14 h-14 rounded-full object-cover shrink-0">
		<?php else : ?>
			<div class="w-14 h-14 rounded-full bg-ocean-mid flex items-center justify-center shrink-0 overflow-hidden">
				<svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-sand/35" aria-hidden="true"><path d="M12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/></svg>
			</div>
		<?php endif; ?>
		<div>
			<div class="font-display font-semibold text-sand text-base"><?php echo esc_html( $nom ); ?></div>
			<?php if ( $fonction ) : ?><div class="text-primary-light text-[10px] tracking-[.12em] uppercase mt-0.5"><?php echo esc_html( $fonction ); ?></div><?php endif; ?>
			<?php if ( $desc ) : ?><div class="text-sand/45 text-xs mt-1.5 leading-relaxed"><?php echo esc_html( $desc ); ?></div><?php endif; ?>
		</div>
	</div>
<?php endif;
