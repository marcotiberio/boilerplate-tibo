import { buildRefs } from '@/assets/scripts/helpers.js'
import { debounce } from 'lodash-es'

export default (navigationFooter) => {
  const refs = buildRefs(navigationFooter)
  
  // Initialize marquee if it exists
  // let marqueeInstance = null
  // if (refs.marquee) {
  //   marqueeInstance = initMarquee(refs)
  // }
  
  // Initialize logo stretch animation
  const cleanupLogoStretch = initLogoStretch(navigationFooter, refs)
  
  return () => {
    if (marqueeInstance) {
      marqueeInstance.destroy()
    }
    cleanupLogoStretch()
  }
}

function initLogoStretch(footer, refs) {
  const logo = refs.logo
  const logoContainer = refs.logoContainer
  
  if (!logo || !logoContainer) {
    return () => {} // No cleanup needed if logo doesn't exist
  }
  
  let windowHeight = window.innerHeight
  let isBouncing = false
  let scrollStopTimeout = null
  
  const updateDimensions = () => {
    windowHeight = window.innerHeight
  }
  
  const applyStretch = (progress, animate = false) => {
    const maxStretch = 1.5 // Maximum stretch multiplier (adjust as needed)
    const scaleY = 1 + (progress * (maxStretch - 1))
    
    if (animate) {
      // More extreme bounce: longer duration and more pronounced bounce curve
      logo.style.transition = 'transform 0.5s cubic-bezier(0.68, -1.5, 0.265, 2.2)' // Extreme bounce easing
    } else {
      logo.style.transition = 'transform 0.1s ease-out'
    }
    
    logo.style.transform = `scaleY(${scaleY})`
    logo.style.transformOrigin = 'center bottom'
  }
  
  const startBounceAnimation = () => {
    if (isBouncing) return
    
    isBouncing = true
    // Bounce back to original size
    applyStretch(0, true)
    
    // Reset bounce flag after animation completes
    setTimeout(() => {
      isBouncing = false
      logo.style.transition = 'transform 0.1s ease-out'
    }, 1000) // Match transition duration (1s)
  }
  
  const checkScrollStop = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop
    const documentHeight = document.documentElement.scrollHeight
    const scrollBottom = scrollTop + windowHeight
    
    // Check if user has scrolled to the bottom (within a small threshold)
    const threshold = 5 // pixels tolerance for "at bottom"
    const distanceFromBottom = documentHeight - scrollBottom
    const isAtBottom = distanceFromBottom <= threshold
    
    // If scrolling stopped and we're at bottom, trigger bounce
    if (isAtBottom && !isBouncing) {
      startBounceAnimation()
    }
  }
  
  const stretchLogo = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop
    const documentHeight = document.documentElement.scrollHeight
    const scrollBottom = scrollTop + windowHeight
    
    // Check if user has scrolled to the bottom (within a small threshold)
    const threshold = 5 // pixels tolerance for "at bottom"
    const distanceFromBottom = documentHeight - scrollBottom
    const isAtBottom = distanceFromBottom <= threshold
    
    // Clear existing scroll stop timeout
    if (scrollStopTimeout) {
      clearTimeout(scrollStopTimeout)
      scrollStopTimeout = null
    }
    
    let progress = 0
    
    // Only start stretching when we've hit the bottom
    if (isAtBottom && !isBouncing) {
      // When at bottom, progress is 1 (fully stretched)
      progress = 1
      
      // Set timeout to detect scroll stop (after 150ms of no scrolling)
      scrollStopTimeout = setTimeout(() => {
        checkScrollStop()
        scrollStopTimeout = null
      }, 150) // Wait 150ms after scroll stops
    } else if (!isAtBottom && !isBouncing) {
      // Not at bottom, reset to original size
      progress = 0
    }
    
    // Apply stretch only if not bouncing
    if (!isBouncing) {
      applyStretch(progress)
    }
  }
  
  // Throttle scroll handler for smooth performance
  const throttledStretch = debounce(stretchLogo, 16) // ~60fps
  
  // Debounce resize handler
  const debouncedUpdateDimensions = debounce(() => {
    updateDimensions()
    stretchLogo()
  }, 100)
  
  // Initial setup
  updateDimensions()
  stretchLogo()
  
  // Listen to scroll events
  window.addEventListener('scroll', throttledStretch, { passive: true })
  
  // Update dimensions on resize
  window.addEventListener('resize', debouncedUpdateDimensions, { passive: true })
  
  return () => {
    if (scrollStopTimeout) {
      clearTimeout(scrollStopTimeout)
    }
    window.removeEventListener('scroll', throttledStretch)
    window.removeEventListener('resize', debouncedUpdateDimensions)
    // Reset logo transform
    if (logo) {
      logo.style.transform = ''
      logo.style.transformOrigin = ''
      logo.style.transition = ''
    }
  }
}

// function initMarquee(refs) {
//   const marqueeContainer = refs.marquee
//   const marqueeContent = marqueeContainer.querySelector('[data-ref="marqueeContent"]')
  
//   if (!marqueeContent) return null
  
//   // Clone the content for seamless loop
//   const clone = marqueeContent.cloneNode(true)
//   marqueeContainer.appendChild(clone)
  
//   // Configuration
//   const speed = 50 // pixels per second
//   let animationId = null
//   let position = 0
//   let isPaused = false
  
//   // Get the width of the content
//   const contentWidth = marqueeContent.offsetWidth
  
//   // Animation function
//   function animate() {
//     if (!isPaused) {
//       position -= speed / 60 // 60fps
      
//       // Reset position for seamless loop
//       if (Math.abs(position) >= contentWidth) {
//         position = 0
//       }
      
//       marqueeContent.style.transform = `translateX(${position}px)`
//       clone.style.transform = `translateX(${position + contentWidth}px)`
//     }
    
//     animationId = requestAnimationFrame(animate)
//   }
  
//   // Start animation
//   animate()
  
//   // Optional: Pause on hover
//   marqueeContainer.addEventListener('mouseenter', () => {
//     isPaused = true
//   })
  
//   marqueeContainer.addEventListener('mouseleave', () => {
//     isPaused = false
//   })
  
//   // Return cleanup function
//   return {
//     destroy: () => {
//       if (animationId) {
//         cancelAnimationFrame(animationId)
//       }
//       marqueeContainer.removeEventListener('mouseenter', () => {})
//       marqueeContainer.removeEventListener('mouseleave', () => {})
//       if (clone && clone.parentNode) {
//         clone.parentNode.removeChild(clone)
//       }
//     }
//   }
// }
