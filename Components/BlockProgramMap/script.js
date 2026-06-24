import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (el) {
  const refs = buildRefs(el)
  const entries = getJSON(el, 'script[data-ref="entries"]')
  if (!refs.map) return

  const [centerLat, centerLng] = (refs.map.dataset.center || '52.3676, 4.9041')
    .split(',')
    .map((n) => parseFloat(n.trim()))
  const zoom = parseInt(refs.map.dataset.zoom, 10) || 12

  const map = L.map(refs.map, { scrollWheelZoom: false }).setView([centerLat, centerLng], zoom)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
  }).addTo(map)

  // CSS pin avoids Leaflet's bundler-broken default marker images.
  const icon = L.divIcon({
    className: 'program-map__pin',
    html: '<span></span>',
    iconSize: [24, 24],
    iconAnchor: [12, 24],
    popupAnchor: [0, -24]
  })

  const markers = []
  entries.forEach((entry) => {
    if (!entry.lat || !entry.lng) return
    const marker = L.marker([entry.lat, entry.lng], { icon }).addTo(map)
    marker.bindPopup(buildPopup(entry))
    markers.push(marker)
  })

  // Frame all markers when there are several.
  if (markers.length > 1) {
    map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2))
  } else if (markers.length === 1) {
    map.setView(markers[0].getLatLng(), Math.max(zoom, 14))
  }
}

function buildPopup (entry) {
  const esc = (s) => String(s == null ? '' : s).replace(/[&<>"']/g, (c) => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
  }[c]))

  const title = entry.link
    ? `<a href="${esc(entry.link)}">${esc(entry.title)}</a>`
    : esc(entry.title)

  return `
    <div class="program-map__popup">
      <strong>${title}</strong>
      ${entry.category ? `<em>${esc(entry.category)}</em>` : ''}
      ${entry.description ? `<p>${esc(entry.description)}</p>` : ''}
    </div>
  `
}
