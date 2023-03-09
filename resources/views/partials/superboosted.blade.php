@if(isset($callout) && $callout)
    <div class="alert alert-info">
        <h4><i class="fa-solid fa-rocket" aria-hidden="true"></i> {{ __('crud.errors.unavailable_feature') }}</h4>
        <p>
            {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.boosters', __('crud.superboosted_campaigns'), '#superboosted')]) !!}
        </p>
    </div>
@else
    <p class="help-block">
        {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.boosters', __('crud.superboosted_campaigns'), '#superboosted')]) !!}
    </p>
@endif
