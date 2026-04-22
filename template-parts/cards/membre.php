<?php
/**
 * Card — membre de l'équipe.
 *
 * @var array $args ['variant' => 'detail' | 'compact']
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$variant   = $args['variant'] ?? 'detail';
$initiales = tcro_field( 'initiales', '' );
$fonction  = tcro_field( 'fonction',  '' );
$desc      = tcro_field( 'description', '' );
$nom       = get_the_title();
$thumb_id  = get_post_thumbnail_id();
$photo_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';

if ( $variant === 'compact' ) : ?>
	<div class="bg-sand/[.03] border border-sand/[.06] p-4 text-center">
		<?php if ( $photo_url ) : ?>
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $nom ); ?>" class="w-10 h-10 rounded-full object-cover mx-auto mb-3">
		<?php else : ?>
			<div class="w-10 h-10 rounded-full bg-ocean-mid border border-primary/40 flex items-center justify-center font-display font-bold text-primary-light text-sm mx-auto mb-3"><?php echo esc_html( $initiales ); ?></div>
		<?php endif; ?>
		<div class="font-display font-semibold text-sand text-sm"><?php echo esc_html( $nom ); ?></div>
		<?php if ( $fonction ) : ?><div class="text-primary-light text-[10px] tracking-widest uppercase mt-1"><?php echo esc_html( $fonction ); ?></div><?php endif; ?>
	</div>
<?php else : ?>
	<div class="bg-sand/[.04] border border-sand/[.07] p-6 flex items-start gap-4">
		<?php if ( $photo_url ) : ?>
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $nom ); ?>" class="w-12 h-12 rounded-full object-cover shrink-0">
		<?php else : ?>
			<div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center font-display font-bold text-white text-lg shrink-0"><?php echo esc_html( $initiales ); ?></div>
		<?php endif; ?>
		<div>
			<div class="font-display font-semibold text-sand text-base"><?php echo esc_html( $nom ); ?></div>
			<?php if ( $fonction ) : ?><div class="text-primary-light text-[10px] tracking-[.12em] uppercase mt-0.5"><?php echo esc_html( $fonction ); ?></div><?php endif; ?>
			<?php if ( $desc ) : ?><div class="text-sand/45 text-xs mt-1.5 leading-relaxed"><?php echo esc_html( $desc ); ?></div><?php endif; ?>
		</div>
	</div>
<?php endif;
