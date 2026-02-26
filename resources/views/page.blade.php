@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class())>
      <div class="entry-content">
        {{-- Gutenberg blocks render automatically via the_content() --}}
        {!! the_content() !!}
      </div>
    </article>
  @endwhile
@endsection
