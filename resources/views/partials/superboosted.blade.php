@if(isset($callout) && $callout)
    <x-alert type="info">
        <h4><x-icon class="premium"></x-icon> {{ __('crud.errors.unavailable_feature') }}</h4>
        <p>
            {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to('https://kanka.io/premium', __('crud.superboosted_campaigns'), '#superboosted')]) !!}
        </p>
    </x-alert>
@else
    <x-helper>
        {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to('https://kanka.io/premium', __('crud.superboosted_campaigns'), '#superboosted')]) !!}
    </p>
@endif
