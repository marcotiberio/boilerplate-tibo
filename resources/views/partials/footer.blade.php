<footer class="site-footer" role="contentinfo">
  <div class="boxed flex flex-col lg:flex-row gap-lg py-xl">
    @if($footer_logo ?? false)
      <div class="footer-logo">
        <img src="{{ $footer_logo['url'] }}" alt="{{ $footer_logo['alt'] ?? get_bloginfo('name') }}" />
      </div>
    @endif

    @if($footer_columns ?? false)
      @foreach($footer_columns as $column)
        <div class="footer-column flex-1">
          @if(!empty($column['contentHtml']))
            <div class="wysiwyg">{!! wp_kses_post($column['contentHtml']) !!}</div>
          @endif
        </div>
      @endforeach
    @endif

    @if(has_nav_menu('navigation_footer'))
      <nav class="footer-nav" aria-label="{{ __('Footer Navigation', 'sage') }}">
        {!! wp_nav_menu([
          'theme_location' => 'navigation_footer',
          'container' => false,
          'menu_class' => 'footer-menu flex flex-col gap-xs',
          'depth' => 1,
          'echo' => false,
        ]) !!}
      </nav>
    @endif
  </div>

  @if($footer_copyrights ?? false)
    <div class="boxed py-sm border-t">
      <div class="wysiwyg font-bodySmall">{!! wp_kses_post($footer_copyrights) !!}</div>
    </div>
  @endif
</footer>
