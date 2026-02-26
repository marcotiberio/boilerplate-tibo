@php
  $imagePosition = get_field('imagePosition') ?: 'lg:flex-row-reverse';
  $image = get_field('image');
  $contentHtml = get_field('contentHtml');
  $buttonLink1 = get_field('buttonLink1');
  $buttonLink2 = get_field('buttonLink2');
  $repeaterButtons = get_field('repeaterButtons');
  $options = get_field('options') ?: [];
  $colorText = $options['colorText'] ?? null;
  $colorBg = $options['colorBackground'] ?? null;
@endphp

<section class="block-image-text"
  data-block="image-text"
  style="
    color: {{ $colorText ?: 'var(--blue)' }};
    background-color: {{ $colorBg ?: 'transparent' }};
  "
>
  <div class="boxed">
    <div class="flex flex-col {{ $imagePosition }} gap-lg items-center h-full">
      <div class="w-full lg:w-1/2">
        @if($image)
          <figure class="figure">
            <img class="figure-image lazyload h-full w-full object-cover"
              src="{{ wp_get_attachment_image_url($image['ID'], 'thumbnail') }}"
              data-srcset="{{ wp_get_attachment_image_srcset($image['ID']) }}"
              data-sizes="auto"
              alt="{{ $image['alt'] ?? '' }}"
            >
            @if(!empty($image['caption']))
              <figcaption class="font-bodySmall">{{ $image['caption'] }}</figcaption>
            @endif
          </figure>
        @endif
      </div>

      <div class="w-full lg:w-1/2 h-full flex flex-col justify-between {{ $imagePosition === 'lg:flex-row' ? '!mr-0' : '!ml-0' }}">
        @if($contentHtml)
          <div class="wysiwyg">{!! wp_kses_post($contentHtml) !!}</div>
        @endif

        @if($repeaterButtons)
          @foreach($repeaterButtons as $panel)
            <div class="flex flex-col gap-sm mt-xs">
              <a class="button button--outline button--outlineBig"
                href="{{ $panel['buttonLink']['url'] }}"
                @if(!empty($panel['buttonLink']['target'])) target="{{ $panel['buttonLink']['target'] }}" rel="noreferrer noopener" @endif
              >
                {{ $panel['buttonLink']['title'] }}
              </a>
            </div>
          @endforeach
        @endif

        <div class="flex flex-row gap-xs mt-xs">
          @if($buttonLink1)
            <a class="button button--fullBlue" href="{{ $buttonLink1['url'] }}"
              @if(!empty($buttonLink1['target'])) target="{{ $buttonLink1['target'] }}" rel="noreferrer noopener" @endif
            >
              {{ $buttonLink1['title'] }}
            </a>
          @endif
          @if($buttonLink2)
            <a class="button button--fullOrange" href="{{ $buttonLink2['url'] }}"
              @if(!empty($buttonLink2['target'])) target="{{ $buttonLink2['target'] }}" rel="noreferrer noopener" @endif
            >
              {{ $buttonLink2['title'] }}
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
