// import './scripts/publicPath'
if (import.meta.env.DEV) {
  import('@vite/client')
}

/**
 * ACF Color Restrict Integration
 * 
 * Colors are read from theme.json and made available to ACF Color Restrict plugin.
 * This script provides an additional JavaScript approach for ACF color picker customization.
 */

// Apply theme colors to ACF color picker via JavaScript
if (typeof acf !== 'undefined' && typeof jQuery !== 'undefined') {
  // Method 1: Use localized colors from PHP (reads from theme.json)
  acf.add_filter('color_picker_args', function (args, $field) {
    if (window.FlyntThemeColors && window.FlyntThemeColors.palette) {
      const colors = window.FlyntThemeColors.palette.map(item => {
        return typeof item === 'object' ? item.color : item
      })
      args.palettes = colors
    }
    return args
  })
  
  // Method 2: Try to get colors from WordPress block editor settings (if available)
  if (typeof wp !== 'undefined' && wp.data && wp.data.select) {
    try {
      const editorSettings = wp.data.select('core/editor')?.getEditorSettings()
      if (editorSettings && editorSettings.colors) {
        acf.add_filter('color_picker_args', function (args, $field) {
          args.palettes = editorSettings.colors.map(color => color.color)
          return args
        }, 20) // Higher priority to override if needed
      }
    } catch (e) {
      // Block editor not available, use localized colors
    }
  }
}

/**
 * Character limit for ACF link fields.
 *
 * The link title is edited in the shared WordPress link modal (#wp-link-text),
 * so the limit has to be read from the field being edited each time the modal
 * opens. It comes from the `maxlength` key on the field definition, mirrored to
 * the wrapper as `data-maxlength` in inc/acf.php.
 */
if (typeof acf !== 'undefined' && typeof jQuery !== 'undefined') {
  jQuery(document).on('wplink-open', () => {
    const node = acf.wpLink && acf.wpLink.get('node')
    const maxlength = node ? node.closest('.acf-field-link').data('maxlength') : null
    jQuery('#wp-link-text').attr('maxlength', maxlength || null)
  })
}

/**
 * Character limit for the built-in WordPress caption of media files.
 *
 * The caption input is rendered by core in places that can't be filtered from
 * PHP (the Backbone media modal templates, the Edit Media form), and the modal
 * re-renders it on every selection, so the `maxlength` is set when a caption
 * field is focused. The limit comes from inc/mediaCaptionLimit.php.
 */
if (window.FlyntMediaCaption && window.FlyntMediaCaption.maxLength) {
  const captionSelector = [
    '#attachment_caption', // Edit Media screen
    '#attachment-details-caption', // Media modal sidebar
    '#attachment-details-two-column-caption', // Media library grid modal
    '#image-details-caption', // Image details modal
    '#embed-image-settings-caption', // Image settings on insert
    'input.describe[data-setting="caption"]', // Uploader list view
    'textarea[name$="[post_excerpt]"]' // Legacy attachment fields
  ].join(',')

  document.addEventListener('focusin', ({ target }) => {
    if (target.matches && target.matches(captionSelector)) {
      target.setAttribute('maxlength', window.FlyntMediaCaption.maxLength)
    }
  })
}

import.meta.glob('../Components/*/admin.js', { eager: true })
