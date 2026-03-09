import $ from 'jquery'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

// Fade-in Animation
gsap.registerPlugin(ScrollTrigger)

// responsive
const mm = gsap.matchMedia()

// Handle hash links with native scroll behavior
window.onload = () => {
  // Scroll to element id on load using native browser scroll
  const url = window.location.href
  const hash = url.substring(url.indexOf('#') + 1)
  if (hash) {
    const element = document.getElementById(hash)
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
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

// Navigation menu with active section detection
window.navigationMenu = function () {
  return {
    scrolled: false,
    activeSection: '',
    init() {
      this.scrolled = window.scrollY >= 200
      this.updateActiveSection()
      
      // Store reference for child scopes
      window.navigationMenuInstance = this
      
      window.addEventListener('scroll', () => {
        this.scrolled = window.scrollY >= 100
        this.updateActiveSection()
      })
    },
    updateActiveSection() {
      const sections = document.querySelectorAll('section[id], div[id], [id]')
      const scrollPosition = window.scrollY + 150 // Offset for better detection
      
      let current = ''
      sections.forEach(section => {
        const sectionTop = section.offsetTop
        const sectionHeight = section.offsetHeight
        const sectionId = section.getAttribute('id')
        
        if (sectionId && scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
          current = sectionId
        }
      })
      
      // If no section found, check if we're at the top
      if (!current && window.scrollY < 100) {
        const firstSection = document.querySelector('section[id], div[id], [id]')
        if (firstSection) {
          current = firstSection.getAttribute('id') || ''
        }
      }
      
      this.activeSection = current
    },
    isActive(href) {
      if (!href || !href.startsWith('#')) return false
      const sectionId = href.substring(1)
      return this.activeSection === sectionId
    }
  }
}