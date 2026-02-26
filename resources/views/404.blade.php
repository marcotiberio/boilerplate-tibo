@extends('layouts.app')

@section('content')
  <div class="boxed py-xl text-center">
    <h1>{{ __('Page Not Found', 'sage') }}</h1>
    <p>{{ __('Sorry, the page you were looking for could not be found.', 'sage') }}</p>
    <a class="button button--fullBlue" href="{{ home_url('/') }}">
      {{ __('Back to Home', 'sage') }}
    </a>
  </div>
@endsection
