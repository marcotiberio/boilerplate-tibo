<script>
/* ============================================================================
   Jane Goodall Institut — FundraisingBox "Patenschaft" form script
   ----------------------------------------------------------------------------
   THIS FILE IS NOT PART OF THE THEME BUILD. The form runs inside a
   cross-origin FundraisingBox iframe, so paste this whole file, first and
   last line included, into FundraisingBox instead:

       FundraisingBox → Formulare → "Patenschaft" (hash 5h5prdwkt2pije19)
       → Design/Layout → "Eigenes JavaScript"

   Never write the literal opening script tag anywhere except line 1, not
   even in a comment: FundraisingBox rewrites every occurrence into a real
   tag (adding its nonce), which splits the code and breaks it silently.

   Do not hide #intervalChoice in the custom CSS. This script hides it only
   once it is ready to set the rhythm; a CSS rule hides it even if the script
   fails, and every donation then falls back to the first option (jährlich).

   Each amount tile already says its rhythm ("20 € Monthly", "220 € Yearly"),
   so the "Rhythmus" select is redundant. This hides it and keeps it in sync
   with the chosen tile, so payment[interval] is still submitted correctly.

   The tile → interval mapping reads the tile description set in
   FundraisingBox, falling back to the amount (AMOUNTS below) when the
   description is empty. If amounts or descriptions change, update both maps.

   jQuery is FundraisingBox's own (already loaded in the form).
   ============================================================================ */
$(function () {
  // Tile description (lowercase) → FundraisingBox interval in months.
  var INTERVALS = {
    'einmalig': 0,
    'once': 0,
    'monatlich': 1,
    'monthly': 1,
    'vierteljährlich': 3,
    'quarterly': 3,
    'halbjährlich': 6,
    'half-yearly': 6,
    'jährlich': 12,
    'yearly': 12
  };

  // Fallback when a tile has no description: amount → interval in months.
  // Keep in sync with "Proposed donation amounts" in FundraisingBox.
  var AMOUNTS = {
    '20': 1,
    '220': 12
  };

  var $interval = $('#payment_interval');
  var $tiles = $('#amountChoices input[name="amountChoice"]');

  if (!$interval.length || !$tiles.length) {
    return;
  }

  function intervalFor($radio) {
    var text = $.trim($radio.closest('label.choice').find('.description').text()).toLowerCase();
    if (INTERVALS.hasOwnProperty(text)) {
      return INTERVALS[text];
    }
    var amount = String($radio.val());
    return AMOUNTS.hasOwnProperty(amount) ? AMOUNTS[amount] : null;
  }

  // Only hide the select when every tile maps to an interval; otherwise leave
  // it visible so donors can still pick the rhythm themselves.
  var allMapped = true;
  $tiles.each(function () {
    var interval = intervalFor($(this));
    if (interval === null || !$interval.find('option[value="' + interval + '"]').length) {
      allMapped = false;
    }
  });

  if (!allMapped) {
    return;
  }

  function syncInterval() {
    var $checked = $tiles.filter(':checked');
    if (!$checked.length) {
      return;
    }
    // Trigger change so FundraisingBox refreshes payment methods + fee wording.
    $interval.val(String(intervalFor($checked))).trigger('change');
  }

  $('#intervalChoice').hide();
  $tiles.on('change', syncInterval);

  // A tile can already be checked after a server-side validation round trip.
  syncInterval();
});
</script>
