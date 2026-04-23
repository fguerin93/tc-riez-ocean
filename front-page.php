<?php
/**
 * Template de la page d'accueil.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<?php get_template_part( 'template-parts/home/hero' ); ?>
<?php get_template_part( 'template-parts/home/about' ); ?>
<?php get_template_part( 'template-parts/home/marquee' ); ?>
<?php get_template_part( 'template-parts/home/articles' ); ?>
<?php get_template_part( 'template-parts/home/equipe' ); ?>
<?php get_template_part( 'template-parts/home/courts' ); ?>
<?php get_template_part( 'template-parts/home/activites' ); ?>
<?php get_template_part( 'template-parts/home/tarifs' ); ?>
<?php get_template_part( 'template-parts/home/tenup-banner' ); ?>
<?php get_template_part( 'template-parts/home/agenda' ); ?>
<?php get_template_part( 'template-parts/home/contact' ); ?>

<?php
get_footer();
