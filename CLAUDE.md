# CLAUDE.md — Project Context for AI Assistants

## Project

Flynt-based WordPress theme using Vite, Tailwind CSS, and Composer.

## In Progress: p5.js Image Editor Component

We are building a p5.js-powered image editor as a Flynt component. Current status:

### What's been built
- Alpha mask system using p5.js instance mode
- 5 mask presets: radial, linear, diagonal, corner, split
- Each preset has configurable sliders (inner/outer radius, falloff, angle, etc.)
- Uses standard p5.js APIs (`createGraphics`, `loadPixels`, `updatePixels`, `mask()`) for image ops
- All mask generation math (the `computeAlpha` functions) is custom — p5.js only provides pixel buffers and the `mask()` method

### Architecture notes
- p5.js runs in **instance mode** (not global) for WordPress compatibility
- Mask/blend logic is **decoupled from image source** — easy to swap in a different image generator
- The p5.js alpha mask example pattern is followed: load image -> create mask image -> call `img.mask(maskImg)`

### Waiting on
- Client to provide their p5.js image generator (expected late Feb 2026)
- Once received: integrate with existing masking pipeline, create Flynt component, wire up ACF fields

### Key directories
- `Components/` — Flynt components (the new image editor will go here)
- `assets/` — front-end assets
- `dist/` — built output
- `inc/` — PHP includes

### Build & dev commands
- Check `package.json` for available npm scripts (Vite-based build)
- PHP dependencies via Composer
