import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

/**
 * Leaflet layer for the event map.
 *
 * All UI state (filters, selected entry) lives in the Alpine component in
 * index.twig; the two talk through custom events on the component element:
 *   in  — eventmap:filter { ids }, eventmap:selected { id }, eventmap:zoom { delta }
 *   out — eventmap:ready, eventmap:select { id }
 */
export default function (el) {
  const refs = buildRefs(el)
  const data = getJSON(el, 'script[data-ref="entries"]')
  const entries = Array.isArray(data) ? data : []
  if (!refs.map) return

  const [centerLat, centerLng] = (refs.map.dataset.center || '52.5200, 13.4050')
    .split(',')
    .map((n) => parseFloat(n.trim()))
  const zoom = parseInt(refs.map.dataset.zoom, 10) || 12

  const map = L.map(refs.map, {
    scrollWheelZoom: false,
    zoomControl: false // replaced by the design's own zoom buttons
  }).setView([centerLat, centerLng], zoom)

  L.tileLayer(refs.map.dataset.tileUrl, {
    attribution: refs.map.dataset.tileAttribution,
    maxZoom: 19,
    // Upscale rather than request tiles the provider doesn't serve.
    maxNativeZoom: parseInt(refs.map.dataset.tileMaxNative, 10) || 19
  }).addTo(map)

  const pinShape = el.querySelector('template[data-ref="pinTemplate"]')
  const pinSvg = pinShape ? pinShape.innerHTML.trim() : ''

  const markers = new Map()
  const layer = L.layerGroup().addTo(map)

  entries.forEach((entry) => {
    if (!entry.lat || !entry.lng) return
    const marker = L.marker([entry.lat, entry.lng], {
      icon: buildIcon(entry, pinSvg),
      title: entry.title,
      alt: entry.title,
      riseOnHover: true
    })
    marker.on('click', () => dispatch('eventmap:select', { id: entry.id }))
    markers.set(entry.id, marker)
    layer.addLayer(marker)
  })

  // Clicking the map background clears the selection.
  map.on('click', () => dispatch('eventmap:select', { id: null }))

  frame([...markers.values()])

  let visibleKey = [...markers.keys()].join(',')

  el.addEventListener('eventmap:filter', (event) => {
    const ids = event.detail.ids || []
    const key = ids.join(',')
    if (key === visibleKey) return
    visibleKey = key

    markers.forEach((marker, id) => {
      const isVisible = ids.includes(id)
      if (isVisible && !layer.hasLayer(marker)) layer.addLayer(marker)
      if (!isVisible && layer.hasLayer(marker)) layer.removeLayer(marker)
    })

    frame(ids.map((id) => markers.get(id)).filter(Boolean))
  })

  el.addEventListener('eventmap:selected', (event) => {
    const id = event.detail.id
    markers.forEach((marker, markerId) => {
      const element = marker.getElement()
      if (element) element.classList.toggle('is-active', markerId === id)
    })
    const selected = markers.get(id)
    if (selected) map.panTo(selected.getLatLng(), { animate: true })
  })

  el.addEventListener('eventmap:zoom', (event) => {
    map.setZoom(map.getZoom() + (event.detail.delta || 0))
  })

  dispatch('eventmap:ready', {})

  function dispatch (name, detail) {
    refs.map.dispatchEvent(new CustomEvent(name, { detail, bubbles: true }))
  }

  // Frame the given markers, keeping the overlay chrome clear of the pins.
  function frame (list) {
    if (list.length > 1) {
      map.fitBounds(L.featureGroup(list).getBounds().pad(0.2))
    } else if (list.length === 1) {
      map.setView(list[0].getLatLng(), Math.max(map.getZoom(), 14))
    }
  }
}

/**
 * Pin marker: the designed pin shape (colour switches via CSS on .is-active)
 * with the program type glyph on top.
 */
function buildIcon (entry, pinSvg) {
  const icon = entry.icon
    ? `<img class="event-map__pin-icon" src="${encodeURI(entry.icon)}" alt="">`
    : ''

  return L.divIcon({
    className: 'event-map__pin',
    html: `${pinSvg}${icon}`,
    iconSize: [55.5, 71],
    iconAnchor: [28, 71]
  })
}
