/* globals FlyntComponentScreenshots */

// Add delegated events.
document.addEventListener('mouseenter', (e) => {
  const { target } = e

  if (typeof target === 'object' && target !== null && 'getAttribute' in target && target.matches('a[data-layout]')) {
    const layout = target.dataset.layout
    showComponentScreenshot(layout, target)
  }
}, true)

document.addEventListener('mouseleave', (e) => {
  const { target } = e

  if (typeof target === 'object' && target !== null && 'getAttribute' in target && target.matches('a[data-layout]')) {
    hideComponentScreenshot(target)
  }
}, true)

function showComponentScreenshot (layout, wrapper) {
  const { templateDirectoryUri, components, version } = FlyntComponentScreenshots
  const componentPath = components[firstToUpperCase(layout)]

  if (!componentPath) {
    return
  }

  const wrapperContainer = document.createElement('div')
  wrapperContainer.classList.add('flyntComponentScreenshot-imageWrapper')
  wrapper.append(wrapperContainer)

  const img = document.createElement('img')
  img.classList.add('flyntComponentScreenshot-previewImageLarge')
  img.src = `${templateDirectoryUri}${componentPath}/screenshot.png?v=${version}`
  // hide the wrapper if the component has no screenshot
  img.addEventListener('error', () => wrapperContainer.remove())

  wrapperContainer.prepend(img)
}

function hideComponentScreenshot (wrapper) {
  const wrapperContainer = wrapper.querySelector('.flyntComponentScreenshot-imageWrapper')
  if (wrapperContainer) {
    wrapperContainer.remove()
  }
}

function firstToUpperCase (str) {
  return str.substr(0, 1).toUpperCase() + str.substr(1)
}
