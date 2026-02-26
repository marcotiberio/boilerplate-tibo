@php
  $mediaItems = get_field('mediaItems') ?: [];
  $options = get_field('options') ?: [];
@endphp

<section class="block-gallery-media boxed !py-[7.5px]"
  data-block="gallery-media"
  id="galleryMedia"
>
  <div class="grid grid-cols-3 lg:grid-cols-12 gap-xs align-start justify-start lg:justify-between fade-in">
    @foreach($mediaItems as $index => $item)
      <div class="media-item w-full column flex {{ $item['colStart'] ?? '' }} {{ $item['colEnd'] ?? '' }}"
        id="media-item-{{ $index + 1 }}"
      >
        @if($item['acf_fc_layout'] === 'image')
          <div class="media-item--image w-full flex {{ $item['alignY'] ?? 'lg:items-start' }}">
            @if(!empty($item['image']))
              <figure class="figure w-full">
                <img class="lazyload w-full h-auto object-cover"
                  src="{{ wp_get_attachment_image_url($item['image']['ID'], 'thumbnail') }}"
                  data-srcset="{{ wp_get_attachment_image_srcset($item['image']['ID']) }}"
                  data-sizes="auto"
                  alt="{{ $item['image']['alt'] ?? '' }}"
                >
              </figure>
            @endif
          </div>

        @elseif($item['acf_fc_layout'] === 'video_upload')
          <div class="media-item--video w-full flex {{ $item['alignY'] ?? 'lg:items-start' }}">
            @if(!empty($item['video']))
              <video class="w-full" autoplay loop muted playsinline>
                <source src="{{ $item['video']['url'] }}" type="{{ $item['video']['mime_type'] }}">
              </video>
            @endif
          </div>

        @elseif($item['acf_fc_layout'] === 'oembed')
          <div class="media-item--oembed w-full flex {{ $item['alignY'] ?? 'lg:items-start' }}">
            @if(!empty($item['videoIDLandscape']))
              <div class="video-embed w-full aspect-16/9">
                <iframe src="https://player.vimeo.com/video/{{ $item['videoIDLandscape'] }}?autoplay=1&loop=1&muted=1&controls=0"
                  class="w-full h-full" frameborder="0" allow="autoplay" allowfullscreen></iframe>
              </div>
            @endif
          </div>
        @endif
      </div>
    @endforeach
  </div>
</section>
