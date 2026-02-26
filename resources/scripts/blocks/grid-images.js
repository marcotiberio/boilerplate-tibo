/**
 * Grid Images — Lightbox functionality
 *
 * Ported from Flynt's GridImages/script.js
 */

document.addEventListener('DOMContentLoaded', () => {
  const grids = document.querySelectorAll('[data-block="grid-images"]');

  grids.forEach((grid) => {
    const items = grid.querySelectorAll('[data-image-index]');

    items.forEach((item) => {
      item.addEventListener('click', () => {
        const src = item.querySelector('img')?.dataset.lightboxSrc;
        if (src) {
          openLightbox(src, items, parseInt(item.dataset.imageIndex, 10));
        }
      });
    });
  });
});

function openLightbox(src, allItems, currentIndex) {
  const overlay = document.createElement('div');
  overlay.className = 'lightbox-overlay';
  overlay.style.cssText = `
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,0.9); display: flex;
    align-items: center; justify-content: center;
    cursor: pointer;
  `;

  const img = document.createElement('img');
  img.src = src;
  img.style.cssText = 'max-width: 90vw; max-height: 90vh; object-fit: contain;';

  overlay.appendChild(img);
  document.body.appendChild(overlay);
  document.body.style.overflow = 'hidden';

  overlay.addEventListener('click', () => {
    overlay.remove();
    document.body.style.overflow = '';
  });

  document.addEventListener('keydown', function handler(e) {
    if (e.key === 'Escape') {
      overlay.remove();
      document.body.style.overflow = '';
      document.removeEventListener('keydown', handler);
    }
  });
}
