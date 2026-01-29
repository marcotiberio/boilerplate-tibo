import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

export default function init(navigationMain) {
  const logoSvg1 = navigationMain.querySelector('#logo-group-1')
  const logoSvg2 = navigationMain.querySelector('#logo-group-2')
  const eyeLeft = navigationMain.querySelector('#eyeLeft')
  const eyeRight = navigationMain.querySelector('#eyeRight')
  
  // Parse viewBox to get center
  const parseViewBox = (viewBox) => {
    const values = viewBox.split(' ')
    return {
      x: parseFloat(values[0]) + parseFloat(values[2]) / 2,
      y: parseFloat(values[1]) + parseFloat(values[3]) / 2
    }
  }

  // Rotate logo SVGs
  if (logoSvg1 && logoSvg2) {
    const viewBox1 = logoSvg1.getAttribute('viewBox')
    const viewBox2 = logoSvg2.getAttribute('viewBox')
    const center1 = parseViewBox(viewBox1)
    const center2 = parseViewBox(viewBox2)

    // Rotate SVG 1 clockwise using SVG transform with center as origin
    gsap.to(logoSvg1, {
      svgOrigin: `${center1.x} ${center1.y}`,
      rotation: 360,
      scrollTrigger: {
        start: 'top top',
        end: 'max',
        scrub: true
      }
    })

    // Rotate SVG 2 counter-clockwise using SVG transform with center as origin
    gsap.to(logoSvg2, {
      svgOrigin: `${center2.x} ${center2.y}`,
      rotation: -360,
      scrollTrigger: {
        start: 'top top',
        end: 'max',
        scrub: true
      }
    })
  }

  // Rotate eye SVGs
  if (eyeLeft && eyeRight) {
    const eyeLeftGroup = eyeLeft.querySelector('g')
    const eyeRightGroup = eyeRight.querySelector('g')
    const viewBoxEyeLeft = eyeLeft.getAttribute('viewBox')
    const viewBoxEyeRight = eyeRight.getAttribute('viewBox')
    const centerEyeLeft = parseViewBox(viewBoxEyeLeft)
    const centerEyeRight = parseViewBox(viewBoxEyeRight)

    // Rotate eyeLeft group clockwise using SVG transform with center as origin
    if (eyeLeftGroup) {
      gsap.to(eyeLeftGroup, {
        svgOrigin: `${centerEyeLeft.x} ${centerEyeLeft.y}`,
        rotation: 360,
        scrollTrigger: {
          start: 'top top',
          end: 'max',
          scrub: true
        }
      })
    }

    // Rotate eyeRight group counter-clockwise using SVG transform with center as origin
    if (eyeRightGroup) {
      gsap.to(eyeRightGroup, {
        svgOrigin: `${centerEyeRight.x} ${centerEyeRight.y}`,
        rotation: -360,
        scrollTrigger: {
          start: 'top top',
          end: 'max',
          scrub: true
        }
      })
    }
  }

  // Rotate eye2 SVGs
  const eyeLeft2 = navigationMain.querySelector('#eyeLeft2')
  const eyeRight2 = navigationMain.querySelector('#eyeRight2')
  
  if (eyeLeft2) {
    const eyeLeft2Group = eyeLeft2.querySelector('g')
    const viewBoxEyeLeft2 = eyeLeft2.getAttribute('viewBox')
    const centerEyeLeft2 = parseViewBox(viewBoxEyeLeft2)

    // Rotate eyeLeft2 group clockwise using SVG transform with center as origin
    if (eyeLeft2Group) {
      gsap.to(eyeLeft2Group, {
        svgOrigin: `${centerEyeLeft2.x} ${centerEyeLeft2.y}`,
        rotation: 360,
        scrollTrigger: {
          start: 'top top',
          end: 'max',
          scrub: true
        }
      })
    }
  }

  if (eyeRight2) {
    const eyeRight2Group = eyeRight2.querySelector('g')
    const viewBoxEyeRight2 = eyeRight2.getAttribute('viewBox')
    const centerEyeRight2 = parseViewBox(viewBoxEyeRight2)

    // Rotate eyeRight2 group counter-clockwise using SVG transform with center as origin
    if (eyeRight2Group) {
      gsap.to(eyeRight2Group, {
        svgOrigin: `${centerEyeRight2.x} ${centerEyeRight2.y}`,
        rotation: -360,
        scrollTrigger: {
          start: 'top top',
          end: 'max',
          scrub: true
        }
      })
    }
  }
}
