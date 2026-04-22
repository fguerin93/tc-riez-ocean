# TC Riez Océan — thème WordPress

Thème sur-mesure pour le club **TC Riez Océan** (Saint-Hilaire-de-Riez).
Tailwind CSS + ACF Pro + CPTs déclarés en PHP.

Compatible hébergement mutualisé IONOS : le CSS est compilé **en local** puis uploadé avec le thème — aucun build n'est exécuté sur le serveur.

---

## 1. Pré-requis

| | |
|---|---|
| **WordPress** | 6.4+ |
| **PHP** | 8.1+ |
| **ACF Pro** | requis (Options pages, Repeater) — https://www.advancedcustomfields.com/pro/ |
| **Node.js** | 18+ **en local uniquement** (pour builder Tailwind) |

## 2. Installation locale

```bash
# Depuis la racine du thème :
npm install
npm run build    # build minifié une fois
# ou
npm run dev      # watch, pour développer
```

Le script `build` génère `assets/css/main.css` minifié. Ce fichier est **committé** volontairement (cf. `.gitignore`) pour pouvoir uploader le thème tel quel sur IONOS.

## 3. Déploiement sur IONOS

1. Lancer `npm run build` sur ta machine.
2. Uploader par FTP/SFTP **tout le dossier** `tcro/` dans `wp-content/themes/` — **sans** le sous-dossier `node_modules/` (ignoré par défaut).
3. Dans WP Admin → Apparence → Thèmes → activer **TC Riez Océan**.
4. Installer et activer **ACF Pro** (plugin).
5. Aller dans WP Admin → **Contenu du site** (nouveau menu en haut à gauche) et remplir chaque sous-page :
   - Hero, À propos, Équipe (intro), Terrains, Activités, Tarifs (intro), Agenda (intro), Contact, Bandeau Ten'Up, Global.
6. Créer les contenus :
   - **Équipe** (menu Équipe) → ajouter chaque membre (pédagogique ou dirigeante via la taxonomie « Rôles »).
   - **Tarifs** (menu Tarifs) → ajouter chaque formule (cocher « populaire » pour la carte mise en avant).
   - **Agenda** (menu Agenda) → ajouter chaque événement.
7. Dans **Réglages → Lecture**, vérifier que la page d'accueil affiche « Vos derniers articles » OU créer une page vide et la définir comme page statique d'accueil (le fichier `front-page.php` est chargé automatiquement dans les deux cas).

## 4. Arborescence

```
tcro/
├── style.css                 Header de thème WP
├── functions.php             Bootstrap (charge /inc/*)
├── front-page.php            Accueil
├── index.php / page.php / single.php
├── header.php / footer.php
├── package.json              Build Tailwind
├── tailwind.config.js
├── postcss.config.js
├── src/css/main.css          Source Tailwind
├── assets/
│   ├── css/main.css          CSS compilé (uploadé sur IONOS)
│   ├── js/main.js            Nav + reveal
│   └── img/
├── inc/
│   ├── setup.php             Theme supports, menus
│   ├── enqueue.php           CSS/JS front
│   ├── cpts.php              CPTs (membre, tarif, evenement)
│   ├── taxonomies.php        Rôles équipe, catégories événement
│   ├── acf-check.php         Alerte si ACF absent
│   ├── acf-options.php       Pages d'options
│   ├── acf-fields.php        Tous les champs (versionnés)
│   ├── contact-form.php      Handler formulaire
│   └── helpers.php           tcro_option(), tcro_field()
└── template-parts/
    ├── home/ (hero, about, equipe, courts, activites, tarifs, tenup-banner, agenda, contact)
    └── cards/ (membre, tarif, evenement)
```

## 5. Palette (basée sur le logo)

| Token | Hex | Usage |
|---|---|---|
| `primary` | `#E63329` | Rouge du logo — CTA, accents |
| `primary-dark` | `#B8261F` | Hover, variantes |
| `primary-light` | `#FF5449` | Highlights sur fond sombre |
| `accent` | `#F8C817` | Jaune balle — badges, éléments ponctuels |
| `ocean` | `#0E1B2E` | Fond sombre principal — clin d'œil « Océan » |
| `ocean-mid` | `#1B2F47` | Fond sombre variante (agenda) |
| `sand` | `#F5EDD6` | Texte clair sur fond sombre / fond clair chaud |
| `cream` | `#FAF7F0` | Fond clair section « À propos » |
| `ink` | `#1A2332` | Texte sombre (plus doux que noir pur) |

Pour ajuster la palette : éditer `tailwind.config.js` puis relancer `npm run build`.

## 6. Formulaire de contact

Le formulaire poste vers `admin-post.php` et envoie un mail via `wp_mail()`. L'email de réception se configure dans **Contenu du site → Contact → Email de réception (formulaire)** (fallback sur l'email du club, puis sur `admin_email`).

⚠️ Sur IONOS mutualisé, `wp_mail()` peut être bloqué. Si les emails ne partent pas, installer **WP Mail SMTP** et configurer un relay SMTP (OVH, SendGrid, Mailgun, etc.).

## 7. Ajouter un champ ACF

Éditer `inc/acf-fields.php`, ajouter un champ dans le groupe concerné avec une clé stable (`field_tcro_xxx_yyy`). **Ne pas renommer** les clés existantes après une mise en prod, sous peine de perdre les valeurs déjà saisies.

## 8. Notes

- Les CPTs et la taxonomie sont `public => false` (pas d'URL front, pas d'archive) : les contenus ne sont affichés que via les template parts de la home.
- Les termes de taxonomie par défaut (`pedagogique`, `dirigeante` ; `tournoi`, `interclub`…) sont créés automatiquement à l'activation du thème.
- Le logo actuellement dans `/Users/felixguerin/Documents/FELIX/TENNIS/logo-tc-riez-ocean.jpg` doit être uploadé via **Contenu du site → Global → Logo** une fois le site en place.
