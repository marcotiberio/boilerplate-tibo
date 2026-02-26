@php
  $title = get_field('title');
  $items = get_field('items') ?: [];
  $options = get_field('options') ?: [];
  $gridColumns = $options['gridColumns'] ?? '4';
  $colorBg = $options['colorBackground'] ?? null;
@endphp

<section class="block-grid-images"
  data-block="grid-images"
  style="background-color: {{ $colorBg ?: 'var(--transparent)' }};"
>
  <div class="boxed max-w-screen-max mx-auto flex flex-col gap-sm">
    @if($title)
      <div class="font-h2">{{ $title }}</div>
    @endif

    <div class="w-full mx-auto grid gap-xs"
      data-grid-columns="{{ $gridColumns }}"
    >
      @foreach($items as $index => $item)
        <div class="flex flex-col">
          @if(!empty($item['image']))
            <figure class="figure figureImage w-full cursor-pointer" data-image-index="{{ $index }}">
              <img class="lazyload w-full mx-auto h-auto object-cover aspect-4/3"
                src="{{ wp_get_attachment_image_url($item['image']['ID'], 'thumbnail') }}"
                data-srcset="{{ wp_get_attachment_image_srcset($item['image']['ID']) }}"
                data-sizes="auto"
                data-lightbox-src="{{ $item['image']['url'] }}"
                data-lightbox-srcset="{{ wp_get_attachment_image_srcset($item['image']['ID']) }}"
                alt="{{ $item['image']['alt'] ?? '' }}"
              >
            </figure>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
