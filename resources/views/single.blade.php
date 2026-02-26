@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class())>
      <header class="entry-header boxed">
        <h1 class="entry-title">{!! get_the_title() !!}</h1>
        <time class="entry-date" datetime="{{ get_post_time('c', true) }}">
          {{ get_the_date() }}
        </time>
      </header>

      <div class="entry-content">
        {!! the_content() !!}
      </div>
    </article>
  @endwhile
@endsection
