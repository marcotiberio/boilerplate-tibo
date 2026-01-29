// export default (component) => {
//   const wysiwygElement = component.querySelector('.wysiwyg')
  
//   if (!wysiwygElement) return
  
//   // Store original text content for restoration
//   const originalHTML = wysiwygElement.innerHTML
  
//   // Function to wrap each word in a span
//   function wrapWords(element) {
//     const walker = document.createTreeWalker(
//       element,
//       NodeFilter.SHOW_TEXT,
//       null,
//       false
//     )
    
//     const textNodes = []
//     let node
    
//     while (node = walker.nextNode()) {
//       // Include all text nodes, even if they only contain whitespace
//       // This ensures spaces between words are preserved
//       if (node.textContent.length === 0) continue
//       textNodes.push(node)
//     }
    
//     textNodes.forEach(textNode => {
//       const parent = textNode.parentNode
//       const text = textNode.textContent
//       const fragment = document.createDocumentFragment()
      
//       // Split text into words and separators using regex
//       // Match sequences of word characters (letters, numbers, underscores) as words
//       // Everything else (spaces, punctuation, etc.) is a separator
//       const parts = text.split(/(\w+)/g)
      
//       parts.forEach((part, index) => {
//         if (part.length === 0) return
        
//         // Check if this part is a word (contains word characters)
//         const isWord = /^\w+$/.test(part)
        
//         if (isWord) {
//           // For words, wrap in a span
//           const wordSpan = document.createElement('span')
//           wordSpan.className = 'word-shuffle'
//           wordSpan.textContent = part
//           wordSpan.setAttribute('data-original-index', index)
//           fragment.appendChild(wordSpan)
//         } else {
//           // For separators (spaces, punctuation, etc.), create a span
//           const separatorSpan = document.createElement('span')
//           separatorSpan.className = 'word-shuffle-separator'
//           separatorSpan.textContent = part
//           separatorSpan.setAttribute('data-original-index', index)
//           fragment.appendChild(separatorSpan)
//         }
//       })
      
//       parent.replaceChild(fragment, textNode)
//     })
//   }
  
//   // Store original order mapping: parent -> [words and separators in order]
//   const originalOrder = new Map()
  
//   // Function to store original order
//   function storeOriginalOrder() {
//     const allElements = wysiwygElement.querySelectorAll('.word-shuffle, .word-shuffle-separator')
//     allElements.forEach(element => {
//       const parent = element.parentNode
//       if (!originalOrder.has(parent)) {
//         originalOrder.set(parent, [])
//       }
//       originalOrder.get(parent).push(element)
//     })
//   }
  
//   // Function to shuffle words (preserving separators in their positions)
//   function shuffleWords() {
//     // Group by parent element
//     const wordGroups = new Map()
//     const allElements = wysiwygElement.querySelectorAll('.word-shuffle, .word-shuffle-separator')
    
//     allElements.forEach(element => {
//       const parent = element.parentNode
//       if (!wordGroups.has(parent)) {
//         wordGroups.set(parent, [])
//       }
//       wordGroups.get(parent).push(element)
//     })
    
//     // Shuffle each group (words only, keeping separators in place)
//     wordGroups.forEach((group) => {
//       if (group.length === 0) return
      
//       // Extract words and track their positions
//       const words = []
//       const groupCopy = Array.from(group)
      
//       groupCopy.forEach((element) => {
//         if (element.classList.contains('word-shuffle')) {
//           words.push(element)
//         }
//       })
      
//       if (words.length === 0) return
      
//       // Fisher-Yates shuffle only the words
//       const shuffledWords = Array.from(words)
//       for (let i = shuffledWords.length - 1; i > 0; i--) {
//         const j = Math.floor(Math.random() * (i + 1));
//         [shuffledWords[i], shuffledWords[j]] = [shuffledWords[j], shuffledWords[i]]
//       }
      
//       // Re-insert elements maintaining separator positions
//       const parent = group[0].parentNode
      
//       // Remove all elements first
//       groupCopy.forEach(element => {
//         if (element.parentNode === parent) {
//           parent.removeChild(element)
//         }
//       })
      
//       // Re-insert maintaining separator positions
//       let wordIndex = 0
      
//       groupCopy.forEach((originalElement) => {
//         if (originalElement.classList.contains('word-shuffle')) {
//           // Insert shuffled word
//           parent.appendChild(shuffledWords[wordIndex])
//           wordIndex++
//         } else {
//           // Insert separator in its original position
//           parent.appendChild(originalElement)
//         }
//       })
//     })
//   }
  
//   // Function to restore original order
//   function restoreWords() {
//     originalOrder.forEach((elements, parent) => {
//       // Re-insert words and separators in their original order
//       elements.forEach(element => {
//         parent.appendChild(element)
//       })
//     })
//   }
  
//   // Initialize: wrap words and store original order
//   wrapWords(wysiwygElement)
//   storeOriginalOrder()
  
//   // Shuffle interval and timeout
//   let shuffleInterval = null
//   let restoreTimeout = null
  
//   // Function to stop shuffling and restore
//   function stopShuffling() {
//     if (shuffleInterval) {
//       clearInterval(shuffleInterval)
//       shuffleInterval = null
//     }
//     if (restoreTimeout) {
//       clearTimeout(restoreTimeout)
//       restoreTimeout = null
//     }
//     restoreWords()
//   }
  
//   // Handle hover
//   const handleMouseEnter = () => {
//     // Clear any existing timeouts/intervals
//     if (shuffleInterval) {
//       clearInterval(shuffleInterval)
//     }
//     if (restoreTimeout) {
//       clearTimeout(restoreTimeout)
//     }
    
//     // Shuffle immediately
//     shuffleWords()
    
//     // Continue shuffling for 2 seconds
//     shuffleInterval = setInterval(() => {
//       shuffleWords()
//     }, 100) // Shuffle every 100ms for continuous effect
    
//     // Automatically restore after 2 seconds
//     restoreTimeout = setTimeout(() => {
//       stopShuffling()
//     }, 2000)
//   }
  
//   const handleMouseLeave = () => {
//     // Stop shuffling and restore immediately on mouse leave
//     stopShuffling()
//   }
  
//   wysiwygElement.addEventListener('mouseenter', handleMouseEnter)
//   wysiwygElement.addEventListener('mouseleave', handleMouseLeave)
  
//   // Cleanup function
//   return () => {
//     if (shuffleInterval) {
//       clearInterval(shuffleInterval)
//     }
//     if (restoreTimeout) {
//       clearTimeout(restoreTimeout)
//     }
//     wysiwygElement.removeEventListener('mouseenter', handleMouseEnter)
//     wysiwygElement.removeEventListener('mouseleave', handleMouseLeave)
//     // Restore original HTML
//     wysiwygElement.innerHTML = originalHTML
//   }
// }
