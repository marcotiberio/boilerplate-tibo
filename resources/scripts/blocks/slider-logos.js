/**
 * Slider Logos — Marquee animation
 *
 * Ported from Flynt's BlockSliderLogos/script.js
 * Creates an infinite scrolling marquee by duplicating content.
 */

document.addEventListener('DOMContentLoaded', () => {
  const marquees = document.querySelectorAll('[data-block="slider-logos"] [data-ref="marquee"]');

  marquees.forEach((marquee) => {
    const content = marquee.querySelector('[data-ref="marqueeContent"]');
    if (!content) return;

    // Read options from JSON script tag
    const block = marquee.closest('[data-block="slider-logos"]');
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

    // Duplicate content for seamless loop
    const clone = content.cloneNode(true);
    content.parentElement?.appendChild(clone);

    // Set marquee speed
    const speed = options.autoplaySpeed || 250;
    const duration = Math.max(5, (content.children.length * speed) / 1000);
    marquee.style.setProperty('--marquee-duration', `${duration}s`);
  });
});
