import 'vite/modulepreload-polyfill'
import './scripts/loadCustomElements'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import FlyntComponent from './scripts/FlyntComponent'
import { getCookie, setCookie } from './scripts/helpers'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'
import 'lazysizes'

// Initialize GSAP smooth scroll (must be imported before custom.js)
import './scripts/smooth-scroll-init'

import './scripts/custom'

if (import.meta.env.DEV) {
  import('@vite/client')
}

window.customElements.define(
  'flynt-component',
  FlyntComponent
)

// Remembers a dismissed HighlightCard in a cookie. The key is derived from the
// card content, so editing the promo makes it reappear for returning visitors.
Alpine.data('highlightCard', (key) => ({
  show: false,

  init () {
    this.show = getCookie('highlightCardDismissed') !== key
  },

  dismiss () {
    this.show = false
    setCookie('highlightCardDismissed', key)
  }
}))

Alpine.data('themeSwitcher', () => ({
  isDark: localStorage.getItem('theme') === 'dark',

  init () {
    this.applyTheme()
  },

  setTheme (theme) {
    this.isDark = theme === 'dark'
    localStorage.setItem('theme', theme)
    this.applyTheme()
  },

  applyTheme () {
    document.documentElement.classList.toggle('dark', this.isDark)
  }
}))

window.Alpine = Alpine
Alpine.plugin(intersect)
Alpine.start()

gsap.registerPlugin(ScrollTrigger)

import.meta.glob([
  '../Components/**',
  '../assets/**',
  '!**/*.js',
  '!**/*.scss',
  '!**/*.php',
  '!**/*.twig',
  '!**/screenshot.png',
  '!**/*.md'
])
