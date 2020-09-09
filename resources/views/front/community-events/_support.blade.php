{!! nl2br($model->excerpt) !!}

<div class="alert alert-light mt-3">
    <p>{{ __('front/community-votes.show.restricted') }}</p>

    <a href="{{ route('front.pricing') }}">
        {{ __('front/community-votes.actions.pricing_info')}}
    </a>
</div>
