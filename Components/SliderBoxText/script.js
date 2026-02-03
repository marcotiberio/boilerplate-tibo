import Swiper from 'swiper'
import { Navigation, A11y, Autoplay, Pagination, EffectFade } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (sliderBoxText) {
  const refs = buildRefs(sliderBoxText)
  const data = getJSON(sliderBoxText)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

function initSlider (refs, data) {
  const { options } = data
  const config = {
    modules: [Navigation, A11y, Autoplay, Pagination, EffectFade],
    effect: 'fade',
    fadeEffect: {
      crossFade: true
    },
    a11y: options.a11y,
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
    pagination: {
      el: refs.dots,
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 0
      },
      1181: {
        slidesPerView: 1,
        spaceBetween: 0
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
