<?php
/**
 * Home — Articles / actualités.
 * Cartes avec image + catégorie + titre uppercase + date.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'articles_kicker', 'Actualités du club' );
$titre     = tcro_option( 'articles_titre', 'Les dernières' );
$titre_em  = tcro_option( 'articles_titre_em', 'nouvelles du TCRO' );
$count     = (int) tcro_option( 'articles_count', 4 );
$cta_lbl   = tcro_option( 'articles_cta_lbl', 'Tous les articles' );
$cta_url   = tcro_option( 'articles_cta_url', '' );

$posts = get_posts( [
	'post_type'      => 'post',
	'posts_per_page' => max( 1, $count ),
	'orderby'        => 'date',
	'order'          => 'DESC',
] );

if ( empty( $posts ) ) return;

// Le fallback si pas de CTA URL : page des articles ou accueil.
if ( ! $cta_url ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	$cta_url = $posts_page_id ? get_permalink( $posts_page_id ) : '';
}
?>

<section id="articles" class="bg-[#25130E] py-20 md:py-24">
	<div class="max-w-[1520px] mx-auto px-5 sm:px-8 md:px-16">

		<!-- Header : kicker gauche / titre droite -->
		<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10 md:mb-14 reveal">
			<?php if ( $kicker ) : ?>
				<p class="flex items-center gap-2.5 text-primary-light text-[11px] tracking-[.25em] uppercase font-medium">
					<span class="w-5 h-px bg-primary-light"></span><?php echo esc_html( $kicker ); ?>
				</p>
			<?php endif; ?>
			<h2 class="font-display font-black text-white uppercase tracking-tight leading-[0.95] md:text-right max-w-2xl"
			    style="font-size:clamp(26px,3.8vw,48px)">
				<?php echo esc_html( $titre ); ?><?php if ( $titre_em ) : ?> <em class="text-primary-light not-italic"><?php echo esc_html( $titre_em ); ?></em><?php endif; ?>
			</h2>
		</div>

		<!-- Grid 4 cartes -->
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 md:gap-7 reveal">
			<?php foreach ( $posts as $i => $p ) :
				$url       = get_permalink( $p );
				$thumb     = get_the_post_thumbnail_url( $p, 'large' );
				$cats      = get_the_category( $p->ID );
				$cat       = $cats ? $cats[0]->name : '';
				$date_fr   = wp_date( 'j M Y', get_post_timestamp( $p ) );
				// Décalage vertical façon réf (cartes impaires descendues un peu).
				$offset    = ( $i % 2 === 1 ) ? 'lg:mt-12' : '';
			?>
				<a href="<?php echo esc_url( $url ); ?>" class="group block no-underline <?php echo esc_attr( $offset ); ?>">

					<div class="relative overflow-hidden bg-sand mb-4" style="aspect-ratio:4/5">
						<?php if ( $thumb ) : ?>
							<img src="<?php echo esc_url( $thumb ); ?>"
							     alt="<?php echo esc_attr( $p->post_title ); ?>"
							     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
							     loading="lazy">
						<?php else : ?>
							<div class="w-full h-full" style="background:linear-gradient(145deg,#FDE4E2,#FFDB4D 50%,#FDE4E2)"></div>
						<?php endif; ?>
						<span class="absolute left-0 bottom-0 h-1 w-12 bg-primary transition-all duration-300 group-hover:w-20"></span>
					</div>

					<?php if ( $cat ) : ?>
						<p class="text-primary-light text-[10px] tracking-[.2em] uppercase font-medium mb-2"><?php echo esc_html( $cat ); ?></p>
					<?php endif; ?>

					<h3 class="font-display font-bold text-white uppercase tracking-tight leading-tight text-base md:text-[17px] group-hover:text-primary-light transition-colors">
						<?php echo esc_html( $p->post_title ); ?>
					</h3>

					<p class="text-white/40 text-[11px] mt-2"><?php echo esc_html( $date_fr ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>

		<?php if ( $cta_lbl && $cta_url ) : ?>
			<div class="mt-12 md:mt-16 reveal">
				<a href="<?php echo esc_url( $cta_url ); ?>"
					class="inline-flex items-center gap-2 text-white border-b border-white/30 hover:border-primary-light hover:text-primary-light text-xs tracking-widest uppercase pb-0.5 transition-all">
					<?php echo esc_html( $cta_lbl ); ?> <span>→</span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
