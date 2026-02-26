<!doctype html>
<html {!! get_language_attributes() !!}>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!! wp_head() !!}
</head>
<body {!! body_class() !!}>
  {!! wp_body_open() !!}

  @include('partials.header')

  <main id="main" class="main" role="main">
    @yield('content')
  </main>

  @include('partials.footer')

  {!! wp_footer() !!}
</body>
</html>
