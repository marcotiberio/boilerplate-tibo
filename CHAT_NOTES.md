# Chat Notes — p5.js WordPress Image Editor

## Project Overview

Building a **p5.js-powered image editor** as a WordPress/Flynt component for this Flynt-based theme. The editor allows users to apply alpha masks to images with configurable presets and parameters.

## Architecture Decisions

### p5.js Usage: Hybrid Approach

The implementation uses **standard p5.js APIs** for core image operations, combined with **custom-written mask generation math**.

**Straight p5.js (used as-is):**
- `p.createGraphics(w, h)` — offscreen buffer creation
- `gfx.loadPixels()` / `gfx.updatePixels()` — direct pixel access
- `img.get()` — image cloning
- `masked.mask(maskGfx.get())` — alpha masking (same pattern as the [p5.js alpha mask example](https://p5js.org/examples/imported-media-alpha-mask/))
- `p.image()`, `p.createCanvas()`, `p.noLoop()` — standard drawing

**Custom code (written from scratch):**
- `computeAlpha()` functions: `alphaRadial`, `alphaLinear`, `alphaDiagonal`, `alphaCorner`, `alphaSplit`
- These generate masks dynamically based on slider values (the p5.js example uses a pre-made PNG; we generate masks on the fly)
- Gradient/shape math for each preset
- Parameter-to-pixel mapping
- Preset system with configurable sliders

### Mask Presets

Five mask types implemented:
1. **Radial** — circular gradient from center (inner/outer radius)
2. **Linear** — horizontal/vertical gradient
3. **Diagonal** — angled gradient
4. **Corner** — gradient from a corner
5. **Split** — hard or soft split

Each preset has sliders that control the mask shape and falloff.

## Tech Stack

- **WordPress theme:** Flynt framework
- **Build tool:** Vite
- **Styling:** Tailwind CSS
- **Image processing:** p5.js (instance mode)
- **PHP:** Composer, ACF (Advanced Custom Fields)

## Next Steps

- [ ] **Client delivers their p5.js image generator** (expected this week)
- [ ] Integrate client's generator with the existing masking/blend pipeline
- [ ] Create the Flynt component (PHP template + JS + styles)
- [ ] Wire up ACF fields for WordPress admin controls
- [ ] Test within the theme build pipeline (Vite)

## Notes

- The mask/blend logic is **decoupled from the image source**, so swapping in the client's p5.js generator should be straightforward — just connect their output to the existing masking pipeline.
- p5.js is used in **instance mode** (not global mode) for WordPress compatibility.
