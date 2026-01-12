import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

// Register GSAP ScrollTo plugin
gsap.registerPlugin(ScrollTrigger)

// Detect mobile iOS devices
function isMobileIOS() {
  return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
}

// Detect mobile devices in general
function isMobileDevice() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
    (window.innerWidth <= 768 && 'ontouchstart' in window)
}

// GSAP Smooth Scroll implementation
class SmoothScroll {
  constructor() {
    this.currentScroll = 0
    this.targetScroll = 0
    this.ease = 0.1
    this.isScrolling = false
    this.rafId = null
    
    // Bind methods
    this.update = this.update.bind(this)
    this.onWheel = this.onWheel.bind(this)
    
    this.init()
  }
  
  init() {
    // Set initial scroll position
    this.currentScroll = window.pageYOffset || window.scrollY
    this.targetScroll = this.currentScroll
    
    // Prevent ScrollTrigger from applying transforms to pageWrapper
    this.setupPageWrapperProtection()
    
    // Add wheel event listener for smooth scrolling
    window.addEventListener('wheel', this.onWheel, { passive: false })
    
    // Start animation loop
    this.update()
    
    // Update ScrollTrigger on scroll
    window.addEventListener('scroll', () => {
      ScrollTrigger.update()
    }, { passive: true })
    
    // Make available globally
    window.smoothScroll = this
  }
  
  setupPageWrapperProtection() {
    const pageWrapper = document.querySelector('.pageWrapper')
    if (!pageWrapper) return
    
    // Use MutationObserver to watch for style changes and remove translate transforms
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
          const transform = pageWrapper.style.transform
          if (transform && transform.match(/translate\(0px,\s*0px\)|translate3d\(0px,\s*0px,\s*0px\)/)) {
            // Remove translate(0px, 0px) or translate3d(0px, 0px, 0px)
            const cleanedTransform = transform
              .replace(/translate\(0px,\s*0px\)/g, '')
              .replace(/translate3d\(0px,\s*0px,\s*0px\)/g, '')
              .trim()
            
            if (cleanedTransform === '') {
              pageWrapper.style.transform = ''
            } else if (cleanedTransform !== transform) {
              pageWrapper.style.transform = cleanedTransform
            }
          }
        }
      })
    })
    
    // Start observing
    observer.observe(pageWrapper, {
      attributes: true,
      attributeFilter: ['style']
    })
    
    // Also hook into ScrollTrigger refresh
    ScrollTrigger.addEventListener('refresh', () => {
      const transform = pageWrapper.style.transform
      if (transform && transform.match(/translate\(0px,\s*0px\)|translate3d\(0px,\s*0px,\s*0px\)/)) {
        const cleanedTransform = transform
          .replace(/translate\(0px,\s*0px\)/g, '')
          .replace(/translate3d\(0px,\s*0px,\s*0px\)/g, '')
          .trim()
        pageWrapper.style.transform = cleanedTransform || ''
      }
    })
  }
  
  onWheel(e) {
    // Prevent default scroll behavior
    e.preventDefault()
    
    // Calculate scroll delta
    const delta = e.deltaY
    this.targetScroll += delta
    
    // Clamp scroll position
    const maxScroll = document.documentElement.scrollHeight - window.innerHeight
    this.targetScroll = Math.max(0, Math.min(this.targetScroll, maxScroll))
    
    // Mark as scrolling
    this.isScrolling = true
  }
  
  update() {
    // Smooth interpolation
    const diff = this.targetScroll - this.currentScroll
    
    if (Math.abs(diff) > 0.1) {
      this.currentScroll += diff * this.ease
      window.scrollTo(0, this.currentScroll)
      this.isScrolling = true
    } else {
      this.currentScroll = this.targetScroll
      window.scrollTo(0, this.currentScroll)
      this.isScrolling = false
    }
    
    // Update ScrollTrigger
    ScrollTrigger.update()
    
    // Continue animation loop
    this.rafId = requestAnimationFrame(this.update)
  }
  
  scrollTo(target, options = {}) {
    const {
      offset = 0,
      duration = 1.2,
      ease = 'power2.out'
    } = options
    
    let targetY
    
    if (typeof target === 'string') {
      const element = document.querySelector(target)
      if (!element) return
      targetY = element.getBoundingClientRect().top + window.pageYOffset + offset
    } else if (target instanceof HTMLElement) {
      targetY = target.getBoundingClientRect().top + window.pageYOffset + offset
    } else if (typeof target === 'number') {
      targetY = target + offset
    } else {
      return
    }
    
    // Clamp scroll position
    const maxScroll = document.documentElement.scrollHeight - window.innerHeight
    targetY = Math.max(0, Math.min(targetY, maxScroll))
    
    // Use GSAP to animate scroll using scrollY property
    const startY = window.pageYOffset || window.scrollY
    const self = this
    gsap.to({ value: startY }, {
      value: targetY,
      duration: duration,
      ease: ease,
      onUpdate: function() {
        const currentValue = this.targets()[0].value
        window.scrollTo(0, currentValue)
        self.currentScroll = currentValue
        self.targetScroll = currentValue
        ScrollTrigger.update()
      }
    })
  }
  
  destroy() {
    // Remove event listeners
    window.removeEventListener('wheel', this.onWheel)
    
    // Cancel animation frame
    if (this.rafId) {
      cancelAnimationFrame(this.rafId)
    }
    
    // Clean up
    delete window.smoothScroll
  }
}

