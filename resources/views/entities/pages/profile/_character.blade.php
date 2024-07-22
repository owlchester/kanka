<?php /** @var \App\Models\Character $model */
$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();

?>
    <x-grid type="1/1">
        <x-box css="box-entity-profile grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
            @if ($model->title)
                <p class="entity-character-title">
                    <b>{{ __('characters.fields.title') }}</b><br />
                    {{ $model->title }}
                </p>
            @endif

            @if ($model->type)
                <p class="entity-type">
                    <b>{{ __('crud.fields.type') }}</b><br />
                    {{ $model->type }}
                </p>
            @endif

            @if ($campaign->enabled('races') && !$model->characterRaces->isEmpty())
                @php $existingRaces = []; @endphp
                @foreach ($model->characterRaces as $race)
                    @if(!empty($existingRaces[$race->race_id]))
                        @continue
                    @endif
                    @php $existingRaces[$race->race_id] = true; @endphp
                <p class="entity-race" data-foreign="{{ $race->race_id }}">
                    <b>{{ __('entities.race') }}</b><br />

                    <x-entity-link
                        :entity="$race->race->entity"
                        :campaign="$campaign" />
                </p>
                @endforeach
            @endif
            @if ($campaign->enabled('families') && !$model->characterFamilies->isEmpty())
                @php $existingFamilies = []; @endphp
                @foreach ($model->characterFamilies as $family)
                    @if(!empty($existingFamilies[$family->family_id]))
                        @continue
                    @endif
                    @php $existingFamilies[$family->family_id] = true; @endphp
                    <p class="entity-family" data-foreign="{{ $family->family_id }}">
                        <b>{{ __('entities.families') }}</b><br />
                        <x-entity-link
                            :entity="$family->family->entity"
                            :campaign="$campaign" />
                    </p>
                @endforeach
            @endif

            @if ($model->age || $model->age === '0')
                <p class="entity-age">
                    <b>{{ __('characters.fields.age') }}</b><br />
                    {{ $model->age }}
                </p>
            @endif

            @if ($model->sex)
                <p class="entity-gender">
                    <b>{{ __('characters.fields.sex') }}</b><br />
                    {{ $model->sex }}
                </p>
            @endif

            @if ($model->pronouns)
                <p class="entity-pronouns">
                    <b>{{ __('characters.fields.pronouns') }}</b><br />
                    {{ $model->pronouns }}
                </p>
            @endif
        </x-box>

        @if (count($appearances) > 0)
        <x-box css="character-appearances grid grid-cols-2 gap-5">
            <h4 class="grow col-span-2">{{ __('characters.sections.appearance') }}</h4>
            @foreach ($appearances as $trait)
                <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                    <b>{{ $trait->name }}</b><br />
                    {{ $trait->entry }}
                </p>
            @endforeach
        </x-box>
        @endif

        @if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)
            <x-box css="character-personalities flex flex-col gap-5">

                @if(auth()->check() && auth()->user()->can('personality', $model))
                    <div class="flex gap-2">
                        <h4 class="grow">{{ __('characters.sections.personality') }}</h4>
                        @if (!$model->is_personality_visible)
                            <x-icon class="fa-solid fa-lock" :tooltip="true" :title="__('characters.hints.personality_not_visible')" />
                        @else
                            <x-icon class="fa-solid fa-lock-open" :tooltip="true" :title="__('characters.hints.personality_visible')" />
                        @endif
                    </div>
                @endif

                @foreach ($traits as $trait)
                    <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                        <b>{{ $trait->name }}</b><br />
                        {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                    </p>
                @endforeach
            </x-box>
        @endif
    </x-grid>

    <ul class="m-0 p-0">
        @include('entities.components.elasped_events')
    </ul>


