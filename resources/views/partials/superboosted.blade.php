@if(isset($callout) && $callout)
    <x-alert type="info">
        <h4 class="text-lg"><x-icon class="premium" /> {{ __('crud.errors.unavailable_feature') }}</h4>
        <p>
            {!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaigns') . '</a>']) !!}
        </p>
    </x-alert>
@else
    <x-helper>
        <p>{!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaigns') . '</a>']) !!}</p>
    </x-helper>
@endif
