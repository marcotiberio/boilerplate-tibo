import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

export default (component) => {
  const figure = component.querySelector('figure')
  const image = component.querySelector('img')
  
  if (!figure || !image) return
  
  let cleanupFn = null
  
  // Wait for image to load to get dimensions
  const initEffect = () => {
    // Ensure figure has proper dimensions
    const figureRect = figure.getBoundingClientRect()
    const figureWidth = figureRect.width || figure.offsetWidth
    const figureHeight = figureRect.height || figure.offsetHeight || image.offsetHeight
    
    // Horizontal stripes configuration: 5 opening left, 5 opening right
    const stripeCount = 10
    const stripeWidth = figureWidth / stripeCount
    const leftStripeCount = 5
    const rightStripeCount = 5
    
    // Create stripes container
    const stripesContainer = document.createElement('div')
    stripesContainer.className = 'absolute top-0 left-0 w-full h-full z-[2] pointer-events-none flex'
    figure.appendChild(stripesContainer)
    
    const leftStripes = []
    const rightStripes = []
    
    // Create left stripes (indices 0-4) - will open to the left
    for (let i = 0; i < leftStripeCount; i++) {
      const stripe = document.createElement('div')
      stripe.className = 'h-full'
      stripe.style.width = `${stripeWidth}px`
      stripe.style.flexShrink = '0'
      stripe.style.backgroundColor = 'transparent'
      
      // Transform origin on right side - opens to the left
      stripe.style.transformOrigin = 'right center'
      
      // Apply blur effect (backdrop-filter for glass effect)
      gsap.set(stripe, {
        backdropFilter: 'blur(10px)',
        filter: 'blur(8px)',
        willChange: 'transform, filter'
      })
      
      stripesContainer.appendChild(stripe)
      leftStripes.push({ element: stripe, index: i })
    }
    
    // Create right stripes (indices 5-9) - will open to the left
    for (let i = 0; i < rightStripeCount; i++) {
      const stripe = document.createElement('div')
      stripe.className = 'h-full'
      stripe.style.width = `${stripeWidth}px`
      stripe.style.flexShrink = '0'
      stripe.style.backgroundColor = 'transparent'
      
      // Transform origin on right side - opens to the left
      stripe.style.transformOrigin = 'right center'
      
      // Apply blur effect (backdrop-filter for glass effect)
      gsap.set(stripe, {
        backdropFilter: 'blur(10px)',
        filter: 'blur(8px)',
        willChange: 'transform, filter'
      })
      
      stripesContainer.appendChild(stripe)
      rightStripes.push({ element: stripe, index: i })
    }
    
    // Create ScrollTrigger animation - horizontal reveal with pinning
    const scrollTrigger = ScrollTrigger.create({
      trigger: component,
      start: 'top top',
      end: () => `+=${window.innerHeight * 1.5}`, // Pin for 1.5x viewport height
      pin: figure,
      pinSpacing: true,
      anticipatePin: 1,
      scrub: 1,
      onUpdate: (self) => {
        const progress = self.progress
        
        // Animate left stripes opening to the left (from center outward)
        leftStripes.forEach((stripe, index) => {
          // Stagger from center (rightmost left stripe opens first)
          const distanceFromCenter = leftStripeCount - index
          const maxDistance = leftStripeCount
          const staggerDelay = (distanceFromCenter / maxDistance) * 0.3
          const stripeProgress = Math.max(0, Math.min(1, (progress - staggerDelay) / 0.7))
          
          // Scale horizontally - shrinks from right to left
          const scaleX = 1 - stripeProgress
          
          // Reduce blur as stripe reveals
          const blurAmount = 10 * (1 - stripeProgress)
          
          gsap.set(stripe.element, {
            scaleX: scaleX,
            backdropFilter: `blur(${blurAmount}px)`,
            filter: `blur(${blurAmount * 0.8}px)`
          })
        })
        
        // Animate right stripes opening to the left (from center outward)
        rightStripes.forEach((stripe, index) => {
          // Stagger from center (leftmost right stripe opens first, closest to center)
          const distanceFromCenter = index + 1
          const maxDistance = rightStripeCount
          const staggerDelay = (distanceFromCenter / maxDistance) * 0.3
          const stripeProgress = Math.max(0, Math.min(1, (progress - staggerDelay) / 0.7))
          
          // Scale horizontally - shrinks from right to left
          const scaleX = 1 - stripeProgress
          
          // Reduce blur as stripe reveals
          const blurAmount = 10 * (1 - stripeProgress)
          
          gsap.set(stripe.element, {
            scaleX: scaleX,
            backdropFilter: `blur(${blurAmount}px)`,
            filter: `blur(${blurAmount * 0.8}px)`
          })
        })
      }
    })
    
    cleanupFn = () => {
      scrollTrigger.kill()
      if (stripesContainer && stripesContainer.parentNode) {
        stripesContainer.parentNode.removeChild(stripesContainer)
      }
    }
  }
  
  // Initialize when image is loaded
  if (image.complete) {
    initEffect()
  } else {
    image.addEventListener('load', initEffect, { once: true })
  }
  
  return () => {
    if (cleanupFn) {
      cleanupFn()
    }
  }
}
