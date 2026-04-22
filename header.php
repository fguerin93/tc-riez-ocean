<?php
/**
 * Header : doctype, head, ouverture body, navigation.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$logo        = tcro_option( 'global_logo' );
$nom_club    = tcro_option( 'global_nom', 'TC Riez Océan' );
$sous_nom    = tcro_option( 'global_sous_nom', 'Saint-Hilaire-de-Riez' );
$tenup_url   = tcro_option( 'global_tenup', 'https://tenup.fft.fr/club/61850433/offres' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'font-sans bg-ocean text-sand overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<!-- ───────── NAV ───────── -->
<header id="hdr" class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
	style="background:linear-gradient(to bottom,rgba(14,27,46,.92),transparent)">

	<div class="flex items-center justify-between px-5 sm:px-8 md:px-12 py-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 font-display font-bold text-sand no-underline z-10 relative">
			<?php if ( $logo && is_array( $logo ) ) : ?>
				<img src="<?php echo esc_url( $logo['sizes']['thumbnail'] ?? $logo['url'] ); ?>"
				     alt="<?php echo esc_attr( $logo['alt'] ?: $nom_club ); ?>"
				     class="w-10 h-10 rounded-full object-contain bg-white p-0.5 shrink-0">
			<?php else : ?>
				<span class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold tracking-wider shrink-0">TC</span>
			<?php endif; ?>
			<span class="hidden sm:block text-sm md:text-base tracking-wide leading-snug"><?php echo esc_html( $nom_club ); ?><br class="hidden md:block"> <?php echo esc_html( $sous_nom ); ?></span>
			<span class="sm:hidden text-sm tracking-wide"><?php echo esc_html( $nom_club ); ?></span>
		</a>

		<!-- Desktop nav -->
		<nav class="hidden lg:flex items-center gap-7">
			<?php
			$menu_items = [
				[ '#equipe',    'Équipe' ],
				[ '#courts',    'Terrains' ],
				[ '#activites', 'Activités' ],
				[ '#tarifs',    'Tarifs' ],
				[ '#agenda',    'Agenda' ],
			];
			foreach ( $menu_items as $item ) {
				printf(
					'<a href="%s" class="text-sand/70 hover:text-sand text-[11px] tracking-widest uppercase transition-colors">%s</a>',
					esc_url( $item[0] ), esc_html( $item[1] )
				);
			}
			?>
			<a href="<?php echo esc_url( $tenup_url ); ?>" target="_blank" rel="noopener" class="bg-primary hover:bg-primary-light text-white text-[11px] tracking-wider uppercase font-medium px-5 py-2.5 rounded-sm transition-colors">Nous rejoindre</a>
		</nav>

		<!-- Burger -->
		<button id="brg" class="burger lg:hidden relative z-10 flex flex-col justify-center gap-[5px] w-10 h-10 -mr-1 bg-transparent border-0 cursor-pointer"
			aria-label="Menu" aria-controls="mmenu" aria-expanded="false">
			<span class="block w-6 h-0.5 bg-sand rounded origin-center"></span>
			<span class="block w-6 h-0.5 bg-sand rounded"></span>
			<span class="block w-6 h-0.5 bg-sand rounded origin-center"></span>
		</button>
	</div>

	<!-- Mobile menu -->
	<div id="mmenu" class="closed fixed inset-0 bg-ocean/96 backdrop-blur-md flex flex-col items-center justify-center gap-7 z-0">
		<?php foreach ( $menu_items as $item ) :
			printf(
				'<a href="%s" data-close class="font-display text-2xl text-sand hover:text-primary-light transition-colors">%s</a>',
				esc_url( $item[0] ), esc_html( $item[1] )
			);
		endforeach; ?>
		<a href="<?php echo esc_url( $tenup_url ); ?>" target="_blank" rel="noopener" data-close class="mt-3 bg-primary hover:bg-primary-light text-white text-sm tracking-widest uppercase font-medium px-10 py-4 rounded-sm transition-colors">Nous rejoindre</a>
	</div>
</header>
