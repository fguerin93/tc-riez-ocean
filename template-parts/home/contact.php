<?php
/**
 * Home — Contact.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$kicker    = tcro_option( 'contact_kicker', 'Contact & Inscription' );
$titre     = tcro_option( 'contact_titre', 'Nous contacter' );
$titre_em  = tcro_option( 'contact_titre_em', '& nous rejoindre' );
$intro     = tcro_option( 'contact_intro', '' );
$adresse   = tcro_option( 'contact_adresse', '' );
$tel       = tcro_option( 'contact_tel', '' );
$email     = tcro_option( 'contact_email', '' );
$horaires  = tcro_option( 'contact_horaires', '' );
$qlinks    = tcro_option( 'contact_qlinks', [] );
$form_ok   = isset( $_GET['contact_sent'] ) && $_GET['contact_sent'] === '1';
?>

<section id="contact" class="py-20 md:py-28 bg-sand text-ink">
	<div class="max-w-6xl mx-auto px-5 sm:px-8 md:px-12">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">

			<div class="reveal">
				<?php if ( $kicker ) : ?>
				<p class="flex items-center gap-2.5 text-primary-dark text-[11px] tracking-[.2em] uppercase font-medium mb-3">
					<span class="w-5 h-px bg-primary-dark"></span><?php echo esc_html( $kicker ); ?>
				</p>
				<?php endif; ?>
				<h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(24px,3.5vw,42px)">
					<?php echo esc_html( $titre ); ?><?php if ( $titre_em ) : ?><br><em class="text-primary"><?php echo esc_html( $titre_em ); ?></em><?php endif; ?>
				</h2>
				<?php if ( $intro ) : ?>
					<div class="font-serif font-light text-lg leading-relaxed mb-6 text-ink/70 [&_a]:text-primary [&_a]:font-medium [&_a]:underline">
						<?php echo wp_kses_post( $intro ); ?>
					</div>
				<?php endif; ?>

				<div class="flex flex-col gap-4">
					<?php
					$rows = array_filter( [
						$adresse  ? [ '📍', 'Adresse',   nl2br( esc_html( $adresse ) ) ] : null,
						$tel      ? [ '📞', 'Téléphone', esc_html( $tel ) ] : null,
						$email    ? [ '✉️', 'Email',     esc_html( $email ) ] : null,
						$horaires ? [ '🕐', 'Horaires',  nl2br( esc_html( $horaires ) ) ] : null,
					] );
					foreach ( $rows as $row ) : ?>
						<div class="flex gap-3">
							<div class="w-9 h-9 rounded-sm bg-primary flex items-center justify-center text-base shrink-0 mt-0.5"><?php echo $row[0]; ?></div>
							<div>
								<div class="text-primary text-[10px] tracking-[.15em] uppercase mb-0.5"><?php echo esc_html( $row[1] ); ?></div>
								<div class="text-sm text-ink/75"><?php echo $row[2]; ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="reveal">
				<?php if ( ! empty( $qlinks ) ) : ?>
				<div class="grid grid-cols-<?php echo esc_attr( max( 1, min( count( $qlinks ), 3 ) ) ); ?> gap-2 mb-6">
					<?php foreach ( $qlinks as $ql ) : ?>
						<a href="<?php echo esc_url( $ql['url'] ); ?>" target="_blank" rel="noopener"
							class="flex flex-col items-center gap-1.5 p-3 rounded-sm border bg-ink/5 border-ink/15 hover:bg-ink/10 text-center transition-all hover:-translate-y-0.5">
							<?php if ( ! empty( $ql['icone'] ) ) : ?><span class="text-lg"><?php echo esc_html( $ql['icone'] ); ?></span><?php endif; ?>
							<span class="text-[10px] tracking-[.1em] uppercase font-medium text-primary"><?php echo esc_html( $ql['label'] ); ?></span>
							<?php if ( ! empty( $ql['sous_label'] ) ) : ?><span class="text-[10px] text-ink/55"><?php echo esc_html( $ql['sous_label'] ); ?></span><?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<?php if ( $form_ok ) : ?>
					<div class="p-5 rounded-sm bg-primary/10 border border-primary/30 text-primary text-sm">
						Merci, votre message a bien été envoyé. Nous vous répondrons au plus vite.
					</div>
				<?php else : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="flex flex-col gap-4">
					<input type="hidden" name="action" value="tcro_contact">
					<?php wp_nonce_field( 'tcro_contact', 'tcro_contact_nonce' ); ?>
					<input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">

					<div class="grid grid-cols-2 gap-3">
						<div class="flex flex-col gap-1.5">
							<label class="text-[10px] tracking-[.15em] uppercase text-ink/55">Prénom</label>
							<input type="text" name="prenom" required placeholder="Jean" class="w-full border rounded-sm px-4 py-3 text-sm outline-none transition-colors bg-ink/5 border-ink/15 focus:border-primary text-ink">
						</div>
						<div class="flex flex-col gap-1.5">
							<label class="text-[10px] tracking-[.15em] uppercase text-ink/55">Nom</label>
							<input type="text" name="nom" required placeholder="Dupont" class="w-full border rounded-sm px-4 py-3 text-sm outline-none transition-colors bg-ink/5 border-ink/15 focus:border-primary text-ink">
						</div>
					</div>
					<div class="flex flex-col gap-1.5">
						<label class="text-[10px] tracking-[.15em] uppercase text-ink/55">Email</label>
						<input type="email" name="email" required placeholder="jean.dupont@email.fr" class="w-full border rounded-sm px-4 py-3 text-sm outline-none bg-ink/5 border-ink/15 focus:border-primary text-ink">
					</div>
					<div class="flex flex-col gap-1.5">
						<label class="text-[10px] tracking-[.15em] uppercase text-ink/55">Je souhaite</label>
						<select name="sujet" class="w-full border rounded-sm px-4 py-3 text-sm outline-none bg-ink/5 border-ink/15 focus:border-primary text-ink">
							<option value="">Choisir une option</option>
							<option>M'inscrire au club</option>
							<option>Inscrire mon enfant</option>
							<option>Réserver un court</option>
							<option>Renseignements sur les stages</option>
							<option>Autres renseignements</option>
						</select>
					</div>
					<div class="flex flex-col gap-1.5">
						<label class="text-[10px] tracking-[.15em] uppercase text-ink/55">Message (optionnel)</label>
						<textarea name="message" rows="4" placeholder="Votre message…" class="w-full border rounded-sm px-4 py-3 text-sm outline-none resize-none bg-ink/5 border-ink/15 focus:border-primary text-ink"></textarea>
					</div>
					<button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white text-xs font-medium tracking-widest uppercase py-4 rounded-sm transition-all hover:-translate-y-px">
						Envoyer le message
					</button>
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
