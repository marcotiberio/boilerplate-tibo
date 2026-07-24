import Swiper from 'swiper'
import { Navigation, Pagination, A11y } from 'swiper/modules'
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
    modules: [Navigation, Pagination, A11y],
    slidesPerView: 1.2,
    spaceBetween: 24,
    watchOverflow: true,
    breakpoints: {
      780: {
        slidesPerView: 'auto',
        spaceBetween: 24
      }
    },
    navigation: {
      prevEl: refs.prev,
      nextEl: refs.next
    },
    pagination: {
      el: refs.pagination,
      clickable: true
    }
  }

  return new Swiper(refs.slider, config)
}
