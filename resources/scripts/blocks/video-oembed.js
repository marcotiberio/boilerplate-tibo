/**
 * Video Oembed — Play button handler
 *
 * Ported from Flynt's BlockVideoOembed/script.js
 */

document.addEventListener('DOMContentLoaded', () => {
  const players = document.querySelectorAll('[data-block="video-oembed"] [data-ref="videoPlayer"]');

  players.forEach((player) => {
    const playButton = player.querySelector('[data-ref="playButton"]');
    const iframe = player.querySelector('iframe');

    if (playButton && iframe) {
      playButton.addEventListener('click', () => {
        // Add autoplay param to iframe src
        const src = iframe.getAttribute('src') || '';
        const separator = src.includes('?') ? '&' : '?';
        iframe.setAttribute('src', `${src}${separator}autoplay=1`);
        player.dataset.state = 'isPlaying';
      });
    }
  });
});
