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

<body <?php body_class( 'font-sans bg-cream text-ink overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<!-- ───────── NAV ───────── -->
<header id="hdr" class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
	style="background:#25130E">

	<div class="flex items-center justify-between max-w-[1520px] mx-auto px-5 sm:px-8 md:px-16 py-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 font-display font-bold text-white no-underline z-10 relative">
			<?php if ( $logo && is_array( $logo ) ) : ?>
				<img src="<?php echo esc_url( $logo['sizes']['thumbnail'] ?? $logo['url'] ); ?>"
				     alt="<?php echo esc_attr( $logo['alt'] ?: $nom_club ); ?>"
				     class="w-10 h-10 rounded-full object-contain bg-white p-0.5 shrink-0">
			<?php else : ?>
				<img src="<?php echo esc_url( TCRO_URI . '/assets/img/logo.jpg' ); ?>"
				     alt="<?php echo esc_attr( $nom_club ); ?>"
				     class="w-10 h-10 rounded-full object-contain bg-white p-0.5 shrink-0">
			<?php endif; ?>
			<span class="hidden sm:block text-sm md:text-base tracking-wide leading-snug"><?php echo esc_html( $nom_club ); ?><br class="hidden md:block"> <?php echo esc_html( $sous_nom ); ?></span>
			<span class="sm:hidden text-sm tracking-wide"><?php echo esc_html( $nom_club ); ?></span>
		</a>

		<!-- Desktop nav (Apparence > Menus → emplacement "Menu principal") -->
		<nav class="hidden lg:flex items-center gap-7">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'depth'          => 1,
				'menu_class'     => 'flex items-center gap-7 [&_a]:text-white/70 [&_a:hover]:text-white [&_a]:text-[11px] [&_a]:tracking-widest [&_a]:uppercase [&_a]:transition-colors',
				'fallback_cb'    => 'tcro_primary_menu_fallback',
			] );
			?>
			<a href="<?php echo esc_url( $tenup_url ); ?>" target="_blank" rel="noopener" class="bg-primary hover:bg-primary-light text-white text-[11px] tracking-wider uppercase font-medium px-5 py-2.5 rounded-sm transition-colors">Nous rejoindre</a>
		</nav>

		<!-- Burger -->
		<button id="brg" class="burger lg:hidden relative z-10 flex flex-col justify-center gap-[5px] w-10 h-10 -mr-1 bg-transparent border-0 cursor-pointer"
			aria-label="Menu" aria-controls="mmenu" aria-expanded="false">
			<span class="block w-6 h-0.5 bg-white rounded origin-center"></span>
			<span class="block w-6 h-0.5 bg-white rounded"></span>
			<span class="block w-6 h-0.5 bg-white rounded origin-center"></span>
		</button>
	</div>

	<!-- Mobile menu (même menu "primary", style mobile) -->
	<div id="mmenu" class="closed fixed inset-0 backdrop-blur-md flex flex-col items-center justify-center gap-7 z-0"
		style="background:linear-gradient(rgba(230,51,41,.22),rgba(230,51,41,.22)),rgba(37,19,14,.85)">
		<?php
		wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => false,
			'depth'          => 1,
			'menu_class'     => 'flex flex-col items-center gap-7 [&_a]:font-display [&_a]:text-2xl [&_a]:text-white [&_a:hover]:text-primary-light [&_a]:transition-colors',
			'fallback_cb'    => 'tcro_primary_menu_fallback',
		] );
		?>
		<a href="<?php echo esc_url( $tenup_url ); ?>" target="_blank" rel="noopener" class="mt-3 bg-primary hover:bg-primary-light text-white text-sm tracking-widest uppercase font-medium px-10 py-4 rounded-sm transition-colors">Nous rejoindre</a>
	</div>
</header>
