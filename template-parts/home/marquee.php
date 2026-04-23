<?php
/**
 * Home — Bandeau défilant (marquee).
 * Liste de mots séparés par une balle de tennis SVG, scroll horizontal infini.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$words = tcro_option( 'marquee_words', [] );
$theme = tcro_option( 'marquee_theme', 'light' ); // light | dark

if ( empty( $words ) ) return;

// Normalise en tableau de strings.
$list = array_values( array_filter( array_map(
	fn( $w ) => is_array( $w ) ? trim( $w['mot'] ?? '' ) : trim( (string) $w ),
	$words
) ) );

if ( empty( $list ) ) return;

// Balle de tennis inline (jaune accent + lignes blanches).
$ball = '<svg viewBox="0 0 48 48" class="shrink-0 mx-6 md:mx-10 lg:mx-14" style="width:0.75em;height:0.75em" aria-hidden="true">
	<circle cx="24" cy="24" r="22" fill="#F8C817"/>
	<path d="M3 24 C 13 13, 35 13, 45 24" stroke="#ffffff" stroke-width="2" stroke-linecap="round" fill="none"/>
	<path d="M3 24 C 13 35, 35 35, 45 24" stroke="#ffffff" stroke-width="2" stroke-linecap="round" fill="none"/>
</svg>';

$bg_cls   = $theme === 'dark' ? 'bg-ocean'   : 'bg-sand';
$txt_cls  = $theme === 'dark' ? 'text-sand'  : 'text-ink';
?>

<section class="marquee <?php echo esc_attr( "{$bg_cls} {$txt_cls}" ); ?> border-y border-current/10 py-6 md:py-8"
         aria-label="Identité du club">
	<div class="marquee-track font-display font-black uppercase tracking-[-0.02em]"
	     style="font-size:clamp(48px,9vw,140px);line-height:0.95">
		<?php
		// On duplique la liste 2x pour un loop sans couture (translate -50%).
		for ( $i = 0; $i < 2; $i++ ) :
			foreach ( $list as $word ) : ?>
				<span class="inline-flex items-center">
					<?php echo esc_html( $word ); ?>
					<?php echo $ball; /* SVG hardcoded, safe */ ?>
				</span>
			<?php endforeach;
		endfor;
		?>
	</div>
</section>
