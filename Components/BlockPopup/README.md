# Block Popup

Site-wide modal popup configured once and toggled per page.

- **Content**: configured globally under **Blocks Settings → Block Popup** (image, position, content, newsletter button, colors, popup ID, show delay, backdrop close).
- **Per-page toggle**: each post/page has a sidebar field group **Popup → Display Popup** to opt in.
- **Rendering**: the component is rendered globally from `templates/_document.twig`. It only outputs markup when the current singular page has *Display Popup* enabled.
- **Dismissal**: stored in `localStorage` under `blockPopup:<popupId>`. Change the *Popup ID* in Blocks Settings to re-show the popup to users who already dismissed it.
- **Close**: close button, ESC key, or backdrop click (toggleable). Body scroll is locked while open.
