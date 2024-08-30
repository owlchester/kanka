<?php /** @var \App\Models\Character $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

@php
//$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
//$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();

@endphp

<x-sidebar.profile>
    @if ($campaign->enabled('families') && !$model->characterFamilies->isEmpty())
        <div class="element profile-family">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.families')) !!}
                @if (auth()->check() && auth()->user()->can('familyManagement', $model))
                    <span role="button" tabindex="0" class="entity-families-icon" data-toggle="dialog" data-url="{{ route('characters.families.management', [$campaign, $model]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <i class="fa-solid fa-pencil" data-title="{{ __('characters.families.title') }}" aria-hidden="true"></i>
                    </span>
                @endif
            </div>
            <div class="comma-separated">
            @php $existingFamilies = []; @endphp
            @foreach ($model->characterFamilies as $family)
                @if(!empty($existingFamilies[$family->family_id]))
                    @continue
                @endif
                @php $existingFamilies[$family->family_id] = true; @endphp
                <span class="element">
                    <x-entity-link
                        :entity="$family->family->entity"
                        :campaign="$campaign" />
                </span>
                @if ($family->is_private) <x-icon class="fa-solid fa-lock" /> @endif
            @endforeach
            </div>
        </div>
    @endif

    @if (!$model->characterRaces->isEmpty() || $model->hasAge())
        @if (!$model->characterRaces->isEmpty() && !$model->hasAge())
        <div class="element profile-race">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!}
                @if (auth()->check() && auth()->user()->can('raceManagement', $model))
                    <span role="button" tabindex="0" class="entity-races-icon" data-toggle="dialog" data-url="{{ route('characters.races.management', [$campaign, $model]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <x-icon class="fa-solid fa-pencil" title="{{ __('characters.races.title', ['name' => $model->name]) }}" tooltip />
                    </span>
                @endif
            </div>
            <div class="comma-separated">
                @include('entities.components.profile.character_races')
            </div>
        </div>
        @elseif ($model->characterRaces->isEmpty() && $model->hasAge())
        <div class="element profile-age">
            <div class="title text-uppercase text-xs">{{ __('characters.fields.age') }}</div>
            <span>{{ $model->age }}</span>
        </div>
        @else
        <div class="element profile-race-age">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!},
                {{ __('characters.fields.age') }}
                @if (auth()->check() && auth()->user()->can('raceManagement', $model))
                    <span role="button" tabindex="0" class="entity-races-icon" data-toggle="dialog" data-url="{{ route('characters.races.management', [$campaign, $model]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <x-icon class="fa-solid fa-pencil" title="{{ __('characters.races.title', ['name' => $model->name]) }}" tooltip />
                    </span>
                @endif
            </div>
            <div class="comma-separated inline">
                @include('entities.components.profile.character_races')
            </div>,
            <span>{{ $model->age }}</span>
        </div>
        @endif
    @endif


    @if (!empty($model->sex) || !empty($model->pronouns))
        @if (!empty($model->sex) && empty($model->pronouns))
            <div class="element profile-gender">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.sex') }}</div>
                <span>{!! $model->sex !!}</span>
            </div>
        @elseif (empty($model->sex) && !empty($model->pronouns))
            <div class="element profile-pronouns">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.pronouns') }}</div>
                <span>{!! $model->pronouns !!}</span>
            </div>
        @else
            <div class="element profile-gender-pronouns">
                <div class="title text-uppercase text-xs">{{ __('characters.fields.sex') }}, {{ __('characters.fields.pronouns') }}</div>
                <span>{!! $model->sex !!}</span>,
                <span>{!! $model->pronouns !!}</span>
            </div>
        @endif
    @endif


    @include('entities.components.profile._events')

    @include('entities.components.profile._type')
</x-sidebar.profile>
