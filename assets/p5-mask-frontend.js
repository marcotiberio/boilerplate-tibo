/* global p5, p5MaskFrontend */

/**
 * Frontend alpha-mask renderer.
 * Finds the post-thumbnail <img> on the page, replaces it with a p5.js canvas
 * that renders the featured image with the saved mask applied.
 */
;(function () {
  'use strict'

  if (!window.p5MaskFrontend) return

  var imageUrl = p5MaskFrontend.imageUrl
  var params = p5MaskFrontend.maskParams

  if (!imageUrl || !params || !params.preset) return

  // ---------- Mask generation (same logic as admin) ----------

  function computeAlpha (x, y, w, h, preset, params) {
    switch (preset) {
      case 'radial': return alphaRadial(x, y, w, h, params)
      case 'linear': return alphaLinear(x, y, w, h, params)
      case 'diagonal': return alphaDiagonal(x, y, w, h, params)
      case 'corner': return alphaCorner(x, y, w, h, params)
      case 'split': return alphaSplit(x, y, w, h, params)
      default: return 255
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
    var dirX = Math.cos(angle)
    var dirY = Math.sin(angle)
    var maxProj = dirX * w + dirY * h
    var proj = (dirX * x + dirY * y)
    var norm = maxProj !== 0 ? proj / Math.abs(maxProj) : 0
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
    if (side === 'first') {
      if (norm <= gradStart) return 0
      if (norm >= gradEnd) return 255
      return Math.round(255 * ((norm - gradStart) / (gradEnd - gradStart)))
    }
    if (norm <= gradStart) return 255
    if (norm >= gradEnd) return 0
    return Math.round(255 * (1 - (norm - gradStart) / (gradEnd - gradStart)))
  }

  // ---------- Find and replace the featured image ----------

  function init () {
    // Look for the post-thumbnail image
    var targets = document.querySelectorAll('.post-thumbnail img, .wp-post-image, [class*="featured"] img')
    if (!targets.length) return

    targets.forEach(function (imgEl) {
      var parent = imgEl.parentElement
      if (!parent) return

      // Create a container for the p5 canvas
      var container = document.createElement('div')
      container.className = 'p5-mask-frontend-canvas'
      container.style.width = imgEl.offsetWidth ? imgEl.offsetWidth + 'px' : '100%'
      container.style.lineHeight = '0'

      // Hide original image
      imgEl.style.display = 'none'
      parent.insertBefore(container, imgEl)

      // Launch p5 sketch
      new p5(function (p) { // eslint-disable-line no-new
        var img = null

        p.preload = function () {
          img = p.loadImage(imageUrl)
        }

        p.setup = function () {
          var displayW = container.offsetWidth || img.width
          var scale = displayW / img.width
          var displayH = Math.round(img.height * scale)

          p.createCanvas(displayW, displayH)
          p.pixelDensity(1)
          p.noLoop()

          // Generate mask at image's native resolution
          var maskGfx = p.createGraphics(img.width, img.height)
          maskGfx.pixelDensity(1)
          maskGfx.loadPixels()

          var inv = params.invert === true || params.invert === 'true' || params.invert === '1'
          var w = img.width
          var h = img.height

          for (var y = 0; y < h; y++) {
            for (var x = 0; x < w; x++) {
              var i = (y * w + x) * 4
              var a = computeAlpha(x, y, w, h, params.preset, params)
              if (inv) a = 255 - a
              maskGfx.pixels[i] = a
              maskGfx.pixels[i + 1] = a
              maskGfx.pixels[i + 2] = a
              maskGfx.pixels[i + 3] = 255
            }
          }
          maskGfx.updatePixels()

          var masked = img.get()
          masked.mask(maskGfx.get())
          maskGfx.remove()

          p.clear()
          p.image(masked, 0, 0, p.width, p.height)
        }

        p.draw = function () {}
      }, container)
    })
  }

  // Run when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
  } else {
    init()
  }
})()
