<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

@php
//$appearances = $child->characterTraits()->appearance()->orderBy('default_order')->get();
//$traits = $child->characterTraits()->personality()->orderBy('default_order')->get();

@endphp

<x-sidebar.profile>
    @if ($campaign->enabled('families') && !$child->characterFamilies->isEmpty())
        <div class="element profile-family">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.families')) !!}
                @can('update', $entity)
                    <span role="button" tabindex="0" class="entity-families-icon hover:text-primary" data-toggle="dialog" data-url="{{ route('characters.families.management', [$campaign, $entity->child]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <x-icon class="cog" tooltip title="{{ __('characters.families.title2') }}" />
                    </span>
                @endif
            </div>
            <div class="comma-separated">
                @include('entities.components.profile.character_families')
            </div>
        </div>
    @endif

    @if (!$child->characterRaces->isEmpty() || $child->hasAge())
        @if (!$child->characterRaces->isEmpty() && !$child->hasAge())
        <div class="element profile-race">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!}
                @can('update', $entity)
                    <span role="button" tabindex="0" class="entity-races-icon hover:text-primary" data-toggle="dialog" data-url="{{ route('characters.races.management', [$campaign, $entity->child]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <x-icon class="cog" tooltip title="{{ __('characters.races.title2') }}" />
                    </span>
                @endif
            </div>
            <div class="comma-separated">
                @include('entities.components.profile.character_races')
            </div>
        </div>
        @elseif ($child->characterRaces->isEmpty() && $child->hasAge())
        <div class="element profile-age">
            <div class="title text-uppercase text-xs">{{ __('characters.fields.age') }}</div>
            <span>{{ is_numeric($child->age) ? number_format($child->age) : $child->age }}</span>
        </div>
        @else
        <div class="element profile-race-age">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!}
                @can('update', $entity)
                    <span role="button" tabindex="0" class="entity-races-icon hover:text-primary" data-toggle="dialog" data-url="{{ route('characters.races.management', [$campaign, $child]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <x-icon class="cog" tooltip title="{{ __('characters.races.title2') }}" />
                    </span>
                @endif
                ,
                {{ __('characters.fields.age') }}

            </div>
            <div class="comma-separated inline">
                @include('entities.components.profile.character_races')
            </div>,
            <span>{{ is_numeric($child->age) ? number_format($child->age) : $child->age }}</span>
        </div>
        @endif
    @endif


    @if (!empty($child->sex) || !empty($child->pronouns))
        @if (!empty($child->sex) && empty($child->pronouns))
            <div class="element profile-gender">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.sex') }}</div>
                <span>{!! $child->sex !!}</span>
            </div>
        @elseif (empty($child->sex) && !empty($child->pronouns))
            <div class="element profile-pronouns">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.pronouns') }}</div>
                <span>{!! $child->pronouns !!}</span>
            </div>
        @else
            <div class="element profile-gender-pronouns">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.sex') }}, {{ __('characters.fields.pronouns') }}</div>
                <span>{!! $child->sex !!}</span>,
                <span>{!! $child->pronouns !!}</span>
            </div>
        @endif
    @endif


    @include('entities.components.profile._events')

    @include('entities.components.profile._type')
</x-sidebar.profile>
