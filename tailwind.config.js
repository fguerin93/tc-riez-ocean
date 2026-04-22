/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  safelist: [
    // Grid cols générés dynamiquement côté footer / quick links.
    { pattern: /^grid-cols-[1-6]$/ },
  ],
  theme: {
    extend: {
      screens: {
        xs: '480px',
      },
      colors: {
        // Rouge du logo (vermillon) — accent principal.
        primary: {
          DEFAULT: '#E63329',
          dark:    '#B8261F',
          light:   '#FF5449',
          pale:    '#FDE4E2',
        },
        // Jaune de la balle de tennis — punctuation / highlights.
        accent: {
          DEFAULT: '#F8C817',
          dark:    '#D4A510',
          light:   '#FFDB4D',
        },
        // Navy profond — clin d'œil "Océan" + ancrage élégant.
        ocean: {
          DEFAULT: '#0E1B2E',
          mid:     '#1B2F47',
          light:   '#2D4769',
        },
        // Texte sombre (moins noir que l'ancien court #18100A).
        ink: {
          DEFAULT: '#1A2332',
          mid:     '#3A4556',
          light:   '#6B7489',
        },
        sand:  '#F5EDD6', // sable chaud
        cream: '#FAF7F0', // blanc cassé
      },
      fontFamily: {
        display: ['"Playfair Display"', 'serif'],
        serif:   ['"Cormorant Garamond"', 'serif'],
        sans:    ['"DM Sans"', 'sans-serif'],
      },
      animation: {
        'fade-up': 'fadeUp .85s ease both',
        'fade-in': 'fadeIn 1.3s ease both',
      },
      keyframes: {
        fadeUp: { from: { opacity: '0', transform: 'translateY(28px)' }, to: { opacity: '1', transform: 'none' } },
        fadeIn: { from: { opacity: '0' }, to: { opacity: '1' } },
      },
    },
  },
  plugins: [],
};
