/**
 * Main frontend entry point
 *
 * Imports styles + JS libraries matching your Flynt setup:
 * - Alpine.js (reactive UI)
 * - Lazysizes (lazy loading)
 * - AOS (animate on scroll)
 * - GSAP (animation engine)
 * - Swiper (carousels)
 */

import '@styles/main.scss';

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Lazysizes
import 'lazysizes';

// AOS (Animate On Scroll)
import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init({
  duration: 600,
  once: true,
});

// Block-specific scripts
import './blocks/grid-images';
import './blocks/slider-logos';
import './blocks/slider-box';
import './blocks/video-oembed';
