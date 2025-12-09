<div class="rounded-xl overflow-hidden flex gap-5 items-center bg-box p-2 shadow-xs hover:shadow-xs">
    <div class="flex-initial w-20 h-20 cover-background rounded-xl" style="background-image: url('{{ Img::crop(96, 96)->url($image['path']) }}')">
    </div>
    <div class="grow flex flex-col gap-1">
        <span class="text-lg">
            {!! $entityTypes[$image['type']]->plural() !!}
        </span>
        <span class="text-sm text-neutral-content">
            {{ __('campaigns/default-images.helper') }}
        </span>
    </div>
    @can('recover', $campaign)
        <x-buttons.confirm-delete :route="route('campaign.default-images.delete', $campaign)">
            <input type="hidden" name="entity_type" value="{{ $entityTypes[$image['type']]->id }}" />
        </x-buttons.confirm-delete>
    @endcan
</div>
