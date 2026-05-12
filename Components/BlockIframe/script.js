import { buildRefs } from '@/assets/scripts/helpers'

export default function (el) {
  const refs = buildRefs(el)

  if (refs.wrap.dataset.autoResize !== 'true') return

  const onMessage = (event) => {
    const payload = event.data && event.data['datawrapper-height']
    if (!payload) return
    if (refs.iframe.contentWindow !== event.source) return
    const heights = Object.values(payload)
    if (!heights.length) return
    refs.iframe.style.height = heights[0] + 'px'
  }

  window.addEventListener('message', onMessage)
}
