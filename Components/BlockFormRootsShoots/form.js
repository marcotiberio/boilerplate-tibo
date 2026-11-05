// Alpine data for BlockFormRootsShoots. Registered in assets/main.js.
// `conditions` seeds the fields that toggle conditional sections (e.g. over18).
export default (conditions = {}) => ({
  fields: conditions,
  errors: {},
  message: '',
  state: 'idle', // idle | sending | success

  async submit () {
    if (this.state === 'sending') return

    this.state = 'sending'
    this.errors = {}
    this.message = ''

    const form = this.$refs.form
    // Not form.action: the hidden input named "action" (for admin-post.php)
    // shadows that property.
    const url = form.getAttribute('action')

    try {
      const response = await fetch(url, {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json' },
        credentials: 'same-origin'
      })
      const result = await response.json()

      if (result.success) {
        this.state = 'success'
        this.$nextTick(() => this.$refs.confirmation.focus())
        return
      }

      this.errors = result.data.errors || {}
      this.message = result.data.message
    } catch (error) {
      this.message = 'Die Anmeldung konnte leider nicht gesendet werden. Bitte versucht es später noch einmal.'
    }

    this.state = 'idle'
    this.$nextTick(() => form.querySelector('[aria-invalid="true"]')?.focus())
  }
})
