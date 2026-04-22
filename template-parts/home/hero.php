<?php
/**
 * Home — Hero.
 * Photo plein écran + titre massif + avatars équipe pédagogique.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$image     = tcro_option( 'hero_image' );
$kicker    = tcro_option( 'hero_kicker', 'Vendée Atlantique · Depuis 1980' );
$titre     = tcro_option( 'hero_titre', 'TC Riez Océan,' );
$titre_em  = tcro_option( 'hero_titre_em', 'le tennis vivant' );
$sous_t    = tcro_option( 'hero_sous_titre', '' );
$cta1_lbl  = tcro_option( 'hero_cta1_label', 'S\'inscrire sur Ten\'Up' );
$cta1_url  = tcro_option( 'hero_cta1_url', 'https://tenup.fft.fr/club/61850433/offres' );
$cta2_lbl  = tcro_option( 'hero_cta2_label', 'Découvrir le club' );
$cta2_url  = tcro_option( 'hero_cta2_url', '#activites' );
$annee     = tcro_option( 'hero_annee', '1980' );
$stats     = tcro_option( 'hero_stats', [] );

// Récupère les coachs (équipe pédagogique) pour afficher les avatars.
$coachs = get_posts( [
	'post_type'      => 'tcro_membre',
	'posts_per_page' => 4,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'tax_query'      => [ [
		'taxonomy' => 'tcro_role_equipe',
		'field'    => 'slug',
		'terms'    => 'pedagogique',
	] ],
] );
?>

<section class="hero relative min-h-svh overflow-hidden flex flex-col">

	<!-- Arrière-plan : image ou dégradé de secours -->
	<?php if ( $image && is_array( $image ) ) : ?>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $image['sizes']['2048x2048'] ?? $image['sizes']['large'] ?? $image['url'] ); ?>"
			     alt=""
			     class="w-full h-full object-cover"
			     fetchpriority="high">
			<div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(14,27,46,.35) 0%,rgba(14,27,46,.45) 40%,rgba(14,27,46,.92) 100%)"></div>
		</div>
	<?php else : ?>
		<div class="absolute inset-0" style="background:radial-gradient(ellipse 120% 80% at 60% 30%,rgba(230,51,41,.42),transparent 70%),radial-gradient(ellipse 80% 100% at 5% 80%,rgba(27,47,71,.6),transparent 60%),linear-gradient(160deg,#0E1B2E,#1B2F47 35%,#2D4769 55%,#1B2F47 75%,#0A1524)"></div>
		<div class="court-lines absolute inset-0 pointer-events-none"></div>
	<?php endif; ?>

	<!-- Barre rouge décorative à gauche -->
	<div class="absolute left-0 top-0 bottom-0 w-1 z-10" style="background:linear-gradient(to bottom,transparent,#E63329 30%,#FF5449 70%,transparent)"></div>

	<!-- Watermark année -->
	<?php if ( $annee ) : ?>
	<div class="hidden lg:block absolute right-6 top-[50%] -translate-y-1/2 font-display font-black select-none pointer-events-none leading-none z-[5]"
	     style="font-size:clamp(140px,16vw,260px);color:rgba(248,200,23,.08);letter-spacing:-.03em"><?php echo esc_html( $annee ); ?></div>
	<?php endif; ?>

	<!-- Rubans verticaux à droite -->
	<div class="hidden xl:flex absolute right-5 bottom-36 flex-col items-center gap-6 text-sand/55 text-[10px] tracking-[.35em] uppercase z-10" style="writing-mode:vertical-rl">
		<span>Club FFT · Vendée</span>
		<span class="w-px h-10 bg-sand/20"></span>
		<span>Depuis <?php echo esc_html( $annee ); ?></span>
	</div>

	<!-- Contenu principal -->
	<div class="relative z-10 flex-1 flex flex-col justify-between pt-28 md:pt-32 pb-4 md:pb-6 px-5 sm:px-8 md:px-14">

		<!-- Top row : avatars coachs + kicker -->
		<div class="flex items-start justify-between gap-6 animate-fade-in">

			<?php if ( $coachs ) : ?>
				<div class="max-w-sm md:max-w-lg">
					<div class="flex -space-x-2 mb-3">
						<?php foreach ( $coachs as $c ) :
							$thumb_id  = get_post_thumbnail_id( $c );
							$photo_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) : '';
							$initiales = get_field( 'initiales', $c->ID ) ?: mb_substr( $c->post_title, 0, 2 );
						?>
							<?php if ( $photo_url ) : ?>
								<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $c->post_title ); ?>" class="w-10 h-10 rounded-full object-cover border-2 border-sand/80 shadow">
							<?php else : ?>
								<div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-xs font-display font-bold border-2 border-sand/80 shadow">
									<?php echo esc_html( $initiales ); ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php if ( $sous_t ) : ?>
						<p class="font-serif italic text-sand/85 text-sm md:text-base leading-relaxed max-w-[48ch]">
							<?php echo esc_html( $sous_t ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php elseif ( $sous_t ) : ?>
				<p class="font-serif italic text-sand/85 text-sm md:text-base leading-relaxed max-w-[48ch]">
					<?php echo esc_html( $sous_t ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $kicker ) : ?>
				<p class="hidden md:flex items-center gap-3 text-accent text-[11px] tracking-[.25em] uppercase font-medium shrink-0">
					<span class="w-8 h-px bg-accent"></span><?php echo esc_html( $kicker ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $kicker ) : ?>
		<p class="md:hidden flex items-center gap-3 text-accent text-[10px] tracking-[.25em] uppercase font-medium mt-6">
			<span class="w-6 h-px bg-accent"></span><?php echo esc_html( $kicker ); ?>
		</p>
		<?php endif; ?>

		<!-- Bloc bas : CTAs + titre massif -->
		<div class="mt-auto animate-fade-up">

			<div class="flex flex-col xs:flex-row items-start xs:items-center gap-4 flex-wrap mb-8 md:mb-12">
				<?php if ( $cta1_lbl && $cta1_url ) : ?>
					<a href="<?php echo esc_url( $cta1_url ); ?>" target="_blank" rel="noopener"
						class="bg-primary hover:bg-primary-light text-white text-xs font-medium tracking-widest uppercase px-8 py-4 rounded-sm transition-all hover:-translate-y-px w-full xs:w-auto text-center">
						<?php echo esc_html( $cta1_lbl ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $cta2_lbl && $cta2_url ) : ?>
					<a href="<?php echo esc_url( $cta2_url ); ?>"
						class="text-sand text-xs tracking-widest uppercase border-b border-sand/40 hover:border-primary-light hover:text-primary-light pb-0.5 transition-all">
						<?php echo esc_html( $cta2_lbl ); ?> →
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $titre ) : ?>
				<p class="font-display text-sand/70 tracking-tight leading-none mb-2 md:mb-3" style="font-size:clamp(20px,3vw,38px)">
					<?php echo esc_html( $titre ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $titre_em ) : ?>
				<h1 class="hero-massive font-display font-black text-sand uppercase tracking-[-0.02em] leading-[0.9]"
				    style="font-size:clamp(36px,8.5vw,128px)">
					<?php echo esc_html( $titre_em ); ?>
				</h1>
			<?php endif; ?>
		</div>
	</div>

	<!-- Stats strip -->
	<?php if ( ! empty( $stats ) ) : ?>
	<div class="relative z-10 flex items-center gap-6 sm:gap-10 px-5 sm:px-8 md:px-14 py-4 md:py-5 border-t border-sand/15"
	     style="background:rgba(10,21,36,.72);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px)">
		<?php foreach ( $stats as $i => $stat ) : ?>
			<?php if ( $i > 0 ) : ?><div class="w-px h-8 bg-sand/20"></div><?php endif; ?>
			<div class="flex items-baseline gap-2.5">
				<span class="font-display font-bold text-sand leading-none" style="font-size:clamp(1.4rem,3.2vw,2rem)"><?php echo esc_html( $stat['valeur'] ?? '' ); ?></span>
				<span class="text-sand/50 text-[10px] tracking-[.18em] uppercase"><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
			</div>
		<?php endforeach; ?>

		<a href="#about" class="hidden md:flex items-center gap-2 ml-auto text-sand/45 hover:text-sand text-[10px] tracking-[.25em] uppercase transition-colors group">
			<span>Explorer</span>
			<span class="w-8 h-px bg-sand/30 group-hover:bg-sand transition-colors"></span>
		</a>
	</div>
	<?php endif; ?>
</section>
