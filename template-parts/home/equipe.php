<?php
/**
 * Home — Équipe (CPT tcro_membre, groupé par taxonomie tcro_role_equipe).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker   = tcro_option( 'equipe_kicker', 'Notre équipe' );
$titre    = tcro_option( 'equipe_titre', 'Les visages' );
$titre_em = tcro_option( 'equipe_titre_em', 'du TCRO' );
$note     = tcro_option( 'equipe_note' );

$groupes = [
	'pedagogique' => 'Équipe pédagogique',
	'dirigeante'  => 'Équipe dirigeante',
];
?>

<section id="equipe" class="bg-ocean py-20 md:py-24">
	<div class="max-w-[1520px] mx-auto px-5 sm:px-8 md:px-16">

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

		<?php foreach ( $groupes as $slug => $label ) :
			$query = new WP_Query( [
				'post_type'      => 'tcro_membre',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => [ [
					'taxonomy' => 'tcro_role_equipe',
					'field'    => 'slug',
					'terms'    => $slug,
				] ],
			] );
			if ( ! $query->have_posts() ) { continue; }

			$is_pedago = ( $slug === 'pedagogique' );
			$grid_cls  = $is_pedago
				? 'grid-cols-2 md:grid-cols-3 gap-5 md:gap-7'
				: 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3';
			$variant   = $is_pedago ? 'portrait' : 'compact';
		?>
			<div class="<?php echo $is_pedago ? 'mb-14' : 'mb-8'; ?> reveal">
				<p class="text-primary-light text-[10px] tracking-[.2em] uppercase font-medium mb-5 flex items-center gap-2">
					<span class="w-4 h-px bg-primary-light"></span><?php echo esc_html( $label ); ?>
				</p>
				<div class="grid <?php echo esc_attr( $grid_cls ); ?>">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/membre', null, [ 'variant' => $variant ] ); ?>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( $note ) : ?>
			<div class="reveal text-sand/50 text-sm italic font-serif mt-4 max-w-2xl">
				<?php echo wp_kses_post( $note ); ?>
			</div>
		<?php endif; ?>

	</div>
</section>
