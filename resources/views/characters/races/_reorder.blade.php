<?php /** @var \App\Models\Race[] $races */?>
{{ csrf_field() }}

@if (!$races)
    <x-alert type="warning">
        <p>{{ __('timelines.reorder.empty') }}</p>
    </x-alert>
    <?php return; ?>
@endif
<div class="max-w-4xl box-timeline-reorder flex flex-col gap-5" id="add_attribute_target">
    <div class="element-live-reorder sortable-elements flex flex-col gap-5">
        @foreach($races as $race)
            <div class="element bg-base-200 rounded flex flex-col gap-2 p-2" data-id="{{ $race->race_id }}">
                <input type="hidden" name="character_race[]" value="{{ $race->race_id }}" />
                <div class="dragger pr-3">
                    <span class="fa-solid fa-sort"></span>
                </div>
            <div class="flex flex-wrap md:flex-no-wrap items-start gap-2 md:gap-2 member-row">
                    <x-entities.thumbnail :entity="$race->race->entity" :title="$race->race->name"></x-entities.thumbnail>
                    <x-entity-link
                        :entity="$race->race->entity"
                        :campaign="$campaign" />
                    <div class="">
                        <input type="hidden" name="race_privates[{{ $race->race_id }}]" value="{{ $race->is_private }}" />
                        <i class="fa-solid @if($race->is_private) fa-lock @else fa-unlock-alt @endif" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

