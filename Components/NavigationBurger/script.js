import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'
import delegate from 'delegate-event-listener'
import { buildRefs } from '@/assets/scripts/helpers.js'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

export default function (el) {
  let isMenuOpen
  const refs = buildRefs(el)
  const navigationHeight = parseInt(window.getComputedStyle(el).getPropertyValue('--navigation-height')) || 0

  const isDesktopMediaQuery = window.matchMedia('(min-width: 1024px)')
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange)

  el.addEventListener('click', delegate('[data-ref="menuButton"]', onMenuButtonClick))

  onBreakpointChange()
  initAnimations(el)

  function onMenuButtonClick (e) {
    isMenuOpen = !isMenuOpen
    refs.menuButton.setAttribute('aria-expanded', isMenuOpen)

    if (isMenuOpen) {
      el.setAttribute('data-status', 'menuIsOpen')
      disableBodyScroll(refs.menu)
    } else {
      el.removeAttribute('data-status')
      enableBodyScroll(refs.menu)
    }
  }

  function onBreakpointChange () {
    if (!isDesktopMediaQuery.matches) {
      setScrollPaddingTop()
    }
  }

  function setScrollPaddingTop () {
    const scrollPaddingTop = document.getElementById('wpadminbar')
      ? navigationHeight + document.getElementById('wpadminbar').offsetHeight
      : navigationHeight
    document.documentElement.style.scrollPaddingTop = `${scrollPaddingTop}px`
  }

  function initAnimations (navigationBurger) {
    // Parse viewBox to get center
    const parseViewBox = (viewBox) => {
      const values = viewBox.split(' ')
      return {
        x: parseFloat(values[0]) + parseFloat(values[2]) / 2,
        y: parseFloat(values[1]) + parseFloat(values[3]) / 2
      }
    }

    // Rotate eye2 SVGs
    const eyeLeft2 = navigationBurger.querySelector('#eyeLeft2')
    const eyeRight2 = navigationBurger.querySelector('#eyeRight2')
    
    if (eyeLeft2) {
      const eyeLeft2Group = eyeLeft2.querySelector('g')
      const viewBoxEyeLeft2 = eyeLeft2.getAttribute('viewBox')
      const centerEyeLeft2 = parseViewBox(viewBoxEyeLeft2)

      // Rotate eyeLeft2 group clockwise using SVG transform with center as origin
      if (eyeLeft2Group) {
        gsap.to(eyeLeft2Group, {
          svgOrigin: `${centerEyeLeft2.x} ${centerEyeLeft2.y}`,
          rotation: 360,
          scrollTrigger: {
            start: 'top top',
            end: 'max',
            scrub: true
          }
        })
      }
    }

    if (eyeRight2) {
      const eyeRight2Group = eyeRight2.querySelector('g')
      const viewBoxEyeRight2 = eyeRight2.getAttribute('viewBox')
      const centerEyeRight2 = parseViewBox(viewBoxEyeRight2)

      // Rotate eyeRight2 group counter-clockwise using SVG transform with center as origin
      if (eyeRight2Group) {
        gsap.to(eyeRight2Group, {
          svgOrigin: `${centerEyeRight2.x} ${centerEyeRight2.y}`,
          rotation: -360,
          scrollTrigger: {
            start: 'top top',
            end: 'max',
            scrub: true
          }
        })
      }
    }
  }
}
