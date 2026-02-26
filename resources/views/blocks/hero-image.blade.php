@php
  $image = get_field('image');
  $imageMobile = get_field('imageMobile');
  $height = get_field('height') ?: 'h-screen';
  $titleHtml = get_field('titleHtml');
  $buttonLink = get_field('buttonLink');
@endphp

<section class="block-hero-image w-full lgplus:w-screen {{ $height }} mx-auto relative overflow-hidden"
  data-block="hero-image"
  @if($is_preview) style="min-height: 300px;" @endif
>
  @if($image)
    <img
      class="hidden lgplus:block figure-image w-full h-full max-h-[calc(100vh_-_66px)] object-cover rounded-image"
      src="{{ $image['url'] }}"
      alt="{{ $image['alt'] ?? '' }}"
      loading="eager"
    />
  @endif

  @if($imageMobile)
    <img
      class="block lgplus:hidden figure-image w-full h-full max-h-[calc(100vh_-_55px)] object-cover rounded-image"
      src="{{ $imageMobile['url'] }}"
      alt="{{ $imageMobile['alt'] ?? '' }}"
      loading="eager"
    />
  @endif

  <div class="absolute inset-0 z-10 pointer-events-none"></div>
  <div class="boxed px-xs py-sm md:p-sm flex flex-col gap-sm">
    @if($titleHtml)
      <div class="wysiwyg">{!! wp_kses_post($titleHtml) !!}</div>
    @endif

    @if($buttonLink)
      <a class="button button--fullRed" href="{{ $buttonLink['url'] }}"
        @if(!empty($buttonLink['target'])) target="{{ $buttonLink['target'] }}" rel="noreferrer noopener" @endif
      >
        {{ $buttonLink['title'] }}
      </a>
    @endif
  </div>
</section>
