@php
  $headlineTitle = get_field('headlineTitle');
  $items = get_field('items') ?: [];
  $options = get_field('options') ?: [];
  $gridColumns = $options['gridColumns'] ?? '4';
  $colorBg = $options['colorBackground'] ?? null;
@endphp

<section class="block-grid-image-text"
  data-block="grid-image-text"
  style="background-color: {{ $colorBg ?: 'var(--transparent)' }};"
>
  <div class="wrapper boxed !pt-0 max-w-screen-max mx-auto">
    @if($headlineTitle)
      <div class="max-w-screen-max mx-auto py-md md:py-xl flex justify-center items-center text-center font-smallTitle">
        {{ $headlineTitle }}
      </div>
    @endif

    <div class="w-full mx-auto grid gap-xs" data-grid-columns="{{ $gridColumns }}">
      @foreach($items as $item)
        <div class="flex flex-col gap-xs fade-in">
          @if(!empty($item['image']))
            @if(!empty($item['imageLink']))
              <a href="{{ $item['imageLink']['url'] }}"
                @if(!empty($item['imageLink']['target'])) target="{{ $item['imageLink']['target'] }}" rel="noreferrer noopener" @endif
              >
            @endif
              <figure class="figure figureImage w-full">
                <img class="lazyload w-full mx-auto h-auto object-cover"
                  src="{{ wp_get_attachment_image_url($item['image']['ID'], 'thumbnail') }}"
                  data-srcset="{{ wp_get_attachment_image_srcset($item['image']['ID']) }}"
                  data-sizes="auto"
                  alt="{{ $item['image']['alt'] ?? '' }}"
                >
              </figure>
            @if(!empty($item['imageLink']))
              </a>
            @endif
          @endif

          @if(!empty($item['imageBoxTitle']))
            <div class="font-bodySmall !mb-0 pt-[10px] uppercase border-t border-white">
              {{ $item['imageBoxTitle'] }}
            </div>
          @endif

          <div class="w-full flex flex-col grow justify-start">
            @if(!empty($item['contentHtml']))
              <div class="wysiwyg">{!! wp_kses_post($item['contentHtml']) !!}</div>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
