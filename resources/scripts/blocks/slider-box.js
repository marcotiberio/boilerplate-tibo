/**
 * Slider Box — Swiper carousel
 *
 * Ported from Flynt's SliderBox/script.js
 */

import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', () => {
  const sliders = document.querySelectorAll('[data-block="slider-box"] [data-ref="slider"]');

  sliders.forEach((slider) => {
    const block = slider.closest('[data-block="slider-box"]');
    const scriptTag = block?.querySelector('script[type="application/json"]');
    let options = {};
    if (scriptTag) {
      try {
        const parsed = JSON.parse(scriptTag.textContent);
        options = parsed.options || {};
      } catch (e) {
        // ignore
      }
    }

    const swiperConfig = {
      modules: [Autoplay, Pagination],
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      pagination: {
        el: block?.querySelector('[data-ref="dots"]'),
        type: 'fraction',
      },
      breakpoints: {
        1024: {
          slidesPerView: 2,
        },
      },
    };

    if (options.autoplay) {
      swiperConfig.autoplay = {
        delay: options.autoplaySpeed || 4000,
        disableOnInteraction: false,
      };
    }

    new Swiper(slider, swiperConfig);
  });
});
