@php
  $options = get_field('options') ?: [];
  $distance = $options['percentageDistance'] ?? '0';
@endphp

<div class="block-spacer" data-block="spacer" style="height: {{ $distance }};"></div>
