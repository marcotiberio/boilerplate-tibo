/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '*.php',
    'templates/**/*.{php,twig}',
    './Components/**/*.{php,twig}'
  ],
  theme: {
    borderWidth: {
      DEFAULT: '1px',
      0: '0',
      2: '2px',
      3: '3px'
    },
    borderRadius: {
      none: '0',
      DEFAULT: '24px',
      image: '24px',
      container: '24px',
      button: '50px',
      full: '9999px'
    },
    colors: {
      white: '#ffffff',
      black: '#000000',
      current: 'currentColor',
      transparent: 'transparent',
      // Project colors
      blue: '#3d6bff',
      blueDark: '#1545de',
      orange: '#fd4e04',
      beige: '#fef7ca',
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
      lgplus: '1180px',
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
        min: '5px',
        xs: '15px',
        sm: '30px',
        md: '50px',
        lg: '75px',
        xl: '100px',
        xxl: '120px',
        max: '160px',
        // Spacing variables from _variables.scss
        xSmall: '10px',
        small: '20px',
        medium: '35px',
        large: '50px',
        xLarge: '75px',
        xxLarge: '125px'
      } 
    },
    safelist: [
      'stickyText',
      'py-xs',
      'py-md',
      'py-xxl',
      'py-max',
      'pt-pageTop',
      // Predefined padding classes used in components
      'pt-0',
      'pt-xs',
      'pt-md',
      'pt-xxl',
      'pt-max',
      'pb-0',
      'pb-xs',
      'pb-md',
      'pb-xxl',
      '!pb-max',
      // Specific padding values from field variables (arbitrary values)
      'pt-[0px]',
      'pt-[15px]',
      'pt-[50px]',
      'pt-[120px]',
      'pt-[230px]',
      'pt-[160px]',
      'pt-[10vw]',
      'pb-[0px]',
      'pb-[15px]',
      'pb-[50px]',
      'pb-[120px]',
      'pb-[230px]',
    ]
  },
  plugins: []
}
