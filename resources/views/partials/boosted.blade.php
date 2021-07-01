@if(isset($callout) && $callout)
    <div class="callout callout-info">
        <h4><i class="fas fa-rocket"></i> {{ __('crud.errors.unavailable_feature') }}</h4>
        <p>
            {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost')]) !!}
        </p>
    </div>
@else
    <p class="help-block">
        {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost')]) !!}
    </p>
@endif
