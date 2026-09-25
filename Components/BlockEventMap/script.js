import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
// Only the plugin's animation CSS — the bubbles are styled in _style.scss, so
// its default blue/yellow theme (MarkerCluster.Default.css) stays out.
import 'leaflet.markercluster'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

// Cluster bubble grows in three steps so dense areas read heavier. The
// thresholds are calibrated to the size of the programme (a few dozen pins
// across the city), where a cluster of 7 is already dense — re-tune these if
// the event count grows by an order of magnitude.
const CLUSTER_STEPS = [
  { upTo: 3, name: 'sm', size: 40 },
  { upTo: 6, name: 'md', size: 52 },
  { upTo: Infinity, name: 'lg', size: 64 }
]

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
  const zoom = parseInt(refs.map.dataset.zoom, 10) || 16

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
  const layer = L.markerClusterGroup({
    iconCreateFunction: buildClusterIcon,
    // The design has no coverage outline; overlapping pins fan out instead.
    showCoverageOnHover: false,
    spiderfyOnMaxZoom: true,
    // Just under the pin width, so pins only merge once they actually touch.
    maxClusterRadius: 60
  }).addTo(map)

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
  })

  // Bulk add: the cluster group reclusters on every single addLayer call.
  layer.addLayers([...markers.values()])

  // Clicking the map background clears the selection.
  map.on('click', () => dispatch('eventmap:select', { id: null }))

  frame([...markers.values()])

  let visibleKey = [...markers.keys()].join(',')
  let selectedId = null

  // A clustered pin has no element, and gets a fresh one when its cluster
  // opens, so the active class is re-applied after every cluster re-render.
  layer.on('animationend', applyActive)

  el.addEventListener('eventmap:filter', (event) => {
    const ids = event.detail.ids || []
    const key = ids.join(',')
    if (key === visibleKey) return
    visibleKey = key

    const add = []
    const remove = []
    markers.forEach((marker, id) => {
      const isVisible = ids.includes(id)
      if (isVisible && !layer.hasLayer(marker)) add.push(marker)
      if (!isVisible && layer.hasLayer(marker)) remove.push(marker)
    })
    if (remove.length) layer.removeLayers(remove)
    if (add.length) layer.addLayers(add)

    frame(ids.map((id) => markers.get(id)).filter(Boolean))
  })

  el.addEventListener('eventmap:selected', (event) => {
    selectedId = event.detail.id
    applyActive()

    const selected = markers.get(selectedId)
    if (!selected || !layer.hasLayer(selected)) return
    // Opens the surrounding cluster first if the pin is hidden inside one.
    layer.zoomToShowLayer(selected, () => {
      map.panTo(selected.getLatLng(), { animate: true })
      applyActive()
    })
  })

  el.addEventListener('eventmap:zoom', (event) => {
    map.setZoom(map.getZoom() + (event.detail.delta || 0))
  })

  dispatch('eventmap:ready', {})

  function dispatch (name, detail) {
    refs.map.dispatchEvent(new CustomEvent(name, { detail, bubbles: true }))
  }

  function applyActive () {
    markers.forEach((marker, id) => {
      const element = marker.getElement()
      if (element) element.classList.toggle('is-active', id === selectedId)
    })
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

/**
 * Cluster bubble: the number of events grouped at this point, in one of three
 * sizes. Clicking it zooms to the group's bounds (Leaflet's own behaviour).
 */
function buildClusterIcon (cluster) {
  const count = cluster.getChildCount()
  const step = CLUSTER_STEPS.find((candidate) => count <= candidate.upTo)

  return L.divIcon({
    className: `event-map__cluster event-map__cluster--${step.name}`,
    html: `<span>${count}</span>`,
    iconSize: [step.size, step.size],
    iconAnchor: [step.size / 2, step.size / 2]
  })
}
