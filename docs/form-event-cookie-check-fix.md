# FormEvent — "Cookie check failed" fix

## Symptom

Some users submitting the public event form (`People Planet Pint`, etc.) saw
the error **`Cookie check failed`** and could not register.

## Root cause

The message was **not** from the theme's own validation — it came from
WordPress **core**, in `rest_cookie_check_errors()`, which runs *before* the
custom submission handler.

- The page rendered a `wp_rest` nonce baked into the HTML at render time
  (`functions.php` → `restNonce`).
- The form sent it as a header: `X-WP-Nonce` (`index.twig`).
- A WordPress nonce is tied to a user session + a 12h tick and is valid for
  only ~24h. Because it lives in the page HTML, it goes stale for anyone:
  - served a **cached / CDN** copy of the page,
  - who **left the tab open / bookmarked / prerendered** and submitted >24h later,
  - in a mismatched logged-in vs. logged-out context.
- When core fails to verify that nonce it returns the literal string
  `Cookie check failed` (code `rest_cookie_invalid_nonce`, HTTP 403).

That is why it only affected "some" users — those whose embedded nonce was no
longer valid at submit time.

Note there were **two** static nonces with the same weakness: the `wp_rest`
core nonce (threw "Cookie check failed") and the theme's own `NONCE_ACTION`
check (threw "Deine Sitzung ist abgelaufen"). Both break under caching/expiry.

## Fix (chosen approach: drop nonces entirely)

This is a public, cacheable submission form, so nonces are fundamentally
incompatible with full-page caching. Both nonce checks were removed and abuse
is contained by the remaining server-side protections.

### Changes

- **`inc/restApi/eventSubmission.php`** — removed the server-side nonce check;
  renumbered step comments.
- **`Components/FormEvent/index.twig`** — removed the `X-WP-Nonce` header (the
  direct cause) and the `nonce` form field.
- **`Components/FormEvent/functions.php`** — stopped generating/injecting
  `nonce` and `restNonce`; updated the explaining comment.
- **`inc/eventFields.php`** — removed the now-dead `NONCE_ACTION` constant.

### Remaining protection

- Honeypot field (`website_hp`).
- Per-IP rate limit (5 submissions / hour).
- Strict sanitisation + choice allow-listing.
- Posts are always created as `pending` for editor review.

Worst case for a forged request is one extra pending post an editor reviews —
the same outcome as a normal submission.

## Deploy note

The front-end Twig/JS changed, so rebuild assets (`npm run build`) before
deploying.
