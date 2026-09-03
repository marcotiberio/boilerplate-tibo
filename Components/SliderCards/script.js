import Swiper from 'swiper'
import { Navigation, A11y } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (el) {
  const refs = buildRefs(el)
  const data = getJSON(el)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

// ACF selects arrive as strings ('2.2'); fall back to the design default when
// the field is empty or unparseable.
function slidesPerView (value, fallback) {
  const parsed = parseFloat(value)
  return Number.isNaN(parsed) ? fallback : parsed
}

function initSlider (refs, data) {
  const { options = {} } = data
  const gap = 24
  const mobile = slidesPerView(options.slidesMobile, 1.2)
  const tablet = slidesPerView(options.slidesTablet, 2.2)
  const desktop = slidesPerView(options.slidesDesktop, 4)

  const config = {
    modules: [Navigation, A11y],
    slidesPerView: mobile,
    spaceBetween: gap,
    watchOverflow: true,
    navigation: {
      prevEl: refs.prev,
      nextEl: refs.next
    },
    breakpoints: {
      640: {
        slidesPerView: mobile,
        spaceBetween: gap
      },
      780: {
        slidesPerView: tablet,
        spaceBetween: gap
      },
      1180: {
        slidesPerView: desktop,
        spaceBetween: gap
      }
    }
  }

  return new Swiper(refs.slider, config)
}
