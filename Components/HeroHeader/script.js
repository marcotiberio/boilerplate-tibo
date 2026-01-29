import Rellax from 'rellax'

export default function (el) {
  const rellaxElements = el.querySelectorAll('.rellax')
  
  if (rellaxElements.length === 0) {
    return
  }

  // Initialize Rellax on elements within this component
  // Rellax will use data-rellax-speed attributes from the HTML
  const rellax = new Rellax(Array.from(rellaxElements))

  return () => {
    rellax.destroy()
  }
}
