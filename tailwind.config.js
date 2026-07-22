/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '*.php',
    'templates/**/*.{php,twig}',
    './Components/**/*.{php,twig}'
  ],
  theme: {
    borderWidth: {
      DEFAULT: '2px',
      0: '0',
      1: '1px',
      3: '3px'
    },
    borderRadius: {
      none: '0',
      DEFAULT: '12px',
      image: '12px',
      button: '12px',
      cta: '12px',      // JGI rounded-[12px] buttons
      card: '12px',     // JGI cards
      media: '16px',    // JGI in-article media (Figma rounded-[16px])
      banner: '20px',   // JGI CTA banner cards (Figma rounded-[20px])
      full: '9999px'
    },
    colors: {
      white: '#ffffff',
      black: '#000000',
      current: 'currentColor',
      transparent: 'transparent',
      // JGI palette — source of truth: theme.json (WordPress editor palette).
      // Format: tailwind name → value  // theme.json slug
      'dark-green': '#113328',    // darkgreen
      jungle: '#294a3e',          // green
      moss: '#d2e8c3',            // moss
      beige: '#f0e6d9',           // beige
      'warmer-beige': '#f2e3d3',  // warmerbeige (info/caption pills)
      'off-white': '#fcfbfa',     // white
      'dark-brown': '#1c1918',    // darkbrown
      'muted-black': '#45423f',   // mutedblack80
      'muted-black-50': '#868686', // mutedblack50
      terracotta: '#b04f0b',      // earthtone (JGI burnt-orange accent — CTA cards, hero highlight)
      cta: '#d67416',
      // Project colors
      grei: '#f1f1f1',
      grey: {
        100: '#f5f5f5',
        200: '#e5e5e5',
        300: '#d4d4d4',
        400: '#a3a3a3',
        500: '#737373',
        600: '#525252',
        700: '#404040',
        800: '#262626',
        900: '#171717',
      },
    },
    fontFamily: {
      sans: ['Inter', 'Arial', 'sans-serif']
    },
    screens: {
      // Breakpoints from _variables.scss
      mobile: '640px',   // $breakpoint-mobile
      tablet: '780px',   // $breakpoint-tablet
      desktop: '1180px', // $breakpoint-desktop
      // Additional breakpoints
      sm: '640px',
      md: '780px',
      lg: '1024px',
      lgplus: '1200px',
      box: '1440px',
      xl: '1680px',
      max: '1920px'
    },
    extend: {
      aspectRatio: {
        '16/6': '16 / 6',
        '9/16': '9 / 16',
        '16/9': '16 / 9',
        '10/16': '10 / 16',
        '16/10': '16 / 10',
        '8/5': '8 / 5',
        '4/3': '4 / 3',
        '3/4': '3 / 4',
        '3/2': '3 / 2',
        '2/1': '2 / 1',
      },
      borderWidth: {
        DEFAULT: '1px',
        0: '0',
        2: '2px',
        3: '3px',
        4: '4px'
      },
      spacing: {
        // Spacing values using CSS variables from spacings.php
        min: 'var(--spacing-min, 6px)',
        xs: 'var(--spacing-xs, 12px)',
        sm: 'var(--spacing-sm, 24px)',
        md: 'var(--spacing-md, 46px)',
        lg: 'var(--spacing-lg, 60px)',
        xl: 'var(--spacing-xl, 80px)',
        xxl: 'var(--spacing-xxl, 100px)',
        max: 'var(--spacing-max, 120px)',
        // Spacing variables from _variables.scss (using CSS variables)
        xSmall: 'var(--spacing-xs, 10px)',
        small: 'var(--spacing-sm, 20px)',
        large: 'var(--spacing-lg, 50px)'
      } 
    },
    safelist: [
    ]
  },
  plugins: []
}
