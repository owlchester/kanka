<h4>{{ __('front/community-votes.latest.title') }}</h4>

@foreach ($recent as $vote)
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('community-votes.show', $vote->getSlug()) }}">{{ $vote->name }}</a>
            </h5>
            <div class="text-muted">{{ $vote->visible_at->isoFormat('MMMM D, Y') }}</div>
        </div>
    </div>
@endforeach
