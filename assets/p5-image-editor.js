/* global p5, p5EditorData, jQuery */
;(function ($) {
  'use strict'

  // State
  let editorSketch = null
  let originalImage = null
  let currentTool = null

  /**
   * Open the WP media library to pick an image.
   */
  function openMediaLibrary () {
    const frame = wp.media({
      title: 'Select Image to Edit',
      button: { text: 'Edit This Image' },
      multiple: false,
      library: { type: 'image' }
    })

    frame.on('select', function () {
      const attachment = frame.state().get('selection').first().toJSON()
      const url = attachment.url
      startEditor(url)
    })

    frame.open()
  }

  /**
   * Start the p5.js editor with the given image URL.
   */
  function startEditor (imageUrl) {
    $('#p5-editor-source').hide()
    $('#p5-editor-canvas-wrap').show()

    // Destroy previous sketch if any
    if (editorSketch) {
      editorSketch.remove()
      editorSketch = null
    }

    const containerEl = document.getElementById('p5-canvas-container')
    containerEl.innerHTML = ''

    editorSketch = new p5(function (p) {
      // Editor state
      const MAX_WIDTH = 500
      let img = null
      let displayImg = null
      let historyStack = []
      let scale = 1
      let tool = null

      // Drawing state
      let isDrawing = false
      let drawColor = '#ff0000'
      let drawSize = 5
      let drawPaths = []
      let currentPath = []

      // Crop state
      let cropStart = null
      let cropEnd = null
      let isCropping = false

      // Text state
      let textPlaced = false

      p.preload = function () {
        img = p.loadImage(imageUrl)
      }

      p.setup = function () {
        const w = Math.min(img.width, MAX_WIDTH)
        scale = w / img.width
        const h = Math.round(img.height * scale)

        p.createCanvas(w, h)
        p.pixelDensity(1)

        // Work on a copy
        displayImg = img.get()
        pushHistory()
        renderImage()
      }

      p.draw = function () {
        // Only redraw when needed (on interaction)
      }

      // --- History ---
      function pushHistory () {
        // Store a copy of the current displayImg
        const copy = displayImg.get()
        historyStack.push(copy)
        // Keep max 30 history items
        if (historyStack.length > 30) {
          historyStack.shift()
        }
      }

      function undo () {
        if (historyStack.length > 1) {
          historyStack.pop()
          displayImg = historyStack[historyStack.length - 1].get()
          rebuildCanvas()
          renderImage()
        }
      }

      function resetImage () {
        displayImg = img.get()
        historyStack = []
        pushHistory()
        rebuildCanvas()
        renderImage()
        drawPaths = []
      }

      // --- Rendering ---
      function renderImage () {
        p.background(200)
        p.image(displayImg, 0, 0, p.width, p.height)

        // Draw current paths
        drawPaths.forEach(function (path) {
          drawPath(path)
        })

        // Draw active crop selection
        if (tool === 'crop' && cropStart && cropEnd) {
          p.noFill()
          p.stroke(0, 120, 255)
          p.strokeWeight(2)
          p.rect(
            cropStart.x, cropStart.y,
            cropEnd.x - cropStart.x, cropEnd.y - cropStart.y
          )
          // Dim outside area
          p.fill(0, 0, 0, 80)
          p.noStroke()
          // Top
          p.rect(0, 0, p.width, cropStart.y)
          // Bottom
          p.rect(0, cropEnd.y, p.width, p.height - cropEnd.y)
          // Left
          p.rect(0, cropStart.y, cropStart.x, cropEnd.y - cropStart.y)
          // Right
          p.rect(cropEnd.x, cropStart.y, p.width - cropEnd.x, cropEnd.y - cropStart.y)
        }
      }

      function drawPath (path) {
        if (path.points.length < 2) return
        p.stroke(path.color)
        p.strokeWeight(path.size)
        p.noFill()
        p.beginShape()
        path.points.forEach(function (pt) {
          p.curveVertex(pt.x, pt.y)
        })
        p.endShape()
      }

      function rebuildCanvas () {
        const w = Math.min(displayImg.width, MAX_WIDTH)
        const newScale = w / displayImg.width
        const h = Math.round(displayImg.height * newScale)
        scale = newScale
        p.resizeCanvas(w, h)
      }

      // --- Mouse interactions ---
      p.mousePressed = function () {
        if (!isInsideCanvas()) return

        if (tool === 'draw') {
          isDrawing = true
          currentPath = []
          currentPath.push({ x: p.mouseX, y: p.mouseY })
        } else if (tool === 'crop') {
          isCropping = true
          cropStart = { x: p.mouseX, y: p.mouseY }
          cropEnd = null
        } else if (tool === 'text') {
          placeText(p.mouseX, p.mouseY)
        }
      }

      p.mouseDragged = function () {
        if (!isInsideCanvas()) return

        if (tool === 'draw' && isDrawing) {
          currentPath.push({ x: p.mouseX, y: p.mouseY })
          renderImage()
          // Draw active stroke
          if (currentPath.length > 1) {
            p.stroke(drawColor)
            p.strokeWeight(drawSize)
            p.noFill()
            p.beginShape()
            currentPath.forEach(function (pt) {
              p.curveVertex(pt.x, pt.y)
            })
            p.endShape()
          }
        } else if (tool === 'crop' && isCropping) {
          cropEnd = { x: p.mouseX, y: p.mouseY }
          renderImage()
        }
      }

      p.mouseReleased = function () {
        if (tool === 'draw' && isDrawing) {
          isDrawing = false
          if (currentPath.length > 1) {
            drawPaths.push({
              points: currentPath.slice(),
              color: drawColor,
              size: drawSize
            })
          }
          currentPath = []
          renderImage()
        } else if (tool === 'crop' && isCropping) {
          isCropping = false
        }
      }

      function isInsideCanvas () {
        return p.mouseX >= 0 && p.mouseX <= p.width &&
               p.mouseY >= 0 && p.mouseY <= p.height
      }

      // --- Tool implementations ---
      function rotate90 () {
        flattenDrawings()
        const rotated = p.createGraphics(displayImg.height, displayImg.width)
        rotated.push()
        rotated.translate(rotated.width, 0)
        rotated.rotate(p.HALF_PI)
        rotated.image(displayImg, 0, 0)
        rotated.pop()
        displayImg = rotated.get()
        rotated.remove()
        pushHistory()
        rebuildCanvas()
        renderImage()
      }

      function flipHorizontal () {
        flattenDrawings()
        const flipped = p.createGraphics(displayImg.width, displayImg.height)
        flipped.push()
        flipped.translate(flipped.width, 0)
        flipped.scale(-1, 1)
        flipped.image(displayImg, 0, 0)
        flipped.pop()
        displayImg = flipped.get()
        flipped.remove()
        pushHistory()
        renderImage()
      }

      function flipVertical () {
        flattenDrawings()
        const flipped = p.createGraphics(displayImg.width, displayImg.height)
        flipped.push()
        flipped.translate(0, flipped.height)
        flipped.scale(1, -1)
        flipped.image(displayImg, 0, 0)
        flipped.pop()
        displayImg = flipped.get()
        flipped.remove()
        pushHistory()
        renderImage()
      }

      function applyCrop () {
        if (!cropStart || !cropEnd) return

        flattenDrawings()

        // Normalize coordinates
        const x1 = Math.min(cropStart.x, cropEnd.x)
        const y1 = Math.min(cropStart.y, cropEnd.y)
        const x2 = Math.max(cropStart.x, cropEnd.x)
        const y2 = Math.max(cropStart.y, cropEnd.y)

        // Convert from display coords to image coords
        const ix = Math.round(x1 / scale)
        const iy = Math.round(y1 / scale)
        const iw = Math.round((x2 - x1) / scale)
        const ih = Math.round((y2 - y1) / scale)

        if (iw < 10 || ih < 10) return

        displayImg = displayImg.get(ix, iy, iw, ih)
        cropStart = null
        cropEnd = null
        pushHistory()
        rebuildCanvas()
        renderImage()
      }

      function applyBrightness (amount) {
        flattenDrawings()
        displayImg.loadPixels()
        for (let i = 0; i < displayImg.pixels.length; i += 4) {
          displayImg.pixels[i] = p.constrain(displayImg.pixels[i] + amount, 0, 255)
          displayImg.pixels[i + 1] = p.constrain(displayImg.pixels[i + 1] + amount, 0, 255)
          displayImg.pixels[i + 2] = p.constrain(displayImg.pixels[i + 2] + amount, 0, 255)
        }
        displayImg.updatePixels()
        pushHistory()
        renderImage()
      }

      function applyGrayscale () {
        flattenDrawings()
        displayImg.loadPixels()
        for (let i = 0; i < displayImg.pixels.length; i += 4) {
          const avg = (displayImg.pixels[i] + displayImg.pixels[i + 1] + displayImg.pixels[i + 2]) / 3
          displayImg.pixels[i] = avg
          displayImg.pixels[i + 1] = avg
          displayImg.pixels[i + 2] = avg
        }
        displayImg.updatePixels()
        pushHistory()
        renderImage()
      }

      function applyBlur () {
        flattenDrawings()
        displayImg.filter(p.BLUR, 3)
        pushHistory()
        renderImage()
      }

      function placeText (x, y) {
        const textVal = $('#p5-text-input').val()
        if (!textVal) return

        flattenDrawings()

        const textColor = $('#p5-text-color').val()
        const textSize = parseInt($('#p5-text-size').val(), 10)

        // Draw text onto the image at full resolution
        const gfx = p.createGraphics(displayImg.width, displayImg.height)
        gfx.image(displayImg, 0, 0)
        gfx.fill(textColor)
        gfx.noStroke()
        gfx.textSize(Math.round(textSize / scale))
        gfx.textAlign(p.LEFT, p.TOP)
        gfx.text(textVal, Math.round(x / scale), Math.round(y / scale))

        displayImg = gfx.get()
        gfx.remove()
        pushHistory()
        renderImage()

        textPlaced = true
      }

      /**
       * Flatten any drawn paths onto the displayImg so transforms apply to them.
       */
      function flattenDrawings () {
        if (drawPaths.length === 0) return

        const gfx = p.createGraphics(displayImg.width, displayImg.height)
        gfx.image(displayImg, 0, 0)

        drawPaths.forEach(function (path) {
          if (path.points.length < 2) return
          gfx.stroke(path.color)
          gfx.strokeWeight(path.size / scale)
          gfx.noFill()
          gfx.beginShape()
          path.points.forEach(function (pt) {
            gfx.curveVertex(pt.x / scale, pt.y / scale)
          })
          gfx.endShape()
        })

        displayImg = gfx.get()
        gfx.remove()
        drawPaths = []
      }

      /**
       * Export the final image as a data URL at full resolution.
       */
      function exportImage () {
        flattenDrawings()
        // Create a full-res canvas to export
        const gfx = p.createGraphics(displayImg.width, displayImg.height)
        gfx.image(displayImg, 0, 0)
        const canvas = gfx.elt || gfx.canvas
        const dataUrl = canvas.toDataURL('image/png')
        gfx.remove()
        return dataUrl
      }

      // --- Expose methods to outer scope ---
      p._editor = {
        setTool: function (t) {
          tool = t
          cropStart = null
          cropEnd = null
          renderImage()
        },
        rotate90: rotate90,
        flipHorizontal: flipHorizontal,
        flipVertical: flipVertical,
        applyCrop: applyCrop,
        applyBrightness: applyBrightness,
        applyGrayscale: applyGrayscale,
        applyBlur: applyBlur,
        undo: undo,
        reset: resetImage,
        exportImage: exportImage,
        setDrawColor: function (c) { drawColor = c },
        setDrawSize: function (s) { drawSize = s }
      }
    }, containerEl)
  }

  /**
   * Close the editor.
   */
  function closeEditor () {
    if (editorSketch) {
      editorSketch.remove()
      editorSketch = null
    }
    $('#p5-editor-canvas-wrap').hide()
    $('#p5-editor-source').show()
    currentTool = null
    hideAllOptions()
  }

  /**
   * Save the edited image as featured image via AJAX.
   */
  function saveAsFeatured () {
    if (!editorSketch || !editorSketch._editor) return

    const $status = $('#p5-save-status')
    const $btn = $('#p5-save-featured')

    $status.text('Saving...')
    $btn.prop('disabled', true)

    const dataUrl = editorSketch._editor.exportImage()

    $.ajax({
      url: p5EditorData.ajaxUrl,
      type: 'POST',
      data: {
        action: 'p5_save_edited_image',
        nonce: p5EditorData.nonce,
        post_id: p5EditorData.postId,
        image_data: dataUrl
      },
      success: function (response) {
        if (response.success) {
          $status.text(response.data.message)
          // Update the thumbnail preview in the meta box
          const thumbHtml = '<p class="p5-current-thumb"><strong>Current featured image:</strong><br>' +
            '<img src="' + response.data.imageUrl + '" alt="" style="max-width:100%;height:auto;"></p>'
          $('#p5-editor-source .p5-current-thumb').remove()
          $('#p5-editor-source').prepend(thumbHtml)

          // Also update the WP native featured image box if present
          if (window.wp && wp.media && wp.media.featuredImage) {
            wp.media.featuredImage.set(response.data.attachmentId)
          }
        } else {
          $status.text('Error: ' + (response.data.message || 'Unknown error'))
        }
      },
      error: function () {
        $status.text('Network error. Please try again.')
      },
      complete: function () {
        $btn.prop('disabled', false)
      }
    })
  }

  // --- UI helpers ---
  function setActiveTool (toolName) {
    currentTool = toolName
    $('.p5-tool-btn').removeClass('active')
    $('.p5-tool-btn[data-tool="' + toolName + '"]').addClass('active')

    hideAllOptions()

    // Show tool-specific options
    const $panel = $('.p5-options-panel[data-for="' + toolName + '"]')
    if ($panel.length) {
      $('#p5-tool-options').show()
      $panel.show()
    }

    if (editorSketch && editorSketch._editor) {
      editorSketch._editor.setTool(toolName)
    }
  }

  function hideAllOptions () {
    $('#p5-tool-options').hide()
    $('.p5-options-panel').hide()
  }

  // --- Event bindings ---
  $(document).on('click', '#p5-select-image', function (e) {
    e.preventDefault()
    openMediaLibrary()
  })

  $(document).on('click', '.p5-tool-btn', function (e) {
    e.preventDefault()
    const tool = $(this).data('tool')

    // Instant actions
    if (tool === 'rotate' && editorSketch && editorSketch._editor) {
      editorSketch._editor.rotate90()
      return
    }
    if (tool === 'flip-h' && editorSketch && editorSketch._editor) {
      editorSketch._editor.flipHorizontal()
      return
    }
    if (tool === 'flip-v' && editorSketch && editorSketch._editor) {
      editorSketch._editor.flipVertical()
      return
    }
    if (tool === 'grayscale' && editorSketch && editorSketch._editor) {
      editorSketch._editor.applyGrayscale()
      return
    }
    if (tool === 'blur' && editorSketch && editorSketch._editor) {
      editorSketch._editor.applyBlur()
      return
    }
    if (tool === 'undo' && editorSketch && editorSketch._editor) {
      editorSketch._editor.undo()
      return
    }
    if (tool === 'reset' && editorSketch && editorSketch._editor) {
      editorSketch._editor.reset()
      return
    }

    // Toggle tools
    setActiveTool(tool)
  })

  $(document).on('click', '#p5-apply-crop', function (e) {
    e.preventDefault()
    if (editorSketch && editorSketch._editor) {
      editorSketch._editor.applyCrop()
      hideAllOptions()
      currentTool = null
      $('.p5-tool-btn').removeClass('active')
    }
  })

  $(document).on('click', '#p5-cancel-crop', function (e) {
    e.preventDefault()
    if (editorSketch && editorSketch._editor) {
      editorSketch._editor.setTool(null)
    }
    hideAllOptions()
    currentTool = null
    $('.p5-tool-btn').removeClass('active')
  })

  $(document).on('click', '#p5-apply-brightness', function (e) {
    e.preventDefault()
    if (editorSketch && editorSketch._editor) {
      const val = parseInt($('#p5-brightness-value').val(), 10)
      editorSketch._editor.applyBrightness(val)
      $('#p5-brightness-value').val(0)
    }
  })

  $(document).on('change input', '#p5-draw-color', function () {
    if (editorSketch && editorSketch._editor) {
      editorSketch._editor.setDrawColor($(this).val())
    }
  })

  $(document).on('change input', '#p5-draw-size', function () {
    if (editorSketch && editorSketch._editor) {
      editorSketch._editor.setDrawSize(parseInt($(this).val(), 10))
    }
  })

  $(document).on('click', '#p5-save-featured', function (e) {
    e.preventDefault()
    saveAsFeatured()
  })

  $(document).on('click', '#p5-close-editor', function (e) {
    e.preventDefault()
    closeEditor()
  })
})(jQuery)
