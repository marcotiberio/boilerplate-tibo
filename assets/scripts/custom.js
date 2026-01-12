import $ from 'jquery'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

// Fade-in Animation
gsap.registerPlugin(ScrollTrigger)

// responsive
const mm = gsap.matchMedia()

// Page transition slide-from-top animation with black background
function initPageTransition() {
  const pageWrapper = document.querySelector('.pageWrapper')
  const overlay = document.querySelector('.page-transition-overlay')
  
  if (!pageWrapper || !overlay) return
  
  // Set initial state: page starts above viewport (already set in CSS)
  // Ensure it's set correctly for GSAP
  const viewportHeight = window.innerHeight
  gsap.set(pageWrapper, {
    y: -viewportHeight,
  })
  
  // Set initial overlay state (already visible from CSS)
  gsap.set(overlay, {
    opacity: 1,
  })
  
  // Small delay to ensure everything is set up
  requestAnimationFrame(() => {
    // Animate page sliding down and overlay fading out
    const tl = gsap.timeline()
    tl.to(pageWrapper, {
      y: 0,
      duration: 0.8,
      ease: 'power2.out',
    })
    .to(overlay, {
      opacity: 0,
      duration: 0.6,
      ease: 'power2.in',
    }, '-=0.6') // Start fading overlay slightly before page finishes sliding
    .call(() => {
      // Remove overlay from DOM after animation
      overlay.remove()
    })
  })
}

// Initialize page transition when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initPageTransition)
} else {
  // DOM is already ready
  initPageTransition()
}

window.onload = () => {
  // scroll to element id on load (handled by GSAP smooth scroll in smooth-scroll-init.js)
  // This is a fallback in case smooth scroll isn't ready yet
  if (window.smoothScroll) {
    setTimeout(() => {
      const url = window.location.href
      const hash = url.substring(url.indexOf('#') + 1)
      if (hash) {
        const element = document.getElementById(hash)
        if (element) {
          window.smoothScroll.scrollTo(element, {
            offset: -60,
            duration: 1.2,
          })
        }
      }
    }, 200)
  }
}

mm.add('(min-width: 1280px)', () => {
  gsap.set('.fade-in', { opacity: 0 })
  gsap.set('.move-up', { y: 200 })
})

ScrollTrigger.batch('.fade-in', {
  onEnter: (elements) =>
    gsap.to(elements, { opacity: 1, stagger: 0.1, duration: 0.5 }),
  start: '1vh bottom',
  end: 'top top',
})

ScrollTrigger.batch('.move-up', {
  onEnter: (elements) =>
    gsap.to(elements, { y: 0, stagger: 0.1, duration: 0.3 }),
  start: '1vh bottom',
  end: 'top top',
})

// // Page Load Animation
// class PageLoadAnimation {
//   constructor() {
//     this.init()
//   }

//   init() {
//     // Only run animation on desktop devices
//     if (this.isDesktop()) {
//       this.startAnimation()
//     } else {
//       // On mobile, immediately remove loading state
//       this.skipAnimation()
//     }
//   }

//   isDesktop() {
//     // Check if screen width is desktop size (typically 1024px and above)
//     return window.innerWidth >= 1024
//   }

//   skipAnimation() {
//     // Remove loading state immediately on mobile
//     const $animation = $('#pageLoadAnimation')
//     if ($animation.length) {
//       $animation.remove()
//     }
//     $('body').removeClass('page-loading')
//   }

//   startAnimation() {
//     // Wait for page to be fully loaded
//     $(window).on('load', () => {
//       // Add a small delay for better UX
//       setTimeout(() => {
//         this.hideAnimation()
//       }, 1000)
//     })
    
//     // Fallback in case window load doesn't fire
//     setTimeout(() => {
//       this.hideAnimation()
//     }, 4000)
//   }

//   hideAnimation() {
//     const $animation = $('#pageLoadAnimation')
    
//     // Add fade-out class
//     $animation.addClass('fade-out')
    
//     // Remove from DOM after animation completes and restore body scroll
//     setTimeout(() => {
//       $animation.remove()
//       $('body').removeClass('page-loading')
//     }, 800)
//   }
// }

// // Initialize the page load animation
// $(document).ready(function () {
//   new PageLoadAnimation()
// })

// var menu = $('.mainMenu');

// $(document).scroll(function () {
//     if ($(this).scrollTop() >= $(window).height() - menu.height()) {
//         menu.removeClass('bottom').addClass('top');
//     }
//     else {
//         menu.removeClass('top').addClass('bottom');
//     }
// });

// Menu items color change
// $(document).ready(function () {
//   let lastScrollTop = 0;
//   $(window).scroll(function () {
//     let currentScrollTop = $(this).scrollTop();
    
//     if (currentScrollTop > lastScrollTop) {
//       // Scrolling down
//       $('flynt-component[name="NavigationBurger"]').addClass('scrolled')
//     } else {
//       // Scrolling up
//       $('flynt-component[name="NavigationBurger"]').removeClass('scrolled')
//     }
    
//     lastScrollTop = currentScrollTop;
//   })
// })

// // Reload page on viewport resize
// let resizeTimer;
// let currentWidth = window.innerWidth;
// let currentHeight = window.innerHeight;

// $(window).on('resize', function() {
//   // Clear the previous timer
//   clearTimeout(resizeTimer);
  
//   // Set a new timer to reload the page after resize stops for 500ms
//   resizeTimer = setTimeout(function() {
//     const newWidth = window.innerWidth;
//     const newHeight = window.innerHeight;
    
//     // Only reload if the width changed significantly (more than 100px)
//     // This avoids reloading on mobile when address bar shows/hides
//     const widthDiff = Math.abs(newWidth - currentWidth);
    
//     if (widthDiff > 100) {
//       location.reload();
//     } else {
//       // Update stored dimensions if no reload happened
//       currentWidth = newWidth;
//       currentHeight = newHeight;
//     }
//   }, 500);
// });