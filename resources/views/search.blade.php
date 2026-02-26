@extends('layouts.app')

@section('content')
  <div class="boxed">
    <header class="mb-lg">
      <h1>{{ __('Search Results for:', 'sage') }} <span class="text-blue">{{ get_search_query() }}</span></h1>
    </header>

    @if(have_posts())
      @while(have_posts()) @php(the_post())
        @include('partials.content')
      @endwhile

      {!! get_the_posts_navigation() !!}
    @else
      <p>{{ __('No results found.', 'sage') }}</p>
    @endif
  </div>
@endsection
