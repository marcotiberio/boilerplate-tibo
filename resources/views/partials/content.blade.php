<article @php(post_class('mb-lg'))>
  <header>
    <h2 class="entry-title">
      <a href="{{ get_permalink() }}">
        {!! get_the_title() !!}
      </a>
    </h2>
    <time class="entry-date" datetime="{{ get_post_time('c', true) }}">
      {{ get_the_date() }}
    </time>
  </header>
  <div class="entry-summary wysiwyg">
    {!! get_the_excerpt() !!}
  </div>
</article>
