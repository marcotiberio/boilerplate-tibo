import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

// Progressive word-by-word colour fill: the muted remainder of the quote
// brightens from off-white/30 to full off-white as the section scrolls
// through the viewport (scrubbed to the scroll position).
export default function init (node) {
  const fill = node.querySelector('[data-ref="quoteFill"]')
  if (!fill) return

  // Split the muted text into per-word spans, preserving whitespace.
  const text = fill.textContent
  fill.textContent = ''
  const words = []
  text.split(/(\s+)/).forEach((chunk) => {
    if (chunk === '') return
    if (/\S/.test(chunk)) {
      const span = document.createElement('span')
      span.textContent = chunk
      span.style.opacity = '0.3'
      fill.appendChild(span)
      words.push(span)
    } else {
      fill.appendChild(document.createTextNode(chunk))
    }
  })

  // Words now own their opacity, so the container can carry full colour.
  fill.classList.remove('text-off-white/30')
  fill.classList.add('text-off-white')

  if (!words.length) return

  // Respect reduced-motion: reveal everything, skip the scroll animation.
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    words.forEach((word) => { word.style.opacity = '1' })
    return
  }

  const tween = gsap.to(words, {
    opacity: 1,
    ease: 'none',
    stagger: 0.2,
    scrollTrigger: {
      trigger: node,
      start: 'center center+=400',
      end: 'bottom center+=300',
      scrub: true
    }
  })

  return () => {
    tween.scrollTrigger?.kill()
    tween.kill()
  }
}
