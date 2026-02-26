@php
  $headlineTitle = get_field('headlineTitle');
  $boxes = get_field('boxes') ?: [];
  $options = get_field('options') ?: [];
  $colorText = $options['colorText'] ?? null;
  $colorBg = $options['colorBackground'] ?? null;
  $autoplay = $options['autoplay'] ?? false;
  $autoplaySpeed = $options['autoplaySpeed'] ?? 4000;

  $jsonData = json_encode([
    'options' => [
      'autoplay' => $autoplay,
      'autoplaySpeed' => $autoplaySpeed,
      'colorText' => $colorText,
      'colorBackground' => $colorBg,
    ],
  ]);
@endphp

<section class="block-slider-box pb-xxl my-xxs overflow-hidden"
  data-block="slider-box"
  style="
    color: {{ $colorText ?: 'var(--black)' }};
    background-color: {{ $colorBg ?: 'transparent' }};
  "
>
  <script type="application/json">{!! $jsonData !!}</script>

  <div class="wrapper w-screen mx-auto boxed boxed--coloured">
    @if($headlineTitle)
      <h2 class="mb-xxl">{{ $headlineTitle }}</h2>
    @endif

    <div data-ref="slider" class="slider swiper-container mt-xl lg:mt-0">
      <div class="w-full button-wrapper absolute left-0 bottom-0 z-50 translate-y-xl xs:translate-y-xl lg:translate-y-sm">
        <div data-ref="dots" class="flex justify-center slider-pagination swiper-pagination-fraction"></div>
      </div>

      <div class="swiper-wrapper">
        @foreach($boxes as $box)
          <div class="slider-item swiper-slide relative w-full h-auto lg:mr-md flex flex-col justify-center items-center overflow-hidden">
            <div class="w-[66%] mx-auto flex flex-col justify-center items-center">
              @if(!empty($box['contentHtml']))
                <div class="text-center wysiwyg">{!! wp_kses_post($box['contentHtml']) !!}</div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
