<h4>{{ __('front/news.latest.title') }}</h4>

@foreach ($recent as $post)
    <div class="card mb-2">
        @if (!empty($post->image))
            <img class="card-img-top" src="{{ Voyager::image($post->thumbnail('small')) }}" alt="{{ $post->title }}">
        @endif
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('front.news.show', $post->getSlug()) }}">{{ $post->title }}</a>
            </h5>
            <div class="text-muted">{{ $post->updated_at->isoFormat('MMMM D, Y') }}</div>
        </div>
    </div>
@endforeach