import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'
import { buildRefs } from '@/assets/scripts/helpers.js'

gsap.registerPlugin(ScrollTrigger)

const VIEWPORT_CENTER_RATIO = 0.5
const STAT_CHANGE_DURATION = 0.25

export default function (blockStats) {
  const refs = buildRefs(blockStats, false)
  const statNumber = refs.statNumber
  const statIcon = refs.statIcon
  const items = blockStats.querySelectorAll('[data-refs="item"]')

  if (!items.length || !statNumber) return

  let lastActiveIndex = 0

  function getViewportCenter () {
    return window.innerHeight * VIEWPORT_CENTER_RATIO
  }

  function getActiveIndex () {
    const vCenter = getViewportCenter()
    const blockRect = blockStats.getBoundingClientRect()
    if (blockRect.bottom < vCenter - 100 || blockRect.top > vCenter + window.innerHeight) {
      return lastActiveIndex
    }
    let bestIndex = 0
    let bestDistance = Infinity
    items.forEach((item, i) => {
      const rect = item.getBoundingClientRect()
      const itemCenter = rect.top + rect.height * 0.5
      const distance = Math.abs(itemCenter - vCenter)
      if (distance < bestDistance) {
        bestDistance = distance
        bestIndex = i
      }
    })
    return bestIndex
  }

  function updateActiveStat (index) {
    if (index === lastActiveIndex) return
    lastActiveIndex = index
    const item = items[index]
    if (!item) return
    const stat = item.getAttribute('data-stat')
    const iconSrc = item.getAttribute('data-icon-src')

    if (stat != null) statNumber.textContent = stat
    gsap.fromTo(statNumber, { y: 8, opacity: 0 }, { y: 0, opacity: 1, duration: STAT_CHANGE_DURATION, ease: 'power2.out' })

    if (statIcon && statIcon.tagName === 'IMG') {
      if (iconSrc) {
        gsap.fromTo(statIcon, { scale: 0.9, opacity: 0 }, { scale: 1, opacity: 1, duration: STAT_CHANGE_DURATION, ease: 'power2.out' })
        statIcon.src = iconSrc
        statIcon.classList.remove('hidden')
        statIcon.style.display = ''
      } else {
        gsap.to(statIcon, { scale: 0.9, opacity: 0, duration: STAT_CHANGE_DURATION * 0.5, onComplete: () => {
          statIcon.classList.add('hidden')
          statIcon.style.display = 'none'
        } })
      }
    }

    items.forEach((el, i) => el.classList.toggle('is-active', i === index))
  }

  let ticking = false
  function onScroll () {
    if (ticking) return
    ticking = true
    requestAnimationFrame(() => {
      const index = getActiveIndex()
      updateActiveStat(index)
      ticking = false
    })
  }

  window.addEventListener('scroll', onScroll, { passive: true })
  window.addEventListener('resize', onScroll, { passive: true })

  const initialIndex = getActiveIndex()
  updateActiveStat(initialIndex)

  return () => {
    window.removeEventListener('scroll', onScroll)
    window.removeEventListener('resize', onScroll)
  }
}
