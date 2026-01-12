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
      DEFAULT: '0',
      image: '10px',
      container: '20px',
      button: '50px',
      full: '9999px'
    },
    colors: {
      white: '#ffffff',
      black: '#090019',
      red: '#ec0e5c',
      orange: '#fa642e',
      orangeHover: '#fe4400',
      yellow: '#ffdd47',
      green: '#7bdb8f',
      beige: '#f6f4ca',
      blue: '#6690ff',
      lightblue: '#b1d1e4',
      grey: '#f9f9f9',
      darkgrey: '#28321E',
      acqua: '#51bad9',
      azulgrey: '#e6ecee',
      current: 'currentColor',
      transparent: 'transparent',
      blog: '#7bdb8f',
      event: '#6690ff',
      lernen: '#ff904f'
    },
    fontFamily: {
      sans: ['Inter', 'Arial', 'sans-serif']
    },
    // fontSize: {
    //   body: ['1.5rem'],
    //   bodySmall: ['0.875rem'],
    //   button: ['1rem'],
    //   heroTitle: ['5rem'],
    //   heroSubtitle: ['3.125rem'],
    //   h1: ['2.25rem'],
    //   h2: ['1.75rem'],
    //   h3: ['1.25rem'],
    //   bodyMenu: ['1rem']
    // },
    screens: {
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
        min: '7.5px',
        xs: '15px',
        sm: '30px',
        md: '50px',
        lg: '75px',
        xl: '100px',
        xxl: '120px',
        max: '160px'
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
