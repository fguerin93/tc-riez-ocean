<?php
/**
 * Footer.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$logo       = tcro_option( 'global_logo' );
$nom        = tcro_option( 'global_nom', 'TC Riez Océan' );
$desc       = tcro_option( 'global_footer_desc', 'Tennis, Pickleball & Tennis Santé à Saint-Hilaire-de-Riez depuis 1980.' );
$cols       = tcro_option( 'global_footer_cols', [] );
$annee      = date( 'Y' );
?>

<!-- ───────── FOOTER ───────── -->
<footer class="bg-[#25130E] border-t border-white/[.07] pt-12 pb-7 px-5 sm:px-8 md:px-16">
	<div class="max-w-[1520px] mx-auto">
		<div class="flex flex-col sm:flex-row justify-between gap-10 mb-10">
			<div class="max-w-xs">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block mb-4">
					<?php if ( $logo && is_array( $logo ) ) : ?>
						<img src="<?php echo esc_url( $logo['sizes']['medium'] ?? $logo['url'] ); ?>"
						     alt="<?php echo esc_attr( $logo['alt'] ?: $nom ); ?>"
						     class="w-[100px] h-[100px] rounded-full object-contain bg-white p-1">
					<?php else : ?>
						<img src="<?php echo esc_url( TCRO_URI . '/assets/img/logo.jpg' ); ?>"
						     alt="<?php echo esc_attr( $nom ); ?>"
						     class="w-[100px] h-[100px] rounded-full object-contain bg-white p-1">
					<?php endif; ?>
				</a>
				<span class="block font-display font-bold text-white text-lg mb-2"><?php echo esc_html( $nom ); ?></span>
				<p class="font-serif italic text-white/40 leading-relaxed text-sm"><?php echo esc_html( $desc ); ?></p>
			</div>
			<?php
			// Col 1 = menu WP "Le club" (Apparence > Menus). Cols suivantes = ACF.
			$club_titre = ! empty( $cols[0]['titre'] ) ? $cols[0]['titre'] : 'Le club';
			$other_cols = array_slice( $cols, 1 );
			$total_cols = 1 + count( $other_cols );
			?>
			<div class="grid grid-cols-<?php echo esc_attr( min( $total_cols, 3 ) ); ?> gap-5 sm:gap-10">
				<div>
					<p class="text-white/35 text-[10px] tracking-widest uppercase mb-3"><?php echo esc_html( $club_titre ); ?></p>
					<?php
					wp_nav_menu( [
						'theme_location' => 'footer',
						'container'      => false,
						'depth'          => 1,
						'menu_class'     => 'flex flex-col gap-2 [&_a]:text-white/55 [&_a:hover]:text-white [&_a]:text-sm [&_a]:transition-colors',
						'fallback_cb'    => 'tcro_footer_menu_fallback',
					] );
					?>
				</div>

				<?php foreach ( $other_cols as $col ) : ?>
					<div>
						<p class="text-white/35 text-[10px] tracking-widest uppercase mb-3"><?php echo esc_html( $col['titre'] ); ?></p>
						<ul class="flex flex-col gap-2">
							<?php foreach ( ( $col['liens'] ?? [] ) as $lien ) : ?>
								<li><a href="<?php echo esc_url( $lien['url'] ); ?>" class="text-white/55 hover:text-white text-sm transition-colors"><?php echo esc_html( $lien['label'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="border-t border-white/[.07] pt-5 flex flex-col sm:flex-row justify-between items-center gap-2.5 text-center">
			<span class="text-white/30 text-xs">© <?php echo esc_html( $annee ); ?> <?php echo esc_html( $nom ); ?> · Saint-Hilaire-de-Riez (85270)</span>
			<div class="flex items-center gap-2 text-white/25 text-[10px] tracking-wider uppercase">
				<span class="w-1.5 h-1.5 rounded-full bg-primary opacity-60"></span>Affilié Fédération Française de Tennis
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
