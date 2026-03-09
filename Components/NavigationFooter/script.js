import { buildRefs } from '@/assets/scripts/helpers.js'

export default (navigationFooter) => {
  const refs = buildRefs(navigationFooter)
  
  // Initialize marquee if it exists
  let marqueeInstance = null
  if (refs.marquee) {
    marqueeInstance = initMarquee(refs)
  }
  
  return () => {
    if (marqueeInstance) {
      marqueeInstance.destroy()
    }
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
