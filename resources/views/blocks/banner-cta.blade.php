@php
  $title = get_field('title');
  $contentHtml = get_field('contentHtml');
  $buttonLink = get_field('buttonLink');
  $backgroundImage = get_field('backgroundImage');
  $options = get_field('options') ?: [];
  $colorText = $options['colorText'] ?? null;
  $colorBg = $options['colorBackground'] ?? null;
@endphp

<section class="block-banner-cta w-full relative"
  data-block="banner-cta"
  style="
    color: {{ $colorText ?: 'var(--black)' }};
    background-color: {{ $colorBg ?: 'transparent' }};
  "
>
  @if($backgroundImage)
    <div
      class="absolute inset-0 w-full h-full z-0 brightness-[0.35]"
      style="background-image: url('{{ $backgroundImage['url'] }}'); background-size: cover; background-position: center;"
    ></div>
  @endif

  <div class="relative z-10 w-full max-w-screen-max mx-auto boxed flex flex-col gap-sm">
    @if($title)
      <div class="h2 w-full">{{ $title }}</div>
    @endif

    @if($contentHtml)
      <div class="wysiwyg w-full">{!! wp_kses_post($contentHtml) !!}</div>
    @endif

    @if($buttonLink)
      <a class="button button--fullRed"
        href="{{ $buttonLink['url'] }}"
        @if(!empty($buttonLink['target'])) target="{{ $buttonLink['target'] }}" rel="noreferrer noopener" @endif
      >
        {{ $buttonLink['title'] }}
      </a>
    @endif
  </div>
</section>
