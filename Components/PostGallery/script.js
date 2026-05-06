import Swiper from 'swiper'
import { Navigation, A11y, Pagination, Keyboard } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default function (postGallery) {
  const refs = buildRefs(postGallery)
  const slides = refs.slider.querySelectorAll('.swiper-slide')
  if (slides.length <= 1) return () => {}

  const swiper = new Swiper(refs.slider, {
    modules: [Navigation, A11y, Pagination, Keyboard],
    slidesPerView: 'auto',
    spaceBetween: 20,
    loop: slides.length > 1,
    keyboard: { enabled: true },
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
    pagination: {
      el: refs.dots,
      type: 'bullets',
      clickable: true
    },
  })

  return () => swiper.destroy()
}
