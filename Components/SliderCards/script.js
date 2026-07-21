import Swiper from 'swiper'
import { Navigation, A11y, Autoplay } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (el) {
  const refs = buildRefs(el)
  const data = getJSON(el)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

function initSlider (refs, data) {
  const { options = {} } = data
  const config = {
    modules: [Navigation, A11y, Autoplay],
    slidesPerView: 1.2,
    spaceBetween: 24,
    watchOverflow: true,
    navigation: {
      prevEl: refs.prev,
      nextEl: refs.next
    },
    breakpoints: {
      640: {
        slidesPerView: 1.2,
        spaceBetween: 24
      },
      780: {
        slidesPerView: 2.2,
        spaceBetween: 24
      },
      1180: {
        slidesPerView: 4,
        spaceBetween: 24
      }
    }
  }

  if (options.autoplay && options.autoplaySpeed) {
    config.autoplay = {
      delay: options.autoplaySpeed
    }
  }

  return new Swiper(refs.slider, config)
}
