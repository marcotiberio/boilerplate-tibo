/* global p5, p5MaskData, jQuery */
;(function ($) {
  'use strict'

  var sketch = null

  // ---------- Mask generation (shared logic) ----------

  /**
   * Generate a mask p5.Graphics for a given preset and params.
   * Returns a p5.Graphics of size w × h with white = opaque, black = transparent.
   * After calling .mask(), p5 uses the *alpha* channel, so we draw in grayscale
   * where white (255) = fully visible, black (0) = fully transparent.
   */
  function generateMask (p, w, h, preset, params) {
    var gfx = p.createGraphics(w, h)
    gfx.pixelDensity(1)
    gfx.loadPixels()

    var inv = params.invert === true || params.invert === 'true' || params.invert === '1'
    var i, x, y, d, alpha

    for (y = 0; y < h; y++) {
      for (x = 0; x < w; x++) {
        i = (y * w + x) * 4
        alpha = computeAlpha(x, y, w, h, preset, params)
        if (inv) alpha = 255 - alpha
        gfx.pixels[i] = 255
        gfx.pixels[i + 1] = 255
        gfx.pixels[i + 2] = 255
        gfx.pixels[i + 3] = alpha
      }
    }

    gfx.updatePixels()
    return gfx
  }

  /**
   * Compute the alpha value (0–255) for a single pixel.
   */
  function computeAlpha (x, y, w, h, preset, params) {
    switch (preset) {
      case 'radial':
        return alphaRadial(x, y, w, h, params)
      case 'linear':
        return alphaLinear(x, y, w, h, params)
      case 'diagonal':
        return alphaDiagonal(x, y, w, h, params)
      case 'corner':
        return alphaCorner(x, y, w, h, params)
      case 'split':
        return alphaSplit(x, y, w, h, params)
      default:
        return 255
    }
  }

  function alphaRadial (x, y, w, h, params) {
    var cx = (parseFloat(params.centerX) || 50) / 100 * w
    var cy = (parseFloat(params.centerY) || 50) / 100 * h
    var maxDim = Math.max(w, h)
    var r = (parseFloat(params.radius) || 50) / 100 * maxDim
    var softness = (parseFloat(params.softness) || 40) / 100

    var d = Math.sqrt((x - cx) * (x - cx) + (y - cy) * (y - cy))
    var innerR = r * (1 - softness)

    if (d <= innerR) return 255
    if (d >= r) return 0
    return Math.round(255 * (1 - (d - innerR) / (r - innerR)))
  }

  function alphaLinear (x, y, w, h, params) {
    var angle = (parseFloat(params.angle) || 180) * Math.PI / 180
    var position = (parseFloat(params.position) || 50) / 100
    var spread = (parseFloat(params.spread) || 50) / 100

    // Project point onto angle direction
    var dirX = Math.cos(angle)
    var dirY = Math.sin(angle)
    var maxProj = dirX * w + dirY * h
    var proj = (dirX * x + dirY * y)
    var norm = maxProj !== 0 ? proj / Math.abs(maxProj) : 0

    // Remap so position is the center of the gradient
    var gradStart = position - spread / 2
    var gradEnd = position + spread / 2

    if (norm <= gradStart) return 255
    if (norm >= gradEnd) return 0
    return Math.round(255 * (1 - (norm - gradStart) / (gradEnd - gradStart)))
  }

  function alphaDiagonal (x, y, w, h, params) {
    var dir = params.direction || 'tl-br'
    var spread = (parseFloat(params.spread) || 50) / 100

    var nx = x / w
    var ny = y / h
    var d

    switch (dir) {
      case 'tl-br': d = (nx + ny) / 2; break
      case 'tr-bl': d = ((1 - nx) + ny) / 2; break
      case 'bl-tr': d = (nx + (1 - ny)) / 2; break
      case 'br-tl': d = ((1 - nx) + (1 - ny)) / 2; break
      default: d = (nx + ny) / 2
    }

    var gradStart = 0.5 - spread / 2
    var gradEnd = 0.5 + spread / 2

    if (d <= gradStart) return 255
    if (d >= gradEnd) return 0
    return Math.round(255 * (1 - (d - gradStart) / (gradEnd - gradStart)))
  }

  function alphaCorner (x, y, w, h, params) {
    var corner = params.corner || 'tl'
    var maxDim = Math.max(w, h)
    var r = (parseFloat(params.radius) || 50) / 100 * maxDim * 1.5
    var softness = (parseFloat(params.softness) || 40) / 100

    var cx, cy
    switch (corner) {
      case 'tl': cx = 0; cy = 0; break
      case 'tr': cx = w; cy = 0; break
      case 'bl': cx = 0; cy = h; break
      case 'br': cx = w; cy = h; break
      default: cx = 0; cy = 0
    }

    var d = Math.sqrt((x - cx) * (x - cx) + (y - cy) * (y - cy))
    var innerR = r * (1 - softness)

    if (d <= innerR) return 255
    if (d >= r) return 0
    return Math.round(255 * (1 - (d - innerR) / (r - innerR)))
  }

  function alphaSplit (x, y, w, h, params) {
    var orientation = params.orientation || 'horizontal'
    var position = (parseFloat(params.position) || 50) / 100
    var spread = (parseFloat(params.spread) || 30) / 100
    var side = params.side || 'first'

    var norm = orientation === 'horizontal' ? y / h : x / w
    var gradStart = position - spread / 2
    var gradEnd = position + spread / 2

    var alpha
    if (side === 'first') {
      // First half fades out
      if (norm <= gradStart) alpha = 0
      else if (norm >= gradEnd) alpha = 255
      else alpha = Math.round(255 * ((norm - gradStart) / (gradEnd - gradStart)))
    } else {
      // Second half fades out
      if (norm <= gradStart) alpha = 255
      else if (norm >= gradEnd) alpha = 0
      else alpha = Math.round(255 * (1 - (norm - gradStart) / (gradEnd - gradStart)))
    }
    return alpha
  }

  // ---------- Collect current params from the UI ----------

  function collectParams () {
    var preset = $('.p5-preset-btn.active').data('preset') || 'radial'
    var params = { preset: preset }

    // Collect params from the visible group
    $('.p5-param-group[data-for="' + preset + '"] .p5-param').each(function () {
      var key = $(this).data('param')
      var val = $(this).is('select') ? $(this).val() : $(this).val()
      params[key] = val
    })

    // Global params
    params.invert = $('#p5-mask-invert').is(':checked')

    return params
  }

  // ---------- p5 sketch ----------

  function startSketch (imageUrl) {
    if (sketch) {
      sketch.remove()
      sketch = null
    }

    var container = document.getElementById('p5-mask-canvas-container')
    container.innerHTML = ''

    sketch = new p5(function (p) {
      var MAX_WIDTH = 460
      var img = null
      var scale = 1

      p.preload = function () {
        img = p.loadImage(imageUrl)
      }

      p.setup = function () {
        var w = Math.min(img.width, MAX_WIDTH)
        scale = w / img.width
        var h = Math.round(img.height * scale)

        p.createCanvas(w, h)
        p.pixelDensity(1)
        p.noLoop()
        renderMasked()
      }

      p.draw = function () {}

      function renderMasked () {
        var params = collectParams()
        var w = img.width
        var h = img.height

        // Generate the mask at full resolution
        var maskGfx = generateMask(p, w, h, params.preset, params)

        // Clone image and apply mask
        var masked = img.get()
        masked.mask(maskGfx.get())
        maskGfx.remove()

        // Draw checkerboard then masked image
        p.background(200)
        drawCheckerboard(p)
        p.image(masked, 0, 0, p.width, p.height)
      }

      function drawCheckerboard (p) {
        var size = 10
        for (var y = 0; y < p.height; y += size) {
          for (var x = 0; x < p.width; x += size) {
            var isLight = ((x / size + y / size) % 2) < 1
            p.noStroke()
            p.fill(isLight ? 220 : 190)
            p.rect(x, y, size, size)
          }
        }
      }

      // Expose update + export
      p._mask = {
        update: function () {
          renderMasked()
        },
        exportImage: function () {
          var params = collectParams()
          var w = img.width
          var h = img.height

          var maskGfx = generateMask(p, w, h, params.preset, params)
          var masked = img.get()
          masked.mask(maskGfx.get())
          maskGfx.remove()

          // Render at full resolution
          var gfx = p.createGraphics(w, h)
          gfx.pixelDensity(1)
          gfx.image(masked, 0, 0)
          var canvas = gfx.elt || gfx.canvas
          var dataUrl = canvas.toDataURL('image/png')
          gfx.remove()
          return dataUrl
        }
      }
    }, container)
  }

  function updatePreview () {
    if (sketch && sketch._mask) {
      sketch._mask.update()
    }
  }

  // ---------- UI bindings ----------

  // Open editor
  $(document).on('click', '#p5-open-mask-editor', function (e) {
    e.preventDefault()
    var wrap = $('#p5-mask-editor-wrap')
    var thumbUrl = wrap.data('thumb-url')
    if (!thumbUrl) return

    // Restore saved params if any
    var saved = wrap.data('saved-mask')
    if (saved && typeof saved === 'string') {
      try { saved = JSON.parse(saved) } catch (e) { saved = null }
    }
    if (saved && saved.preset) {
      restoreParams(saved)
    }

    $('#p5-mask-source').hide()
    $('#p5-mask-editor').show()
    startSketch(thumbUrl)
  })

  // Close editor
  $(document).on('click', '#p5-mask-close', function (e) {
    e.preventDefault()
    if (sketch) { sketch.remove(); sketch = null }
    $('#p5-mask-editor').hide()
    $('#p5-mask-source').show()
    $('#p5-mask-status').text('')
  })

  // Preset selection
  $(document).on('click', '.p5-preset-btn', function (e) {
    e.preventDefault()
    var preset = $(this).data('preset')
    $('.p5-preset-btn').removeClass('active')
    $(this).addClass('active')
    // Show/hide param groups
    $('.p5-param-group').hide()
    $('.p5-param-group[data-for="' + preset + '"]').show()
    updatePreview()
  })

  // Parameter changes
  $(document).on('input change', '.p5-param', function () {
    updatePreview()
  })

  // Bake & save as featured image
  $(document).on('click', '#p5-mask-save-bake', function (e) {
    e.preventDefault()
    if (!sketch || !sketch._mask) return

    var $btn = $(this)
    var $status = $('#p5-mask-status')
    $btn.prop('disabled', true)
    $status.text('Baking...')

    var dataUrl = sketch._mask.exportImage()

    $.ajax({
      url: p5MaskData.ajaxUrl,
      type: 'POST',
      data: {
        action: 'p5_bake_masked_image',
        nonce: p5MaskData.nonce,
        post_id: p5MaskData.postId,
        image_data: dataUrl
      },
      success: function (res) {
        if (res.success) {
          $status.text(res.data.message)
          // Update thumbnail preview
          var thumbHtml = '<p class="p5-current-thumb"><strong>Featured image:</strong><br>' +
            '<img src="' + res.data.imageUrl + '" alt="" style="max-width:100%;height:auto;"></p>'
          $('#p5-mask-source .p5-current-thumb').remove()
          $('#p5-mask-source').prepend(thumbHtml)
          // Update WP featured image box
          if (window.wp && wp.media && wp.media.featuredImage) {
            wp.media.featuredImage.set(res.data.attachmentId)
          }
        } else {
          $status.text('Error: ' + (res.data.message || 'Unknown error'))
        }
      },
      error: function () { $status.text('Network error.') },
      complete: function () { $btn.prop('disabled', false) }
    })
  })

  // Save mask params for frontend rendering
  $(document).on('click', '#p5-mask-save-live', function (e) {
    e.preventDefault()
    var $btn = $(this)
    var $status = $('#p5-mask-status')
    $btn.prop('disabled', true)
    $status.text('Saving...')

    var params = collectParams()

    $.ajax({
      url: p5MaskData.ajaxUrl,
      type: 'POST',
      data: {
        action: 'p5_save_mask_params',
        nonce: p5MaskData.nonce,
        post_id: p5MaskData.postId,
        mask_params: JSON.stringify(params)
      },
      success: function (res) {
        $status.text(res.success ? res.data.message : 'Error: ' + (res.data.message || 'Unknown'))
      },
      error: function () { $status.text('Network error.') },
      complete: function () { $btn.prop('disabled', false) }
    })
  })

  // Remove mask
  $(document).on('click', '#p5-mask-remove', function (e) {
    e.preventDefault()
    var $status = $('#p5-mask-status')
    $status.text('Removing...')

    $.ajax({
      url: p5MaskData.ajaxUrl,
      type: 'POST',
      data: {
        action: 'p5_remove_mask',
        nonce: p5MaskData.nonce,
        post_id: p5MaskData.postId
      },
      success: function (res) {
        $status.text(res.success ? res.data.message : 'Error')
        // Reset the saved data attribute
        $('#p5-mask-editor-wrap').data('saved-mask', '')
      },
      error: function () { $status.text('Network error.') }
    })
  })

  // Restore saved params to the UI controls
  function restoreParams (params) {
    if (!params || !params.preset) return

    // Activate preset
    $('.p5-preset-btn').removeClass('active')
    $('.p5-preset-btn[data-preset="' + params.preset + '"]').addClass('active')
    $('.p5-param-group').hide()
    $('.p5-param-group[data-for="' + params.preset + '"]').show()

    // Set values
    Object.keys(params).forEach(function (key) {
      if (key === 'preset') return
      if (key === 'invert') {
        $('#p5-mask-invert').prop('checked',
          params.invert === true || params.invert === 'true' || params.invert === '1')
        return
      }
      var $el = $('.p5-param-group[data-for="' + params.preset + '"] .p5-param[data-param="' + key + '"]')
      if ($el.length) $el.val(params[key])
    })
  }
})(jQuery)
