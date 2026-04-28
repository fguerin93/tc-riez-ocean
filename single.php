<?php
/**
 * Template single — article de blog.
 * Featured image en hero + contenu + galerie ACF éventuelle.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();

	$cats     = get_the_category();
	$cat      = $cats ? $cats[0] : null;
	$thumb    = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
	$gallery  = tcro_field( 'gallery', [] );
	$date_fr  = wp_date( 'j F Y', get_post_timestamp() );
	?>

	<article>

		<?php if ( $thumb ) : ?>
			<header class="relative overflow-hidden" style="min-height:clamp(340px,55vh,600px)">
				<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"
				     class="absolute inset-0 w-full h-full object-cover"
				     fetchpriority="high">
				<div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(37,19,14,.25) 0%,rgba(37,19,14,.55) 55%,rgba(37,19,14,.96) 100%)"></div>
				<div class="relative z-10 max-w-5xl mx-auto px-5 sm:px-8 md:px-16 pt-36 md:pt-40 pb-10 md:pb-14">
					<?php if ( $cat ) : ?>
						<p class="flex items-center gap-2.5 text-accent text-[11px] tracking-[.25em] uppercase font-medium mb-4">
							<span class="w-5 h-px bg-accent"></span><?php echo esc_html( $cat->name ); ?>
						</p>
					<?php endif; ?>
					<h1 class="font-display font-black text-white uppercase tracking-tight leading-[0.95] max-w-4xl"
					    style="font-size:clamp(28px,5vw,64px)">
						<?php the_title(); ?>
					</h1>
					<p class="text-white/55 text-sm mt-5 tracking-wide"><?php echo esc_html( $date_fr ); ?></p>
				</div>
			</header>
		<?php else : ?>
			<header class="bg-[#25130E] pt-32 pb-14 px-5 sm:px-8 md:px-16">
				<div class="max-w-4xl mx-auto">
					<?php if ( $cat ) : ?>
						<p class="flex items-center gap-2.5 text-accent text-[11px] tracking-[.25em] uppercase font-medium mb-4">
							<span class="w-5 h-px bg-accent"></span><?php echo esc_html( $cat->name ); ?>
						</p>
					<?php endif; ?>
					<h1 class="font-display font-black text-white uppercase tracking-tight leading-tight"
					    style="font-size:clamp(28px,5vw,56px)"><?php the_title(); ?></h1>
					<p class="text-white/55 text-sm mt-5 tracking-wide"><?php echo esc_html( $date_fr ); ?></p>
				</div>
			</header>
		<?php endif; ?>

		<div class="bg-[#25130E] py-14 md:py-20 px-5 sm:px-8 md:px-16">
			<div class="max-w-3xl mx-auto">
				<div class="tcro-article text-white/85 font-serif font-light text-lg leading-relaxed
					[&_p]:mb-5
					[&_h2]:font-display [&_h2]:font-bold [&_h2]:text-white [&_h2]:text-2xl [&_h2]:md:text-3xl [&_h2]:mt-12 [&_h2]:mb-5 [&_h2]:leading-tight
					[&_h3]:font-display [&_h3]:font-semibold [&_h3]:text-white [&_h3]:text-xl [&_h3]:mt-10 [&_h3]:mb-4
					[&_ul]:mb-5 [&_ul]:pl-5 [&_ul]:list-disc [&_li]:mb-2
					[&_a]:text-primary-light [&_a]:underline hover:[&_a]:text-primary
					[&_img]:my-8 [&_img]:w-full [&_img]:rounded-sm
					[&_blockquote]:border-l-4 [&_blockquote]:border-primary [&_blockquote]:pl-5 [&_blockquote]:italic [&_blockquote]:text-white [&_blockquote]:my-8
					[&_strong]:text-white [&_strong]:font-normal">
					<?php the_content(); ?>
				</div>

				<?php if ( ! empty( $gallery ) ) : ?>
					<div class="mt-14 md:mt-20 pt-10 border-t border-white/10">
						<h2 class="font-display font-bold text-white uppercase tracking-tight text-xl md:text-2xl mb-6">Galerie photos</h2>
						<div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-3">
							<?php foreach ( $gallery as $img ) :
								$small = $img['sizes']['medium_large'] ?? $img['sizes']['large'] ?? $img['url'];
								$full  = $img['sizes']['2048x2048']   ?? $img['sizes']['large'] ?? $img['url'];
							?>
								<a href="<?php echo esc_url( $full ); ?>"
								   class="block relative overflow-hidden bg-[#25130E] group"
								   style="aspect-ratio:1"
								   target="_blank" rel="noopener">
									<img src="<?php echo esc_url( $small ); ?>"
									     alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>"
									     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.05]"
									     loading="lazy">
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="mt-14 pt-8 border-t border-white/10 flex flex-wrap gap-4">
					<?php
					$posts_page_id = (int) get_option( 'page_for_posts' );
					$archive_url   = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
					?>
					<a href="<?php echo esc_url( $archive_url ); ?>"
						class="inline-flex items-center gap-2 text-white/60 hover:text-primary-light text-xs tracking-[.2em] uppercase transition-colors">
						<span>←</span> Retour
					</a>
				</div>
			</div>
		</div>
	</article>

<?php endwhile;
get_footer();
