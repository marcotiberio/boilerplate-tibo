@extends('layouts.app')

@section('content')
  <div class="boxed">
    @while(have_posts()) @php(the_post())
      @include('partials.content')
    @endwhile

    {!! get_the_posts_navigation() !!}
  </div>
@endsection
