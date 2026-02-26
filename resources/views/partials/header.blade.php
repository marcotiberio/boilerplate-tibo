<header class="site-header w-full z-50 sticky top-0" role="banner">
  <nav class="navigation-main boxed flex items-center justify-between"
    aria-label="{{ __('Main Navigation', 'sage') }}"
  >
    <a href="{{ home_url('/') }}" class="site-logo" rel="home">
      @if($logo_url ?? false)
        <img src="{{ $logo_url }}" alt="{{ get_bloginfo('name') }}" class="logo-image" />
      @else
        <span class="font-h3">{{ get_bloginfo('name') }}</span>
      @endif
    </a>

    <button
      class="menu-toggle lg:hidden"
      type="button"
      aria-label="{{ __('Toggle Menu', 'sage') }}"
      data-ref="menuToggle"
    >
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>

    @if(has_nav_menu('navigation_main'))
      {!! wp_nav_menu([
        'theme_location' => 'navigation_main',
        'container' => false,
        'menu_class' => 'nav-menu hidden lg:flex items-center gap-sm',
        'echo' => false,
      ]) !!}
    @endif

    @if($cta_link ?? false)
      <a class="button button--fullBlue hidden lg:inline-flex"
        href="{{ $cta_link['url'] }}"
        @if(!empty($cta_link['target'])) target="{{ $cta_link['target'] }}" rel="noreferrer noopener" @endif
      >
        {{ $cta_link['title'] }}
      </a>
    @endif
  </nav>
</header>
