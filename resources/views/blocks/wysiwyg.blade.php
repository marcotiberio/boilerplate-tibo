@php
  $textPosition = get_field('textPosition') ?: 'center_narrow';
  $contentHtml = get_field('contentHtml');
  $buttonLink = get_field('buttonLink');
  $options = get_field('options') ?: [];
  $colorBg = $options['colorBackground'] ?? null;
  $stickyText = $options['stickyText'] ?? false;

  $positionClasses = match($textPosition) {
    'right' => 'justify-end w-full lg:w-[calc(75%_-_12.5px)] ml-auto',
    'left' => 'justify-start w-full lg:w-[calc(75%_-_12.5px)] mr-auto',
    'center_narrow' => 'justify-center w-full md:w-2/3 mx-auto',
    'center_full' => 'justify-center w-full mx-auto',
    default => 'justify-center w-full md:w-2/3 mx-auto',
  };
@endphp

<section class="block-wysiwyg"
  data-block="wysiwyg"
  style="background-color: {{ $colorBg ?: 'transparent' }};"
>
  <div class="boxed w-full fade-in">
    <div class="{{ $stickyText ? 'stickyText' : '' }} wysiwyg flex flex-col {{ $positionClasses }}">
      {!! wp_kses_post($contentHtml) !!}

      @if($buttonLink)
        <a class="button button--outline"
          href="{{ $buttonLink['url'] }}"
          @if(!empty($buttonLink['target'])) target="{{ $buttonLink['target'] }}" rel="noreferrer noopener" @endif
        >
          {{ $buttonLink['title'] }}
        </a>
      @endif
    </div>
  </div>
</section>
