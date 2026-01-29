import Swiper from 'swiper'
import { EffectCards, A11y, Autoplay, Pagination } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (sliderCards) {
  const refs = buildRefs(sliderCards)
  const data = getJSON(sliderCards)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

function escapeHtml (text) {
  const div = document.createElement('div')
  div.textContent = text
  return div.innerHTML
}

function initSlider (refs, data) {
  const { options, rows = [] } = data
  
  const config = {
    modules: [EffectCards, A11y, Autoplay, Pagination],
    a11y: options.a11y,
    effect: 'cards',
    cardsEffect: {
      rotate: true,
      perSlideRotate: 2,
      perSlideOffset: 3,
      slideShadows: false
    },
    grabCursor: true,
    slidesPerView: 1,
    spaceBetween: 0,
    pagination: {
      el: refs.dots,
      type: 'bullets',
      clickable: true,
      bulletClass: 'swiper-pagination-bullet slider-pagination-bullet-custom',
      bulletActiveClass: 'swiper-pagination-bullet-active slider-pagination-bullet-custom-active',
      renderBullet (index, className) {
        const row = rows[index] || {}
        // Check if this bullet is active (first slide is active by default)
        const isActive = index === 0
        const title = row.title
          ? `<div class="slider-pagination-bullet-title font-h3">${escapeHtml(row.title)}</div>`
          : ''
        // Only show content for active bullet
        const content = (isActive && row.contentHtml)
          ? `<div class="slider-pagination-bullet-content wysiwyg">${row.contentHtml}</div>`
          : ''
        return `<div class="${className}" role="button" tabindex="0" aria-label="Go to card ${index + 1}">${title}${content}</div>`
      }
    }
  }
  if (options.autoplay && options.autoplaySpeed) {
    config.autoplay = {
      delay: options.autoplaySpeed
    }
  }

  const swiper = new Swiper(refs.slider, config)

  // Update pagination bullets on slide change to show/hide content
  const updatePaginationContent = () => {
    const activeIndex = swiper.activeIndex
    const bullets = refs.dots.querySelectorAll('.slider-pagination-bullet-custom')
    bullets.forEach((bullet, index) => {
      const row = rows[index] || {}
      const isActive = index === activeIndex
      let contentEl = bullet.querySelector('.slider-pagination-bullet-content')
      
      if (isActive && row.contentHtml) {
        // Add content if active and content exists
        if (!contentEl) {
          contentEl = document.createElement('div')
          contentEl.className = 'slider-pagination-bullet-content wysiwyg'
          bullet.appendChild(contentEl)
        }
        contentEl.innerHTML = row.contentHtml
      } else if (!isActive && contentEl) {
        // Remove content if inactive
        contentEl.remove()
      }
    })
  }

  swiper.on('slideChange', updatePaginationContent)
  // Initial update in case Swiper doesn't start at index 0
  updatePaginationContent()

  return () => swiper.destroy()
}
