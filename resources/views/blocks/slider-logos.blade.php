@php
  $blockTitle = get_field('blockTitle');
  $contentBoxes = get_field('contentBoxes') ?: [];
  $options = get_field('options') ?: [];
  $colorBg = $options['colorBackground'] ?? null;
  $autoplay = $options['autoplay'] ?? false;
  $autoplaySpeed = $options['autoplaySpeed'] ?? 250;
  $autoplayDelay = $options['autoplayDelay'] ?? 0;

  $jsonData = json_encode([
    'options' => [
      'autoplay' => $autoplay,
      'autoplaySpeed' => $autoplaySpeed,
      'autoplayDelay' => $autoplayDelay,
    ],
  ]);
@endphp

<section class="block-slider-logos overflow-hidden"
  data-block="slider-logos"
  style="background-color: {{ $colorBg ?: 'transparent' }};"
>
  <script type="application/json">{!! $jsonData !!}</script>

  <div class="boxed !min-h-auto px-0 w-full fade-in">
    @if($blockTitle)
      <h3 class="mb-xxl">{{ $blockTitle }}</h3>
    @endif

    <div data-ref="marquee"
      class="marquee-container relative w-full overflow-hidden"
      style="--marquee-fade-color: {{ $colorBg ?: 'rgba(255, 255, 255, 1)' }};"
    >
      <div data-ref="marqueeContent" class="marquee-content inline-flex items-center gap-md md:gap-xl">
        @foreach($contentBoxes as $box)
          <figure class="figure flex-shrink-0 inline-block">
            @if(!empty($box['panelLogo']))
              <img
                class="logo lazyload object-contain block"
                style="min-width: 100px; width: 100px; height: auto;"
                src="{{ wp_get_attachment_image_url($box['panelLogo']['ID'], 'thumbnail') }}"
                data-srcset="{{ wp_get_attachment_image_srcset($box['panelLogo']['ID']) }}"
                data-sizes="auto"
                alt="{{ $box['panelLogo']['alt'] ?? 'Logo' }}"
              >
            @endif
          </figure>
        @endforeach
      </div>
    </div>
  </div>
</section>
