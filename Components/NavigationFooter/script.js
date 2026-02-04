import { buildRefs } from '@/assets/scripts/helpers.js'
import { debounce } from 'lodash-es'

export default (navigationFooter) => {
  const refs = buildRefs(navigationFooter)
  
  // Initialize marquee if it exists
  let marqueeInstance = null
  if (refs.marquee) {
    marqueeInstance = initMarquee(refs)
  }
  
  // Initialize scroll reveal functionality
  const cleanupScroll = initScrollReveal(navigationFooter)
  
  return () => {
    if (marqueeInstance) {
      marqueeInstance.destroy()
    }
    cleanupScroll()
  }
}

function initScrollReveal(footer) {
  let isRevealed = false
  const threshold = 100 // pixels from bottom to trigger reveal
  
  // Find buttons container (sibling element after footer)
  // Look for the next sibling that is a div with fixed positioning
  let buttonsContainer = footer.nextElementSibling
  while (buttonsContainer && (!buttonsContainer.classList || !buttonsContainer.classList.contains('fixed'))) {
    buttonsContainer = buttonsContainer.nextElementSibling
  }
  
  let buttonsHeight = 0
  
  const updateButtonsHeight = () => {
    if (buttonsContainer && buttonsContainer.offsetHeight > 0) {
      buttonsHeight = buttonsContainer.offsetHeight
      footer.style.paddingBottom = `${buttonsHeight}px`
    } else {
      footer.style.paddingBottom = '0px'
    }
  }
  
  const checkScrollPosition = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop
    const windowHeight = window.innerHeight
    const documentHeight = document.documentElement.scrollHeight
    
    // Check if user has scrolled to the bottom (within threshold)
    const isAtBottom = scrollTop + windowHeight >= documentHeight - threshold
    
    if (isAtBottom && !isRevealed) {
      footer.classList.add('footer-revealed')
      isRevealed = true
    } else if (!isAtBottom && isRevealed) {
      footer.classList.remove('footer-revealed')
      isRevealed = false
    }
  }
  
  // Debounce scroll handler for performance
  const debouncedCheckScroll = debounce(checkScrollPosition, 10)
  const debouncedUpdateHeight = debounce(updateButtonsHeight, 100)
  
  // Initial setup
  updateButtonsHeight()
  checkScrollPosition()
  
  // Listen to scroll events
  window.addEventListener('scroll', debouncedCheckScroll, { passive: true })
  
  // Also check on resize in case content height changes
  window.addEventListener('resize', () => {
    debouncedCheckScroll()
    debouncedUpdateHeight()
  }, { passive: true })
  
  return () => {
    window.removeEventListener('scroll', debouncedCheckScroll)
    window.removeEventListener('resize', debouncedUpdateHeight)
  }
}

function initMarquee(refs) {
  const marqueeContainer = refs.marquee
  const marqueeContent = marqueeContainer.querySelector('[data-ref="marqueeContent"]')
  
  if (!marqueeContent) return null
  
  // Clone the content for seamless loop
  const clone = marqueeContent.cloneNode(true)
  marqueeContainer.appendChild(clone)
  
  // Configuration
  const speed = 50 // pixels per second
  let animationId = null
  let position = 0
  let isPaused = false
  
  // Get the width of the content
  const contentWidth = marqueeContent.offsetWidth
  
  // Animation function
  function animate() {
    if (!isPaused) {
      position -= speed / 60 // 60fps
      
      // Reset position for seamless loop
      if (Math.abs(position) >= contentWidth) {
        position = 0
      }
      
      marqueeContent.style.transform = `translateX(${position}px)`
      clone.style.transform = `translateX(${position + contentWidth}px)`
    }
    
    animationId = requestAnimationFrame(animate)
  }
  
  // Start animation
  animate()
  
  // Optional: Pause on hover
  marqueeContainer.addEventListener('mouseenter', () => {
    isPaused = true
  })
  
  marqueeContainer.addEventListener('mouseleave', () => {
    isPaused = false
  })
  
  // Return cleanup function
  return {
    destroy: () => {
      if (animationId) {
        cancelAnimationFrame(animationId)
      }
      marqueeContainer.removeEventListener('mouseenter', () => {})
      marqueeContainer.removeEventListener('mouseleave', () => {})
      if (clone && clone.parentNode) {
        clone.parentNode.removeChild(clone)
      }
    }
  }
}
