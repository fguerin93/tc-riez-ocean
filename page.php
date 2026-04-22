<?php
/**
 * Template page statique.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<main class="pt-32 pb-20 px-5 sm:px-8 md:px-12">
	<div class="max-w-4xl mx-auto">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="font-display font-bold text-sand text-3xl md:text-4xl mb-6"><?php the_title(); ?></h1>
			<div class="prose prose-invert max-w-none text-sand/80"><?php the_content(); ?></div>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer();
