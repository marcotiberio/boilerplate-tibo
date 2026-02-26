@php
  $oembed = get_field('oembed');
  $options = get_field('options') ?: [];
  $colorText = $options['colorText'] ?? null;
  $colorBg = $options['colorBackground'] ?? null;
@endphp

<section class="block-video-oembed"
  data-block="video-oembed"
  style="
    color: {{ $colorText ?: 'var(--black)' }};
    background-color: {{ $colorBg ?: 'transparent' }};
  "
>
  <div class="boxed md:!pt-0">
    <div class="video w-full md:w-2/3 mx-auto">
      <div data-ref="videoPlayer" class="video-player w-full mx-auto" data-state="isLoaded">
        {!! $oembed !!}
        <div class="video-loader"></div>
        <button data-ref="playButton" class="video-playButton" type="button" aria-label="Play Video"></button>
      </div>
    </div>
  </div>
</section>
