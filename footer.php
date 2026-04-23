<?php
/**
 * Footer.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$nom        = tcro_option( 'global_nom', 'TC Riez Océan' );
$desc       = tcro_option( 'global_footer_desc', 'Tennis, Pickleball & Tennis Santé à Saint-Hilaire-de-Riez depuis 1980.' );
$cols       = tcro_option( 'global_footer_cols', [] );
$annee      = date( 'Y' );
?>

<!-- ───────── FOOTER ───────── -->
<footer class="bg-ocean border-t border-sand/[.07] pt-12 pb-7 px-5 sm:px-8 md:px-16">
	<div class="max-w-[1520px] mx-auto">
		<div class="flex flex-col sm:flex-row justify-between gap-10 mb-10">
			<div class="max-w-xs">
				<span class="block font-display font-bold text-sand text-lg mb-2"><?php echo esc_html( $nom ); ?></span>
				<p class="font-serif italic text-sand/40 leading-relaxed text-sm"><?php echo esc_html( $desc ); ?></p>
			</div>
			<?php if ( ! empty( $cols ) ) : ?>
			<div class="grid grid-cols-<?php echo esc_attr( min( count( $cols ), 3 ) ); ?> gap-5 sm:gap-10">
				<?php foreach ( $cols as $col ) : ?>
					<div>
						<p class="text-sand/35 text-[10px] tracking-widest uppercase mb-3"><?php echo esc_html( $col['titre'] ); ?></p>
						<ul class="flex flex-col gap-2">
							<?php foreach ( ( $col['liens'] ?? [] ) as $lien ) : ?>
								<li><a href="<?php echo esc_url( $lien['url'] ); ?>" class="text-sand/55 hover:text-sand text-sm transition-colors"><?php echo esc_html( $lien['label'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="border-t border-sand/[.07] pt-5 flex flex-col sm:flex-row justify-between items-center gap-2.5 text-center">
			<span class="text-sand/30 text-xs">© <?php echo esc_html( $annee ); ?> <?php echo esc_html( $nom ); ?> · Saint-Hilaire-de-Riez (85270)</span>
			<div class="flex items-center gap-2 text-sand/25 text-[10px] tracking-wider uppercase">
				<span class="w-1.5 h-1.5 rounded-full bg-primary opacity-60"></span>Affilié Fédération Française de Tennis
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
