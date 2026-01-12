import 'vite/modulepreload-polyfill'
import './scripts/loadCustomElements'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import FlyntComponent from './scripts/FlyntComponent'
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

window.Alpine = Alpine
Alpine.start()
Alpine.plugin(intersect)

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
