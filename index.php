<?php
/**
 * Listing actualités (page archive des posts).
 * Même format que la section "articles" de la home : grille de cartes.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<main class="pt-32 pb-24 px-5 sm:px-8 md:px-16 bg-[#25130E] min-h-screen text-white">
	<div class="max-w-[1520px] mx-auto">

		<!-- Header de page -->
		<header class="mb-12 md:mb-16 reveal">
			<p class="flex items-center gap-2.5 text-primary-light text-[11px] tracking-[.25em] uppercase font-medium mb-3">
				<span class="w-5 h-px bg-primary-light"></span>Le club
			</p>
			<h1 class="font-display font-black uppercase tracking-tight leading-[0.95]" style="font-size:clamp(36px,6vw,72px)">
				Toutes les actualités
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>

			<!-- Grille 2/4 cartes — même format que la home -->
			<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 md:gap-7 reveal">
				<?php $i = 0; while ( have_posts() ) : the_post();
					$thumb     = get_the_post_thumbnail_url( null, 'large' );
					$cats      = get_the_category();
					$cat       = $cats ? $cats[0]->name : '';
					$date_fr   = wp_date( 'j M Y', get_post_timestamp() );
					// Décalage vertical façon home (cartes impaires descendues).
					$offset    = ( $i % 2 === 1 ) ? 'lg:mt-12' : '';
					$i++;
				?>
					<a href="<?php the_permalink(); ?>" class="group block no-underline <?php echo esc_attr( $offset ); ?>">

						<div class="relative overflow-hidden bg-[#25130E] mb-4" style="aspect-ratio:4/5">
							<?php if ( $thumb ) : ?>
								<img src="<?php echo esc_url( $thumb ); ?>"
								     alt="<?php the_title_attribute(); ?>"
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

						<h2 class="font-display font-bold text-white uppercase tracking-tight leading-tight text-base md:text-[17px] group-hover:text-primary-light transition-colors">
							<?php the_title(); ?>
						</h2>

						<p class="text-white/40 text-[11px] mt-2"><?php echo esc_html( $date_fr ); ?></p>
					</a>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<nav class="mt-16 md:mt-20 flex items-center justify-center
				[&_.page-numbers]:inline-flex [&_.page-numbers]:items-center [&_.page-numbers]:justify-center
				[&_.page-numbers]:min-w-9 [&_.page-numbers]:h-9 [&_.page-numbers]:px-3
				[&_.page-numbers]:text-xs [&_.page-numbers]:tracking-widest [&_.page-numbers]:uppercase
				[&_.page-numbers]:text-white/55 [&_.page-numbers]:border [&_.page-numbers]:border-white/10
				[&_.page-numbers:hover]:text-white [&_.page-numbers:hover]:border-white/30
				[&_.page-numbers]:transition-colors [&_.page-numbers]:no-underline
				[&_.current]:bg-primary [&_.current]:!text-white [&_.current]:!border-primary
				[&_.dots]:border-0">
				<?php
				the_posts_pagination( [
					'mid_size'           => 1,
					'prev_text'          => '←',
					'next_text'          => '→',
					'screen_reader_text' => ' ',
					'before_page_number' => '<span class="sr-only">Page </span>',
				] );
				?>
			</nav>

		<?php else : ?>
			<p class="text-white/60 font-serif italic">Aucune actualité pour le moment.</p>
		<?php endif; ?>

	</div>
</main>
<?php get_footer();
