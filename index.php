<?php
/**
 * Fallback index.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<main class="pt-32 pb-20 px-5 sm:px-8 md:px-16">
	<div class="max-w-4xl mx-auto">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="mb-12">
					<h1 class="font-display font-bold text-sand text-3xl md:text-4xl mb-4"><?php the_title(); ?></h1>
					<div class="prose prose-invert max-w-none"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p class="text-sand/60">Aucun contenu pour le moment.</p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer();
