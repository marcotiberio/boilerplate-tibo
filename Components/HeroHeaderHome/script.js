import { buildRefs } from '@/assets/scripts/helpers.js'

export default (heroHeaderHome) => {
  const refs = buildRefs(heroHeaderHome)
  
  // Initialize marquee if it exists
  let marqueeInstance = null
  if (refs.marquee) {
    marqueeInstance = initMarquee(refs)
  }
  
  // Initialize parallax effect for background images
  let parallaxCleanup = null
  if (refs.backgroundImageDesktop || refs.backgroundImageMobile) {
    parallaxCleanup = initParallax(heroHeaderHome, refs)
  }
  
  return () => {
    if (marqueeInstance) {
      marqueeInstance.destroy()
    }
    if (parallaxCleanup) {
      parallaxCleanup()
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

function initParallax(container, refs) {
  const desktopImage = refs.backgroundImageDesktop
  const mobileImage = refs.backgroundImageMobile
  
  if (!desktopImage && !mobileImage) return null
  
  // Parallax intensity (how much the image moves relative to scroll)
  // Lower values = slower movement = more pronounced parallax effect
  const parallaxSpeed = 0.3
  
  // Optimize for performance
  const images = [desktopImage, mobileImage].filter(Boolean)
  images.forEach(img => {
    if (img) {
      img.style.willChange = 'transform'
    }
  })
  
  function updateParallax() {
    const scrollY = window.scrollY || window.pageYOffset
    
    // Calculate parallax offset based on scroll position
    // The image moves slower than the scroll, creating depth effect
    const parallaxOffset = scrollY * parallaxSpeed
    
    // Apply parallax effect - image moves up as we scroll down
    if (desktopImage) {
      desktopImage.style.transform = `translateY(${parallaxOffset}px)`
    }
    if (mobileImage) {
      mobileImage.style.transform = `translateY(${parallaxOffset}px)`
    }
  }
  
  // Use window scroll event (GSAP smooth scroll updates native scroll)
  window.addEventListener('scroll', updateParallax, { passive: true })
  
  // Initial update
  updateParallax()
  
  // Cleanup function
  return () => {
    window.removeEventListener('scroll', updateParallax)
    images.forEach(img => {
      if (img) {
        img.style.transform = ''
        img.style.willChange = ''
      }
    })
  }
}