// Initialize smooth scroll
let smoothScroll = null

if (isMobileIOS()) {
  // Don't initialize smooth scroll on mobile iOS - use native scroll
  console.log('GSAP smooth scroll disabled on mobile iOS - using native scroll')
  
  // Handle hash links with native scroll
  handleHashLinksNative()
} else {
  // Initialize smooth scroll on desktop and non-iOS devices
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      smoothScroll = new SmoothScroll()
      handleHashLinks()
    })
  } else {
    smoothScroll = new SmoothScroll()
    handleHashLinks()
  }
}

// Native hash link handler for mobile
function handleHashLinksNative() {
  // Handle initial hash on page load
  if (window.location.hash) {
    setTimeout(() => {
      const hash = window.location.hash
      const element = document.querySelector(hash)
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' })
      }
    }, 100)
  }

  // Handle programmatic scrolls (e.g., from anchor links)
  document.addEventListener('click', (e) => {
    const anchor = e.target.closest('a[href^="#"]')
    if (anchor) {
      const hash = anchor.getAttribute('href')
      if (hash && hash !== '#') {
        e.preventDefault()
        const element = document.querySelector(hash)
        if (element) {
          element.scrollIntoView({ behavior: 'smooth', block: 'start' })
          // Update URL
          window.history.pushState(null, null, hash)
        }
      }
    }
  })

  // Handle browser back/forward buttons
  window.addEventListener('popstate', () => {
    const hash = window.location.hash
    if (hash) {
      const element = document.querySelector(hash)
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' })
      }
    }
  })
}

function handleHashLinks() {
  // Handle initial hash on page load
  if (window.location.hash) {
    setTimeout(() => {
      const hash = window.location.hash
      const element = document.querySelector(hash)
      if (element && smoothScroll) {
        smoothScroll.scrollTo(element, {
          offset: -60, // Account for fixed header
          duration: 1.2,
        })
      }
    }, 100)
  }

  // Handle programmatic scrolls (e.g., from anchor links)
  document.addEventListener('click', (e) => {
    const anchor = e.target.closest('a[href^="#"]')
    if (anchor) {
      const hash = anchor.getAttribute('href')
      if (hash && hash !== '#') {
        e.preventDefault()
        const element = document.querySelector(hash)
        if (element && smoothScroll) {
          smoothScroll.scrollTo(element, {
            offset: -60, // Account for fixed header
            duration: 1.2,
          })
          // Update URL without triggering scroll
          window.history.pushState(null, null, hash)
        }
      }
    }
  })

  // Handle browser back/forward buttons
  window.addEventListener('popstate', () => {
    const hash = window.location.hash
    if (hash) {
      const element = document.querySelector(hash)
      if (element && smoothScroll) {
        smoothScroll.scrollTo(element, {
          offset: -60,
          duration: 1.2,
        })
      }
    }
  })
}

export default smoothScroll
